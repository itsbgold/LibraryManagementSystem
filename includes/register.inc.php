<?php

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['register'])) {
    require 'dbh.inc.php';
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $role = $_POST["role"];
    $address = $_POST["address"];
    $pwd = $_POST["pwd"];
    $pwd2 = $_POST["pwd2"];

    if (empty($email) || empty($firstname) || empty($lastname) || empty($phone) || empty($gender) || empty($role) || empty($address) || empty($pwd) || empty($pwd2)) {
        header("Location:../register.php?error=emptyfields&firstname=" . $firstname . "&lastname=" . $lastname . "&email=" . $email . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidemail&firstname=" . $firstname . "&lastname=" . $lastname . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
        exit();
    } else if (!preg_match("/^[0-9]*$/", $phone)) {
        header("Location: ../register.php?error=invalidphone&firstname=" . $firstname . "&lastname=" . $lastname . "&email=" . $email . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
        exit();
    } else if ($pwd !== $pwd2) {
        header("Location: ../register.php?error=passworderror&firstname=" . $firstname . "&lastname=" . $lastname . "&email=" . $email . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
        exit();
    } else {
        $qry = "SELECT * FROM `user` WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $qry)) {
            header("Location:../register.php?error=sqlerror&firstname=" . $firstname . "&lastname=" . $lastname . "&email=" . $email . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result(($stmt));
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0) {
                header("Location: ../register.php?error=emailexists&firstname=" . $firstname . "&lastname=" . $lastname . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
                exit();
            } else {
                $qry = "INSERT INTO user ( firstname, lastname, email, phone, address, password, role, gender) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?);";

                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $qry)) {
                    header("Location:../register.php?error=sqlerror&firstname=" . $firstname . "&lastname=" . $lastname . "&email=" . $email . "&phone=" . $phone . "&gender=" . $gender . "&role=" . $role . "&address=" . $address);
                    exit();
                } else {
                    $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $lastname, $email, $phone, $address, $pwdhash, $role, $gender);
                    mysqli_stmt_execute($stmt);
                    header("Location:../searchmember.php?success=membersuccess");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../login.php");
    exit();
}
