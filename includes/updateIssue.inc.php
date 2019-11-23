<?php
if (isset($_POST["reissue-user"])) {
    require 'dbh.inc.php';
    $id = $_POST['id'];
    $uid = $_POST['uid'];
    $reissue = (int) $_POST['reissue'];
    echo $reissue;
    if ($reissue == 0) {
        $qry = "UPDATE issue SET reissue_date_1 = CURRENT_TIMESTAMP, reissue_no = reissue_no + 1, due_date = DATE_ADD(NOW(), INTERVAL 15 DAY) WHERE issue_id = $id ";
    } else if ($reissue == 1) {
        $qry = "UPDATE issue SET reissue_date_2 = CURRENT_TIMESTAMP, reissue_no = reissue_no + 1, due_date = DATE_ADD(NOW(), INTERVAL 15 DAY) WHERE issue_id = $id ";
    }
    $retval = mysqli_query($conn, $qry);
    if (!$retval) {
        die('FAILED\n: ' . mysqli_error($conn));
    } else {
        header("Location: ../profile.php?success=issuesuccess&uid=" . $uid);
    }
    mysqli_close($conn);
    exit();
} else {
    header("Location: ../profile.php");
    exit();
}
