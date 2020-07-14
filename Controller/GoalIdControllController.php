<?php
	class GoalIdControllController {
		/*
		** Functionality: Create the goal controll id line on database
		** Parameters: A string with the item data to be inserted
		** Return: No return
		*/
		public static function create($data) {
            require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"INSERT INTO goal_id_controller VALUES(".$data.")");
		    mysqli_close($conn);
		}

		/*
		** Functionality: Read the value saved on database
		** Parameters: An array with the search conditions
		** Return: User id
		*/
		public static function read($id) {
            require dirname(__DIR__). '/config.php';
            
			$sql		= "SELECT * FROM goal_id_controll WHERE user_id = ". $id;
            
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
		** Functionality: Delete the goal controll id line on database
		** Parameters: User id
		** Return: No return
		*/
		public static function delete($id) {
			require dirname(__DIR__). '/config.php';		
		    mysqli_query($conn,"DELETE FROM goal_id controll WHERE user_id = ".$id."");		    
		    mysqli_close($conn);
		}

		/*
		** Functionality: Update the goal controll id line on database
		** Parameters: An array with the data to be updated
		** Return: No return
		*/
		public static function update($parameters) {
			require dirname(__DIR__). '/config.php';	
		    mysqli_query($con,"UPDATE goal_id_controll SET ".$parameters['value']." WHERE user_id = ".$parameters['user_id']);
			if (mysqli_affected_rows($conn) == -1) {
				return mysqli_error($conn);
			} else {
				return mysqli_affected_rows($conn);
			}
			mysqli_close($con);
		}
	}
?>