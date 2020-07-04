<?php
	class GoalItemController {
		/*
		** Functionality: Create a new item on database
		** Parameters: A string with the item data to be inserted
		** Return: No return
		*/
		public static function create($data) {
			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";die();
            require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"INSERT INTO goal_item VALUES(".$data.")");
		    mysqli_close($conn);
		}

		/*
		** Functionality: Read item data
		** Parameters: An array with the search conditions
		** Return: Item data
		*/
		public static function read($parameters = false) {
            require dirname(__DIR__). '/config.php';
            
			$select 	= (!empty($parameters['select'])) ? $parameters['select'] : ' * ';
			$joins 		= (!empty($parameters['joins'])) ? $parameters['joins'] : null;
			$conditions = (!empty($parameters['conditions'])) ? $parameters['conditions'] : null;
			$group 		= (!empty($parameters['group'])) ? $parameters['group'] : null;
			$order 		= (!empty($parameters['order'])) ? $parameters['order'] : null;
			$sql		= "SELECT".$select."FROM goal_Item ". $joins . $conditions . $group . $order;
            
			$query = $conn->query($sql);
			$data = array();
            $i = 0;
            
			while ($row = mysqli_fetch_assoc($query)) {
		        $data[$i] = $row;
		        $i++;
            }
            
		    mysqli_close($conn);
			return $data;
		}

		/*
		** Functionality: Delete a item on database
		** Parameters: Item id
		** Return: No return
		*/
		public static function delete($id) {
			require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"DELETE FROM goal_item WHERE id = ".$id."");		    
		    mysqli_close($conn);
		}

		/*
		** Functionality: Update a Item on database
		** Parameters: An array with the data to be updated
		** Return: No return
		*/
		public static function update($parameters) {
			require dirname(__DIR__). '/config.php';	
		    mysqli_query($con,"UPDATE goal_item SET ".$parameters['data']." WHERE ".$parameters['conditions']);
			if (mysqli_affected_rows($conn) == -1) {
				return mysqli_error($conn);
			} else {
				return mysqli_affected_rows($conn);
			}
			mysqli_close($con);
		}
	}
?>