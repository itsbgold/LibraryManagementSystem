<?php
require "header.php";
?>
<main>
    <form action="includes/login.inc.php" method="post">
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="pwd" placeholder="Password"><br>
        <button type="submit" name="login-submit">Login</button>
    </form>
</main>

<?php
require "footer.php";
?>