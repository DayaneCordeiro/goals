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

        // echo "<pre>";
        // print_r($goals);
        // echo "</pre>";die();

        // Fazer a estrutura de exibição dentro de um foreach
        foreach ($goals as $goal) {
        ?>

        <div class="card bg-info text-white" style="margin-top: 20px;">
            <div class="card-header"><h3><?php echo $goal['title'] ?></h3></div>
            <div class="card-body">
                <?php if($goal['description'] != NULL) { ?>
                    <p class="card-text"><?php echo "DESCRIPTION: ".$goal['description']?></p>
                <?php } ?>

                <?php if($goal['price'] != NULL) { ?>
                    <p class="card-text"><?php echo "PRICE: ".$goal['price']?></p>
                <?php } ?>
                
                <?php if($goal['finish_date'] != NULL) { ?>
                    <p class="card-text"><?php echo "FINAL DATE: ".$goal['finish_date']?></p>
                <?php
                }

                $percentage = GoalsClass::calculatesPercentage($goal['id']);
                ?>
            </div>
        </div>

        <?php 
        }
        ?>

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

    <script>
        $(document).ready(function(){
            //GOAL AJAX
            $("#saveGoal").on('click', function(e){
                e.preventDefault();
                
                const form = $("#frmNewGoal").serialize();
                const formId  = $(this).attr('id');

                $.ajax({
                    type: 'post',
                    url: "../actions.php",
                    data: {data: {allData: form  , formId: formId}
                    },
                    success: function(result){
                    if (result) {
                        if (result == 'Success!') {
                            alert(result);
                            location.replace("main.php");
                        }
                        else alert(result);
                    }
                    else {
                        alert('Creation error, try again.');
                    }
                }});
            });

            //ITEM AJAX
            $("#saveItem").on('click', function(e){
                e.preventDefault();
                
                const form = $("#frmNewItem").serialize();
                const formId  = $(this).attr('id');

                $.ajax({
                    type: 'post',
                    url: "../actions.php",
                    data: {data: {allData: form  , formId: formId}
                    },
                    success: function(result){
                    if (result) {
                        if (result == 'User successfully registered!') {
                            alert(result);
                            //DAR UM JEITO DE FECHAR O MODAL
                        }
                        else alert(result);
                    }
                    else {
                        alert('Creation error, try again.');
                    }
                }});
            });

            //CLOSE MODAL AJAX
            $(".closeGoal").on('click', function(e){
                e.preventDefault();

                const formId  = 'closeGoal';

                $.ajax({
                    type: 'post',
                    url: "../actions.php",
                    data: {data: {formId: formId}
                    },
                    success: function(result){
                    if (result) {
                        if (result == 'Ok!') {
                            location.replace("main.php");
                        }
                    }
                }});
            });
        });
    </script>
</body>
</html>