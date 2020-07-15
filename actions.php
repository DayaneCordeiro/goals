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
            case 'editGoal':
                $goalData = GoalsController::read(
                    array(
                        'conditions' => ' WHERE id = '.$post['data']['id']
                    )
                );

                $goalData = $goalData[0];
                $finishDate = (!empty($goalData['finish_date'])) ? $goalData['finish_date'] : '%@%';
                $description = (!empty($goalData['description'])) ? $goalData['description'] : '%@%';              
                $price = (!empty($goalData['price'])) ? $goalData['price'] : '%@%';
                $totalMoney = (!empty($goalData['total_money'])) ? $goalData['total_money'] : '%@%';

                $return =   $goalData['id'].';'.
                            $goalData['title'].';'.
                            $description.';'.
                            $price.';'.
                            $finishDate.';'.
                            $totalMoney.';'.
                            $goalData['id_user'];

                // echo "<pre>";
                // print_r($return);
                // echo "</pre>";die();

                echo $return;
            break;
            case 'updateGoal':
                $data = $data['data']['goals'];
                $description = (!empty($data['description'])) ? $data['description'] : 'null';
                $price = (!empty($data['price'])) ? $data['price'] : 'null';
                $finish_date = (!empty($data['finish_date'])) ? $data['finish_date'] : 'null';
                $total_money = (!empty($data['total_money'])) ? $data['total_money'] : 'null';

                $parameters['conditions'] = ' id = '. $data['id'];
                // Atualizacao de titulo
                $parameters['data'] = 'title = "'. $data['title']. '"';
                GoalsController::update($parameters);
                // Atualizacao de description
                $parameters['data'] = 'description = "' . $description. '"';
                GoalsController::update($parameters);
                // Atualizacao de price
                $parameters['data'] = 'price = '. $price;
                GoalsController::update($parameters);
                // Atualizacao de finish_date
                $parameters['data'] = 'finish_date = "'. $finish_date.'"';
                GoalsController::update($parameters);
                // Atualizacao de total_money
                $parameters['data'] =   'total_money = '. $total_money;
                GoalsController::update($parameters);
                

                
                echo '200';
            break;

            default:
            break;
        }

    }
}
?>