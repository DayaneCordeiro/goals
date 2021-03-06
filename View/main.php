<?php 
if (!empty($_COOKIE)) {
    $username = $_COOKIE['username'];
    $id       = $_COOKIE['id'];
}
else header("Location: index.php");
    
include 'header.php';
?>
</head>
<body>
    <div class="logoff">
        <button id="logoff" type="button" class="btn btn-danger">Logoff</button>
    </div>

    <div id="interface">
        <h1 id="loginTitle">Hello <?php echo $username ?> 😎️</h1>       

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNewGoal">
            New Goal
        </button>

        <?php 
        // Buscar no banco todos os goals do usuário ativo
        require_once dirname(__DIR__). '/Controller/GoalItemController.php';
        require_once dirname(__DIR__). '/Controller/GoalsController.php';
        require_once dirname(__DIR__). '/Model/GoalsClass.php';

        $goals = GoalsController::read(
            array(
                'select'     => ' * ',
                'conditions' => ' where id_user = '.$id,
                'group'      => ' group by id '
            )
        );
        
        ?>

        <br><br>
        <div class="goals" style="background: gray">
            <?php
            foreach ($goals as $goal) {
            ?>

            <div class="card mycard" id="<?php echo $goal['id']; ?>">
                <div class="card-header">
                    <h3 style="float: left"><?php echo $goal['title'] ?></h3>
                    <div class="card_buttons" style="float: right">
                        <button type="button" id="<?php echo $goal['id'];?>" class="btn btn-primary viewGoal" data-toggle="modal" data-target="#modalViewGoal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        <button type="button" id="<?php echo $goal['id'];?>" class="btn btn-warning editGoal" data-toggle="modal" data-target="#goalEditionModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" id="<?php echo $goal['id'];?>" class="btn btn-danger deleteGoal"><i id="<?php echo $goal['id'];?>" class="fa fa-trash" aria-hidden="true"></i></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $percentage = GoalsClass::calculatesPercentage($goal['id']);
                    ?>
                    <h1 class="percentage"><?php echo number_format($percentage, 1).'%'; ?></h1>
                    <div class="form-row">
                        <input type="number" class="form-control col-md-9" name="data[goals][value]" id="inputNewValue" placeholder="Add value to your goal">
                        <button type="button" id="<?php echo $goal['id'];?>" class="btn btn-success addNewValue"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <?php 
            }
            ?>
        </div>

        <div class="filters">
            <h1>teste</h1>
        </div>

        <!-- Goal Modal -->
        <div class="modal fade bd-example-modal-lg" id="modalNewGoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">New Goal 🎯️</h1>
                        <button type="button" class="close closeGoal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="frmNewGoal" method="post">
                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text" class="form-control" name="data[goals][title]" id="inputTitle" placeholder="Enter your goal title here" required>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea class="form-control" name="data[goals][description]" id="inputDescription" rows="3"></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPrice">Price</label>
                                    <input type="number" class="form-control" name="data[goals][price]" id="inputPrice" placeholder="You can put the price here or in the sub-items">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputFinalDate">Final Date</label>
                                    <input type="date" class="form-control" name="data[goals][finish_date]" id="inputFinalDate" title="Enter the date you want to finish the goal">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPrice">How much money do you already have?</label>
                                    <input type="number" class="form-control" name="data[goals][total_money]" id="inputPrice" placeholder="This will help in calculating the percentage.">
                                </div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNewItem">New Sub-item</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeGoal" data-dismiss="modal">Close</button>
                        <button type="button" id="saveGoal" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Modal -->   
        <div class="modal fade bd-example-modal-lg" id="modalNewItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">New Goal Item 💰️</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="frmNewItem" method="post">
                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text" class="form-control" name="data[goal_item][title]" id="inputTitle" placeholder="Enter your goal title here" required>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea class="form-control" name="data[goal_item][description]" id="inputDescription" rows="3"></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPrice">Price</label>
                                    <input type="number" class="form-control" name="data[goal_item][price]" id="inputPrice" placeholder="To register the item you need to enter the price">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputFinalDate">Final Date</label>
                                    <input type="date" class="form-control" name="data[goal_item][finish_date]" id="inputFinalDate" title="Enter the date you want to finish the goal">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="saveItem" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goal Edition Modal -->
        <div class="modal fade" id="goalEditionModal" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Edit Goal ✍️</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmEditGoal" method="post">
                            <div class="form-group">
                                <label for="inputTitle">Title</label>
                                <input type="text" id="titleEdit" class="form-control" name="data[goals][title]" id="inputTitle" placeholder="Enter your goal title here" required>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea class="form-control" id="descriptionEdit" name="data[goals][description]" id="inputDescription" rows="3"></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputPrice">Price</label>
                                    <input type="number" id="priceEdit" class="form-control" name="data[goals][price]" id="inputPrice" placeholder="You can put the price here or in the sub-items">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputFinalDate">Final Date</label>
                                    <input type="date" id="dateEdit" class="form-control" name="data[goals][finish_date]" id="inputFinalDate" title="Enter the date you want to finish the goal">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputPrice">How much money do you already have?</label>
                                    <input type="number" id="totalMoneyEdit" class="form-control" name="data[goals][total_money]" id="inputPrice" placeholder="This will help in calculating the percentage.">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputId">Id</label>
                                    <input type="number" id="goalId" class="form-control" name="data[goals][id]" id="inputId">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="updateGoal" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goal View Modal -->
        <div class="modal fade" id="modalViewGoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="viewGoalTitle"></h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="titles" id="titleDescription">Description 📝️</h3>
                    <p class="paragraf" id="viewGoalDescription"></p>
                    <h3 class="titles" id="titlePrice">Price 💰️</h3>
                    <p class="paragraf" id="viewGoalPrice"></p>
                    <h3 class="titles" id="titleFinishDate">Final Date 📅️</h3>
                    <p class="paragraf" id="viewGoalFinishDate"></p>
                    <h3 class="titles" id="titleTotalMoney">Total Money 🤑️</h3>
                    <p class="paragraf" id="viewGoalTotalMoney"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

    </div>
<?php
include 'footer.php';
?>
</body>
</html>