<?php
	require_once dirname(__DIR__). '/Controller/GoalItemController.php';
	
	class GoalItemClass extends GoalItemController{
        
        public static function createItem($parameters) {
            require_once dirname(__DIR__). '/config.php';
            require_once dirname(__DIR__). '/Controller/GoalsController.php';            

            $goalsLineNumbers = GoalsController::read(
                array(
                    'select' => ' COUNT(id) as total '
                )
            );

            $goalId = $goalsLineNumbers[0]['total'] + 1;

            $description = ($parameters['data']['goal_item']['description']) ? '"'.$parameters['data']['goal_item']['description'].'"' : "NULL";
            $finish_date = ($parameters['data']['goal_item']['finish_date']) ? '"'.$parameters['data']['goal_item']['finish_date'].'"' : "DEFAULT";

            $insertion = 'DEFAULT, "'
                        .$parameters['data']['goal_item']['title'].'", '
                        .$description.', '
                        .$parameters['data']['goal_item']['price'].', '
                        .$finish_date.', '
                        .$goalId;

            // echo $insertion;

            // echo "<pre>";
            // print_r($insertion);
            // echo "</pre>";die();


            GoalItemController::create($insertion);               
                
		    return 'Success!';
		}

		public static function deleteItem($id) {
			/* TO DO */
		}

		public static function editItem() {
			/* TO DO */
        }
        
        public static function listItens() {
            /* TO DO */
        }
	}
?>