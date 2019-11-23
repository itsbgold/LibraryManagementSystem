<?php
if (isset($_POST["cancel-resv"])) {
    $resv_id = $_POST["resv_id"];
    require 'dbh.inc.php';
    $qry = "DELETE from reservation WHERE resv_id = $resv_id ";
    mysqli_query($conn, $qry);
    mysqli_close($conn);
    if (isset($_POST["uid"])) {
        $uid = $_POST["uid"];
        header("Location: ../profile.php?success=cancelsuccess&uid=" . $uid);
    } else {
        header("Location: ../reservations.php?success=cancelsuccess");
    }
    exit();
} else {
    header("Location: ../reservations.php");
    exit();
}
