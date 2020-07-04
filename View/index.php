<?php 
include 'header.php';
?>
<body>
    <div id="container">
        <h1 id="loginTitle">Welcome to Goals</h1>

        <form id="frmLogin" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputEmail4">Username</label>
            <input type="text" class="form-control" id="usernameLogin" name="data[user][username]" placeholder="Username" required>
            </div>
            <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="passwordLogin" name="data[user][password]" placeholder="Password" required>
            </div>
        </div>
        <a href="register.php"><p  id="registerLink">Register</p></a>
        <div id="button">
            <input type="submit" class="btn btn-success" value="Log In"/>
        </div>
        </form>
    </div>
    <?php
    include 'footer.php';
    ?>
    <script>
        $("#frmLogin").submit(function(e) {
            e.preventDefault();

            const form   = $('#frmLogin').serialize();
            const formId = $(this).attr('id');
            
            $.ajax({
                type: 'post',
                url: "../actions.php",
                data: {data: {allData: form, formId: formId}
                },
                success: function(result){
                    if (result) {
                        if (result == 'Valid.') window.location.href = "main.php";
                        else {
                            alert(result);
                        }
                    }
                    else {
                        alert('Login error. Try again!');
                    }
                }
            });
        });
    </script>
</body>
</html>