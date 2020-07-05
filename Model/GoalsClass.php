<?php
	require_once dirname(__DIR__). '/Controller/GoalsController.php';
	
	class GoalsClass extends GoalsController{
        
        public static function createGoal($parameters) {
            require_once dirname(__DIR__). '/config.php';

            if (empty($parameters['data']['goals']['title']))
                return "The title field is mandatory";

            $description = ($parameters['data']['goals']['description']) ? '"'.$parameters['data']['goals']['description'].'"' : "NULL";
            $price       = ($parameters['data']['goals']['price']) ? $parameters['data']['goals']['price'] : "NULL";
            $finish_date = ($parameters['data']['goals']['finish_date']) ? '"'.$parameters['data']['goals']['finish_date'].'"' : "DEFAULT";
            $total_money = ($parameters['data']['goals']['total_money']) ? '"'.$parameters['data']['goals']['total_money'].'"' : "DEFAULT";

            $insertion = 'DEFAULT, "'
                        .$parameters['data']['goals']['title'].'", '
                        .$description.', '
                        .$price.', '
                        .$finish_date.', '
                        .$total_money.', '
                        .$parameters['id_user'];

            GoalsController::create($insertion);               
                
		    return 'Success!';
        }
        
        public static function calculatesPercentage($id_goal) {
            // preco total da goal + preco de cada sub-item
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