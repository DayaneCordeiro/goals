<?php
	require_once dirname(__DIR__). '/Controller/GoalIdControllController.php';
	
	class GoalIdControllClass extends GoalIdControllController {
        
        public static function createUserGoalIdControll($id) {
            $insertion = '0, '.$id;

            GoalIdControllController::create($insertion);       
		    return 'Success!';
        }

		public static function editGoalIdControll($id) {
            $lastId = GoalIdControllController::read($id);
            $data['value'] = $lastId;
            $data['user_id'] = $id;

            GoalIdControllController::update($data);
            return '200';
        }
	}
?>