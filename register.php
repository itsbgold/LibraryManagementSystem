<?php
require "header.php";
?>
<main>
    <form action="includes/register.inc.php" method="post">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo "<p>Empty Fields!</p>";
            } elseif ($_GET['error'] == "passworderror") {
                echo "<p>Passwords do not match!</p>";
            } elseif ($_GET['error'] == "sqlerror") {
                echo "<p>Internal error! Please Try Again!!</p>";
            } elseif ($_GET['error'] == "invalidemail") {
                echo "<p>Invalid email!</p>";
            } elseif ($_GET['error'] == "emailexists") {
                echo "<p>Email used by some other user!</p>";
            } elseif ($_GET['error'] == "invalidphone") {
                echo "<p>Invalid Phone number!</p>";
            }
        } ?>
        <input type="text" name="firstname" placeholder="Firstname">
        <br>
        <input type="text" name="lastname" placeholder="Lastname"><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="phone" placeholder="Phone"><br>
        <p>Please select your gender:</p>
        <select name="gender">
            <option value="male"> Male</option>
            <option value="female"> Female</option>
            <option value="others"> Other</option>
        </select><br>
        <p>Please select role:</p>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select><br>
        <input type="text" name="address" placeholder="Address"><br>
        <input type="password" name="pwd" placeholder="Password"><br>
        <input type="password" name="pwd2" placeholder="Confirm Password"><br>
        <button type="submit" name="register">Register</button>
    </form>
</main>
<?php
require "footer.php";
?>