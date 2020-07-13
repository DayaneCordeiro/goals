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

    //LOGOFF
    $("#logoff").on('click', function(e){
        e.preventDefault();

        const formId  = 'logoff';

        $.ajax({
            type: 'post',
            url: "../actions.php",
            data: {data: {formId: formId}
            },
            success: function(result){
            if (result) {
                if (result == 'Ok!') {
                    location.replace("index.php");
                }
            }
        }});
    });

    // DELETE GOAL
    $('.deleteGoal').on('click', function(e) {
        e.preventDefault();

        var confirmation = confirm('Are you sure to delete this goal?');

        if (confirmation == true) {
            var id = this.id;        
            const formId  = 'deleteGoal';

            $.ajax({
                type: 'post',
                url: "../actions.php",
                data: {data: {formId: formId, id: id}
                },
                success: function(result){
                if (result) {
                    if (result == 'Ok!') {
                        location.replace("main.php");
                    }
                    else {
                        alert(result);
                    }
                }
            }});
        }
    });
});