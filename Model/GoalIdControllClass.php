<?php
	require_once dirname(__DIR__). '/Controller/GoalIdControllController.php';
	
	class GoalIdControllClass extends GoalIdControllController {
        public static function editGoalIdControll() {
            $lastId = GoalIdControllController::read();
            $newId  = $lastId[0]['last_goal_id'] + 1;

            GoalIdControllController::update($newId);
            return '200';
        }
	}
?>