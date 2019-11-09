<?php
if (isset($_POST['login-submit'])) {
    require 'dbh.inc.php';
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    if (empty($email) || empty($pwd)) {
        header("Location:../login.php?error=emptyfields&email=" . $email);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?error=invalidemail");
        exit();
    } else {
        $qry = "SELECT * FROM `user` WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $qry)) {
            header("Location:../login.php?error=sqlerror&email=" . $email);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result(($stmt));
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdcheck = password_verify($pwd, $row['password']);
                if ($pwdcheck == false) {
                    header("Location:../login.php?error=wrongpassword&email=" . $email);
                    exit();
                } else if ($pwdcheck == true) {
                    session_start();
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['role'] = $row['role'];
                    header("Location:../index.php?login=success");
                    exit();
                } else {
                    header("Location:../login.php?error=wrongpassword&email=" . $email);
                    exit();
                }
            } else {
                header("Location:../login.php?error=emailnotfound");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../login.php");
    exit();
}
