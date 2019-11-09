<?php
require "header.php";
?>
<main>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="pwd" placeholder="Password"><br>
        <button type="submit" name="login">Login</button>
    </form>
</main>

<?php
if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["pwd"];

    $qry = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $qry);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['password'];
        }
    } else {
        echo "<p>User doesn't exist";
    }
}

require "footer.php";
?>