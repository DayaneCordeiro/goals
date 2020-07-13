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
            require_once dirname(__DIR__). '/Controller/GoalItemController.php';

            $sub_itens = GoalItemController::read(
                array(
                    'select'     => ' SUM(price) as total',
                    'conditions' => ' WHERE id_goal = '.$id_goal
                )
            );
            
            $goal_information = GoalsController::read(
                array(
                    'select'     => ' price, total_money ',
                    'conditions' => ' WHERE id = '.$id_goal
                )
            );

            $total      = $sub_itens[0]['total'] + $goal_information[0]['price'];
            $money      = $goal_information[0]['total_money'];
            $percentage = ($total > 0) ? ($money * 100) / $total : 0;
            
            return $percentage;
        }

		public static function deleteGoal($id) {
			GoalsController::delete($id);
		}

		public static function editItem() {
			/* TO DO */
        }
        
        public static function listItens() {
            /* TO DO */
        }
	}
?>