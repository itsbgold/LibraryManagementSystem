<?php
if (isset($_POST["cancel-resv"])) {
    $resv_id = $_POST["resv_id"];
    $uid = $_POST["uid"];
    require 'dbh.inc.php';
    $qry = "DELETE from reservation WHERE resv_id = $resv_id ";
    mysqli_query($conn, $qry);
    mysqli_close($conn);
    header("Location: ../profile.php?success=cancelsuccess&uid=" . $uid);
    exit();
} else {
    header("Location: ../profile.php");
    exit();
}
