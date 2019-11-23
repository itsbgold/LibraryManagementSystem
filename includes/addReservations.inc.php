<?php
if (isset($_POST["reserve-user"])) {
    $textId = $_POST["textId"];
    $userId = $_POST["userId"];
    require 'dbh.inc.php';
    $qry = "INSERT INTO reservation ( user_id, text_id) VALUES
                ($userId, $textId);";
    $retval = mysqli_query($conn, $qry);;
    if (!$retval) {
        die('Failed\n: ' . mysqli_error($conn));
        header("Location: ../index.php?error=sqlerror");
        exit();
    };
    mysqli_close($conn);
    header("Location: ../index.php?success=reservesuccess");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
