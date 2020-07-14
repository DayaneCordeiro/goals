<?php
	class GoalIdControllController {
		/*
		** Functionality: Read the value saved on database
		** Parameters: An array with the search conditions
		** Return: The table value
		*/
		public static function read() {
            require dirname(__DIR__). '/config.php';
            
			$sql		= "SELECT * FROM goal_id_controll";
            
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
		** Functionality: Update the goal controll id line on database
		** Parameters: An array with the data to be updated
		** Return: No return
		*/
		public static function update($value) {
			// echo "<pre>";
            // print_r($value);
			// echo "</pre>";die();
			
			require dirname(__DIR__). '/config.php';	
		    mysqli_query($conn,"UPDATE goal_id_controll SET last_goal_id = ".$value."");
			if (mysqli_affected_rows($conn) == -1) {
				return mysqli_error($conn);
			} else {
				return mysqli_affected_rows($conn);
			}
			mysqli_close($con);
		}
	}
?>