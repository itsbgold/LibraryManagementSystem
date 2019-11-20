<?php
$page = "login";
require "header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>
                    <form action="includes/login.inc.php" method="post" class="form-signin">
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "emptyfields") {
                                echo "<p class='alert alert-danger' role='alert' >Empty Fields!</p>";
                            } elseif ($_GET['error'] == "wrongpassword") {
                                echo "<p class='alert alert-danger' role='alert' >Wrong Password!</p>";
                            } elseif ($_GET['error'] == "sqlerror") {
                                echo "<p class='alert alert-danger' role='alert' >Internal error! Please Try Again!!</p>";
                            } elseif ($_GET['error'] == "invalidemail") {
                                echo "<p class='alert alert-danger' role='alert' >Invalid email!</p>";
                            } elseif ($_GET['error'] == "emailnotfound") {
                                echo "<p class='alert alert-danger' role='alert' >Email not found!</p>";
                            }
                        }
                        ?>
                        <div class="form-label-group">
                            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputEmail">Email address</label>
                        </div>
                        <div class="form-label-group">
                            <input name="pwd" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>
                        <button name="login-submit" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>