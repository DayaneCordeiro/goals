<?php

if (!empty($_POST['data']['allData'])) parse_str($_POST['data']['allData'], $data);
if (!empty($_POST)) {
    $post = $_POST;

    if ($post['data']['formId']) {
        require 'Model/UserClass.php';
        require 'Model/GoalsClass.php';
        require 'Model/GoalItemClass.php';
        require_once 'Controller/GoalsController.php';
        require_once 'Controller/GoalItemController.php';
    
        switch ($post['data']['formId']) {
            case 'frmNewUser':
                $result = UserClass::registerUser($data['data']);
                echo $result;
            break;
            case 'frmLogin':              
                $result = UserClass::login($data);
                echo $result;
            break;
            case 'saveGoal':
                $data['id_user'] = $_COOKIE['id'];
                $result = GoalsClass::createGoal($data);
                echo $result;
            break;
            case 'saveItem':
                $data['id_user'] = $_COOKIE['id'];
                $result = GoalItemClass::createItem($data);
                echo $result;
            break;
            case 'closeGoal':
                $lastGoalId = GoalItemClass::findLast()[0]['id_goal'];
                $goal       = GoalsController::read(
                    array(
                        'conditions' => ' WHERE id = '.$lastGoalId
                    )
                );
                // echo "<pre>";
                // print_r($goal);
                // echo "</pre>";die();

                if (!empty($goal)) {
                    echo "Ok!";
                }
                else {
                    GoalItemController::deleteByGoalId($lastGoalId);
                    echo "Ok!";
                }
            break;
            default:
            break;
        }

    }
}
?>