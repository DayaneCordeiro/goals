<?php
	require_once dirname(__DIR__). '/Controller/UserController.php';
	
	class UserClass extends UserController{
		/*
		** Functionality: Creates a new User on database
		** Parameters: An array with the data to be inserted
		** Return: Success message
		*/
		public static function registerUser($parameters) {
            require_once dirname(__DIR__). '/config.php';
            
			$queryEmail['conditions'] = ' WHERE email = "'.$parameters['user']['email'].'"';
			$searchEmail = UserController::read($queryEmail);

			$queryUsername['conditions'] = ' WHERE username = "'.$parameters['user']['username'].'"';
            $searchUsername = UserController::read($queryUsername);

		    if (!empty($searchEmail)) {
			    return 'This E-mail has already been registered previously.';
		    }
		    elseif (!empty($searchUsername)) {
		    	return 'This Username is not available.';
		    }
		    else {
                $insertion = 'DEFAULT, "'.$parameters['user']['email'].'", "'.$parameters['user']['username'].'", "'.$parameters['user']['password'].'"';
                UserController::create($insertion);               
                
		    	return 'User successfully registered!';
		    }
		}

		/*
		** Functionality: Delete a user from database
		** Parameters: User id
		** Return: Sucess message
		*/
		public static function removerUser($id) {
			UserController::delete($id);
			return 'User removed successfully';
		}

		/*
		** Functionality: Do user login
		** Parameters: An array with the user data to be checked
		** Return: Validation message
		*/
		public static function login($parameters) {
			$query['select'] 		= ' * ';
			$query['conditions'] 	= ' WHERE user.username = "'.$parameters['data']['user']['username'].'" AND user.password = "'. $parameters['data']['user']['password'].'"';

			$result = UserController::read($query);

			// echo "<pre>";
            // print_r($result);
            // echo "</pre>";
            // die();

			if (!empty($result)) {
				setcookie('id', $result[0]['id']);
				setcookie('username', $result[0]['username']);

				return 'Valid.';
			}
			
			return 'Incorrect data, check and try again.';
		}		

		/*
		** Functionality: Do user logoff
		** Parameters: No parameters
		** Return: No return
		*/
        public static function logoff() {
            setcookie('id');
            setcookie('username');

            return 'Ok!';
        }
	}
?>