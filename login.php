<?php
require "header.php";
?>
<main>
    <form action="includes/login.inc.php" method="post">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo "<p>Empty Fields!</p>";
            } elseif ($_GET['error'] == "wrongpassword") {
                echo "<p>Wrong Password!</p>";
            } elseif ($_GET['error'] == "sqlerror") {
                echo "<p>Internal error! Please Try Again!!</p>";
            } elseif ($_GET['error'] == "invalidemail") {
                echo "<p>Invalid email!</p>";
            } elseif ($_GET['error'] == "emailnotfound") {
                echo "<p>Email not found!</p>";
            }
        }
        ?>
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="pwd" placeholder="Password"><br>
        <button type="submit" name="login-submit">Login</button>
    </form>
</main>

<?php
require "footer.php";
?>