<?php 
include 'header.php';
?>
<body>
    <div id="container">
        <h1 id="loginTitle">Welcome to Goals</h1>

        <form>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputEmail4">Username</label>
            <input type="text" class="form-control" id="usernameLogin" name="data[user][username]" placeholder="Username">
            </div>
            <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="passwordLogin" name="data[user][password]" placeholder="Password">
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

    </body>
</html>