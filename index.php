<?php
require "header.php";
?>
<main>
    <h2>Welcome to Library Manage System</h2>
    <br>
    <form action="includes/search.inc.php" method="post">
        <p>Choose role</p>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select><br>
        <p>Search by Firstname/Lastname/Email</p>
        <input type="text" name="search">
        <button type="submit" name="login-submit">Show Info</button>
    </form>
</main>
<?php
require "footer.php";
?>