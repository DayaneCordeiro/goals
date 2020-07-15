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

    /*
    ** Functionality: Send Informations By Ajax to edit a Goal
    ** Parameters: Event
    ** Return: No return
    */
   $('.editGoal').on('click', function(e) {
        e.preventDefault();
        
        var id = this.id;        
        const formId  = 'editGoal';

        $.ajax({
            type: 'post',
            url: "../actions.php",
            data: {data: {formId: formId, id: id}
            },
            success: function(result){
            if (result) {
                var dataResult = result.split(';');
                console.log(dataResult)

                if (dataResult[4] != '%@%') {
                    var date = dataResult[4].split(' ');
                }

                $('#titleEdit').val(dataResult[1]);
                if (dataResult[2] != '%@%') $('#descriptionEdit').val(dataResult[2]);
                if (dataResult[3] != '%@%') $('#priceEdit').val(dataResult[3]);
                if (dataResult[4] != '%@%') $('#dateEdit').val(date[0]);
                if (dataResult[5] != '%@%') $('#totalMoneyEdit').val(dataResult[5]);
                $('#goalId').val(dataResult[0]);
                $("#goalId").prop('disabled', true);
            }
            else {
                alert('Error: Try again!')
            }
        }});
    
    });

    /*
    ** Functionality: Send Informations By Ajax to update a Goal
    ** Parameters: Event
    ** Return: No return
    */
    $("#updateGoal").on('click', function(e){
        e.preventDefault();

        $('#goalId').prop('disabled', false);

        const form = $("#frmEditGoal").serialize();
        const formId  = $(this).attr('id');

        $.ajax({
            type: 'post',
            url: "../actions.php",
            data: {data: {allData: form  , formId: formId}
            },
            success: function(result){
            if (result) {
                if (result == '200') {
                    location.replace("main.php");
                }
            }
            else {
                alert('Creation error, try again.');
            }
        }});
    });

    /*
    ** Functionality: Send Informations By Ajax to add new values to a Goal
    ** Parameters: Event
    ** Return: No return
    */
    $(".addNewValue").on('click', function(e){
        e.preventDefault();

        const formId = 'addNewValue';
        var newValue = $('#inputNewValue').val();
        var goalId   = this.id;

        $.ajax({
            type: 'post',
            url: "../actions.php",
            data: {data: {formId: formId, id_goal: goalId, addValue: newValue}
            },
            success: function(result){
            if (result) {
                if (result == '200') {
                    location.replace("main.php");
                }
            }
            else {
                alert('Failed to try to add, please try again.');
            }
        }});
    });
    
    /*
    ** Functionality: Send Informations By Ajax to show the Goal Informations
    ** Parameters: Event
    ** Return: No return
    */
   $('.viewGoal').on('click', function(e) {
        e.preventDefault();
        
        var id = this.id;        
        const formId  = 'viewGoal';

        $.ajax({
            type: 'post',
            url: "../actions.php",
            data: {data: {formId: formId, id: id}
            },
            success: function(result){
            if (result) {
                var dataResult = result.split(';');
                console.log(dataResult)

                $('#viewGoalTitle').text(dataResult[0]);

                if (dataResult[1] == '%@%') {
                    $('#titleDescription').hide();
                    $('#viewGoalDescription').hide();
                }
                else {
                    $('#viewGoalDescription').text(dataResult[1]);
                }

                if (dataResult[2] == '%@%') {
                    $('#titlePrice').hide();
                    $('#viewGoalPrice').hide();
                }
                else {
                    $('#viewGoalPrice').text(dataResult[2]);
                }

                if (dataResult[3] == '%@%') {
                    $('#titleFinishDate').hide();
                    $('#viewGoalFinishDate').hide();
                }
                else {
                    $('#viewGoalFinishDate').text(dataResult[3]);
                }

                if (dataResult[4] == '%@%') {
                    $('#titleTotalMoney').hide();
                    $('#viewGoalTotalMoney').hide();
                }
                else {
                    $('#viewGoalTotalMoney').text(dataResult[4]);
                }
            }
            else {
                alert('Error: Try again!')
            }
        }});
    
    });
});