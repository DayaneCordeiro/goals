<?php

if (!empty($_POST['data']['allData'])) parse_str($_POST['data']['allData'], $data);
if (!empty($_POST)) {
    $post = $_POST;    

    if ($post['data']['formId']) {
        require 'Model/UserClass.php';
        require 'Model/GoalsClass.php';
        require 'Model/GoalItemClass.php';
        require 'Model/GoalIdControllClass.php';
        require_once 'Controller/GoalsController.php';
        require_once 'Controller/GoalItemController.php';
    
        switch ($post['data']['formId']) {
            case 'frmNewUser':
                $result = UserClass::registerUser($data['data']);

                // echo "<pre>";
                // print_r($lastUserId);
                // echo "</pre>";die();

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
                if (!empty($goal)) echo "Ok!";
                else {
                    GoalItemController::deleteByGoalId($lastGoalId);
                    echo "Ok!";
                }
            break;
            case 'logoff':
                $result = UserClass::logoff();
                echo $result;
            break;
            case 'deleteGoal':
                GoalItemClass::deleteItens($post['data']['id']);
                GoalsClass::deleteGoal($post['data']['id']);                
                echo 'Ok!';
            break;

            default:
            break;
        }

    }
}
?>