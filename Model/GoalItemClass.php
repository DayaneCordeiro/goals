<?php
	require_once dirname(__DIR__). '/Controller/GoalItemController.php';
	
	class GoalItemClass extends GoalItemController{
        
        public static function createItem($parameters) {
            require_once dirname(__DIR__). '/config.php';
            require_once dirname(__DIR__). '/Controller/GoalsController.php';            

            $goalsLastId = GoalIdControllController::read();

            $goalId = $goalsLastId[0]['last_goal_id'] + 1;
            $description = ($parameters['data']['goal_item']['description']) ? '"'.$parameters['data']['goal_item']['description'].'"' : "NULL";
            $finish_date = ($parameters['data']['goal_item']['finish_date']) ? '"'.$parameters['data']['goal_item']['finish_date'].'"' : "DEFAULT";

            $insertion = 'DEFAULT, "'
                        .$parameters['data']['goal_item']['title'].'", '
                        .$description.', '
                        .$parameters['data']['goal_item']['price'].', '
                        .$finish_date.', '
                        .$goalId;

            GoalItemController::create($insertion);               
                
		    return 'Success!';
        }
        
        public static function findLast() {
            return GoalItemController::read(
                array(
                    'select' => 'id_goal',
                    'order'  => ' order by id desc',
                    'limit'  => ' limit 1'
                )
            );
        }

		public static function deleteItens($idGoal) {
            $itens = GoalItemController::read(
                array(
                    'select' => 'id',
                    'conditions' => ' WHERE id_goal = '. $idGoal
                )                
            );

            if (!empty($itens)) {
                foreach ($itens as $item) {
                    GoalItemController::delete($item['id']);
                }
            }         

            // echo "<pre>";
            // print_r($itens);
            // echo "</pre>";die();
		}

		public static function editItem() {
			/* TO DO */
        }
        
        public static function listItens() {
            /* TO DO */
        }
	}
?>