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
        <div class="goals" style="background: yellow">
            <?php
            foreach ($goals as $goal) {
            ?>

            <div class="card mycard col-md-6" id="<?php echo $goal['id']; ?>">
                <div class="card-header"><h3><?php echo $goal['title'] ?></h3></div>
                <div class="card-body">
                    <?php
                    $percentage = GoalsClass::calculatesPercentage($goal['id']);
                    ?>
                    <h1 class="percentage"><?php echo $percentage.'%'; ?></h1>
                    <div class="card_buttons">
                        <button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" id="<?php echo $goal['id'];?>" class="btn btn-danger"><i id="<?php echo $goal['id'];?>" class="fa fa-trash deleteGoal" aria-hidden="true"></i></i></button>
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
                        <h1 class="modal-title" id="exampleModalLabel">New Goal 🎯️</h1>
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

    </div>
<?php
include 'footer.php';
?>
</body>
</html>