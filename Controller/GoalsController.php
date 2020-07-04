<?php
	class GoalsController {
		/*
		** Functionality: Create a new goal on database
		** Parameters: A string with the goal data to be inserted
		** Return: No return
		*/
		public static function create($data) {
            require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"INSERT INTO goals VALUES(".$data.")");
		    mysqli_close($conn);
		}

		/*
		** Functionality: Read goal data
		** Parameters: An array with the search conditions
		** Return: Goal data
		*/
		public static function read($parameters = false) {
            require dirname(__DIR__). '/config.php';
            
			$select 	= (!empty($parameters['select'])) ? $parameters['select'] : ' * ';
			$joins 		= (!empty($parameters['joins'])) ? $parameters['joins'] : null;
			$conditions = (!empty($parameters['conditions'])) ? $parameters['conditions'] : null;
			$group 		= (!empty($parameters['group'])) ? $parameters['group'] : null;
			$order 		= (!empty($parameters['order'])) ? $parameters['order'] : null;
			$sql		= "SELECT".$select."FROM goals ". $joins . $conditions . $group . $order;
            
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
		** Functionality: Delete a goal on database
		** Parameters: Goal id
		** Return: No return
		*/
		public static function delete($id) {
			require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"DELETE FROM goals WHERE id = ".$id."");		    
		    mysqli_close($conn);
		}

		/*
		** Functionality: Update a goal on database
		** Parameters: An array with the data to be updated
		** Return: No return
		*/
		public static function update($parameters) {
			require dirname(__DIR__). '/config.php';	
		    mysqli_query($con,"UPDATE goals SET ".$parameters['data']." WHERE ".$parameters['conditions']);
			if (mysqli_affected_rows($conn) == -1) {
				return mysqli_error($conn);
			} else {
				return mysqli_affected_rows($conn);
			}
			mysqli_close($con);
		}
	}
?>