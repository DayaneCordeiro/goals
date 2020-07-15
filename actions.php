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

                echo $return;
            break;
            case 'updateGoal':
                $data = $data['data']['goals'];
                $description = (!empty($data['description'])) ? $data['description'] : 'null';
                $price = (!empty($data['price'])) ? $data['price'] : 'null';
                $finish_date = (!empty($data['finish_date'])) ? $data['finish_date'] : 'null';
                $total_money = (!empty($data['total_money'])) ? $data['total_money'] : 'null';

                $parameters['conditions'] = ' id = '. $data['id'];
                $parameters['data'] = 'title = "'. $data['title']. '"';
                GoalsController::update($parameters);
                $parameters['data'] = 'description = "' . $description. '"';
                GoalsController::update($parameters);
                $parameters['data'] = 'price = '. $price;
                GoalsController::update($parameters);
                $parameters['data'] = 'finish_date = "'. $finish_date.'"';
                GoalsController::update($parameters);
                $parameters['data'] =   'total_money = '. $total_money;
                GoalsController::update($parameters);

                echo '200';
            break;
            case 'addNewValue':
                $currentValue = GoalsController::read(
                    array(
                        'select'        => ' total_money ',
                        'conditions'    => ' WHERE id = '. $post['data']['id_goal']
                    )
                );

                $totalValue = $currentValue[0]['total_money'] + $post['data']['addValue'];
                // updata a coluna no banco
                $parameters['data'] = ' total_money = '. $totalValue;
                $parameters['conditions'] = ' id = '. $post['data']['id_goal'];

                GoalsController::update($parameters);

                echo '200';
            break;
            case 'viewGoal':
                $goalInformations = GoalsController::read(
                    array(
                        'conditions' => ' WHERE id = '.$post['data']['id']
                    )
                );

                $goalInformations = $goalInformations[0];

                $description = (!empty($goalInformations['description'])) ? $goalInformations['description'] : '%@%';
                $price       = (!empty($goalInformations['price']))       ? $goalInformations['price']       : '%@%';
                $finish_date = (!empty($goalInformations['finish_date'])) ? $goalInformations['finish_date'] : '%@%';
                $total_money = (!empty($goalInformations['total_money'])) ? $goalInformations['total_money'] : '%@%';

                $return =   $goalInformations['title'].';'.
                            $description.';'.
                            $price.';'.
                            $finish_date.';'.
                            $total_money;

                echo $return;

                // echo "<pre>";
                // print_r($return);
                // echo "</pre>";die();
            break;
            default:
            break;
        }

    }
}
?>