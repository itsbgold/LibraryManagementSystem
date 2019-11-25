<?php
if (isset($_POST["fine-user"])) {
    require 'dbh.inc.php';
    $uid = $_POST['uid'];
    $qry = "UPDATE user SET fine = 0 WHERE user_id = $uid ";
    $retval = mysqli_query($conn, $qry);
    if (!$retval) {
        die('FAILED\n: ' . mysqli_error($conn));
    } else {
        header("Location: ../profile.php?success=finesuccess&uid=" . $uid);
    }
    mysqli_close($conn);
    exit();
} else {
    header("Location: ../profile.php");
    exit();
}
