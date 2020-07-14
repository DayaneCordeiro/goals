$(document).ready(function(){
    /*
    ** Functionality: Send Informations By Ajax to create a new Goal
    ** Parameters: Event
    ** Return: No return
    */
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

    /*
    ** Functionality: Send Informations By Ajax to creat a new Item
    ** Parameters: Event
    ** Return: No return
    */
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
                if (result == 'Success!') {
                    $("#modalNewItem").modal('hide');
                }
                else alert(result);
            }
            else {
                alert('Creation error, try again.');
            }
        }});
    });

    /*
    ** Functionality: Send Informations By Ajax to close Goal Modal and refresh page
    ** Parameters: Event
    ** Return: No return
    */
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

    /*
    ** Functionality: Send Informations By Ajax to logoff user
    ** Parameters: Event
    ** Return: No return
    */
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

    /*
    ** Functionality: Send Informations By Ajax to delete a Goal
    ** Parameters: Event
    ** Return: No return
    */
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

    /*
    ** Functionality: Clear the New Item modal when it's closed
    ** Parameters: No parameters
    ** Return: No return
    */
    $('.modal').on('hidden.bs.modal', function() {
        $('#frmNewItem')[0].reset();
    });
});