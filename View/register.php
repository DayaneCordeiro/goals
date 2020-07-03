<?php 
include 'header.php';
?>
</head>
<body>
    <div id="interface">
        <div id="container">
            <h1 id="loginTitle">Register</h1>

            <form id="frmNewUser" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Username</label>
                    <input type="text" class="form-control" name="data[user][username]" id="usernameRegister" placeholder="User" required>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" name="data[user][password]" id="inputPassword4" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">E-mail</label>
                    <input type="email" class="form-control" name="data[user][email]" id="emailRegister" placeholder="E-mail" required>
                </div>
                <div id="button">
                    <input type="submit" class="btn btn-success" value="register">
                </div>
            </form>
        </div>
    </div>
<?php
include 'footer.php';
?>

    <script>
        $(document).ready(function(){
            //REGISTER AJAX
            $("#frmNewUser").submit(function(e){
                e.preventDefault();
                
                const form = $("#frmNewUser").serialize();
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
                            location.replace("index.php");
                        }
                        else alert(result);
                    }
                    else {
                        alert('Registration error, try again.');
                    }
                }});
            });

            //AJAX DO LOGIN
            // $("#frmLogin").submit(function(e) {
            //     e.preventDefault();

            //     const form        = $('#frmLogin').serialize();
            //     const formulario  = $(this).attr('id');
                
            //     $.ajax({
            //         type: 'post',
            //         url: "../actions.php",
            //         data: {data: {dados: form, formulario: formulario}
            //         },
            //         success: function(result){
            //             if (result) {
            //                 if (result == 'Dados válidos.') window.location.href = "main.php";
            //                 else {
            //                     showMsgLogin(result);
            //                 }
            //             }
            //             else {
            //                 showMsgLogin('erro');
            //             }
            //         }
            //     });
            // });
        });
    </script>
</body>
</html>