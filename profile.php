<?php
$page = "profile";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['uid'])) {
    if ($_SESSION["role"] == "admin") {
        $uid = $_GET['uid'];
        if ($uid == $_SESSION["user_id"]) {
            header("Location: profile.php");
            exit();
        }
    } else {
        header("Location: profile.php");
        exit();
    }
} else {
    $uid = $_SESSION['user_id'];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>User Profile</h4>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM user WHERE user_id = $uid ";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "
                                    <div class='col-md-12'>
                                        <div class='form-group row'>
                                            <label for='name' class='col-4 col-form-label'>User ID</label>
                                            <div class='col-8'>
                                            " . $row['user_id'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='name' class='col-4 col-form-label'>Name</label>
                                            <div class='col-8'>
                                            " . $row['firstname'] . " " . $row['lastname'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='email' class='col-4 col-form-label'>Email</label>
                                            <div class='col-8'>
                                            " . $row['email'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='website' class='col-4 col-form-label'>Phone No</label>
                                            <div class='col-8'>
                                            " . $row['phone'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='publicinfo' class='col-4 col-form-label'>Gender</label>
                                            <div class='col-8'>
                                            " . $row['gender'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='publicinfo' class='col-4 col-form-label'>Role</label>
                                            <div class='col-8'>
                                            " . $row['role'] . " </div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='publicinfo' class='col-4 col-form-label'>Address</label>
                                            <div class='col-8'>
                                            " . $row['address'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='newpass' class='col-4 col-form-label'>Fine</label>
                                            <div class='col-8'>
                                            " . $row['fine'] . "</div>
                                        </div>
                                        <div class='form-group row'>
                                            <label for='newpass' class='col-4 col-form-label'>No of Books</label>
                                            <div class='col-8'>
                                            " . $row['no_of_books'] . "</div>
                                    </div>
                                    ";
                            }
                            mysqli_free_result($result);
                        } else {
                            echo "Profile wasn't found.";
                        }
                    } else {
                        echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Issue Details</h4>
                        <hr>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php
                    $sql  = "SELECT A.issue_id, A.start_date, A.due_date, A.reissue_date_1, A.reissue_date_2, A.reissue_no, B.title , B.author, A.user_id, A.text_id FROM issue AS A INNER JOIN text AS B ON A.text_id = B.text_id where user_id=" . $uid . " AND `return_date` IS NULL ";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-hover table-bordered'>";
                            echo '<thead class="thead-dark">';
                            echo "<tr>";
                            echo "<th scope='col'>Book Id</th>";
                            echo "<th scope='col'>Details</th>";
                            echo "<th scope='col'>Issue No.</th>";
                            echo "<th scope='col'>Issue Date</th>";
                            echo "<th scope='col'>Due Date</th>";
                            echo "<th scope='col'>Remarks</th>";
                            echo "</tr>";
                            echo "</thead> ";
                            echo "<tbody> ";
                            while ($row = mysqli_fetch_array($result)) {
                                $data = $row['reissue_no'] + 1;
                                echo "<tr>";
                                echo "<th scope='col'>" . $row['text_id'] . "</td>";
                                echo "<td>" . $row['title'] . " - " . $row['author'] . "</td>";
                                echo "<td> $data </td>";
                                if ($row['reissue_no'] == 0) {
                                    echo "<td>" . date('d/m/Y', strtotime($row['start_date'])) . "</td>";
                                } else if ($row['reissue_no'] == 1) {
                                    echo "<td>" . date('d/m/Y', strtotime($row['reissue_date_1'])) . "</td>";
                                } else {
                                    echo "<td>" . date('d/m/Y', strtotime($row['reissue_date_2'])) . "</td>";
                                }
                                echo "<td>" . date('d/m/Y', strtotime($row['due_date'])) . "</td><td>";
                                if ((int) $row['reissue_no'] < 2) {
                                    $text = "SELECT count(*) FROM reservation WHERE text_id=" . $row['text_id'];
                                    $qresult = mysqli_query($conn, $text);
                                    $val = mysqli_fetch_assoc($qresult);
                                    $count = $val['count(*)'];
                                    if ($count == 0) {
                                        ?>

                                        <form method="post" action="includes/updateIssue.inc.php">
                                            <input type="hidden" name="id" value="<?php echo $row['issue_id']; ?>" />
                                            <input type="hidden" name="reissue" value="<?php echo $row['reissue_no']; ?>" />
                                            <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                                            <button class="btn btn-outline-dark btn-sm" name="reissue-user" type="submit">Re-Issue</button>
                                        </form>
                                    <?php } else { ?>
                                        <strong>Reserved</strong>
                                    <?php }
                                                } else { ?>
                                    <strong>Issue Limit Exceeded</strong>
                                <?php }
                                            if ($_SESSION["role"] == "admin") { ?>
                                    <hr />
                                    <form method="post" action="includes/returnIssue.inc.php">
                                        <input type="hidden" name="id" value="<?php echo $row['issue_id']; ?>" />
                                        <input type="hidden" name="due" value="<?php echo $row['due_date']; ?>" />
                                        <input type="hidden" name="textId" value="<?php echo $row['text_id']; ?>" />
                                        <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                                        <button class="btn btn-outline-danger btn-sm" name="return-user" type="submit">Return</button>
                                    </form>
                                <? } ?>
                                </td>
                                </tr>
                    <? }
                            echo "</tbody> ";
                            echo "</table>";
                            mysqli_free_result($result);
                        } else {
                            echo "No books issued yet.";
                        }
                    } else {
                        echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Reservation Details</h4>
                        <hr>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php
                    $sql  = "SELECT A.resv_id, A.time_of_resv, B.title , B.author, A.text_id FROM reservation AS A INNER JOIN text AS B ON A.text_id = B.text_id where user_id=" . $uid;
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-hover table-bordered'>";
                            echo '<thead class="thead-dark">';
                            echo "<tr>";
                            echo "<th scope='col'>Book Id</th>";
                            echo "<th scope='col'>Details</th>";
                            echo "<th scope='col'>Reservation date</th>";
                            echo "<th scope='col'>Remarks</th>";
                            echo "</tr>";
                            echo "</thead> ";
                            echo "<tbody> ";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<th scope='col'>" . $row['text_id'] . "</td>";
                                echo "<td>" . $row['title'] . " - " . $row['author'] . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['time_of_resv'])) . "</td>";
                                ?>
                                <td>
                                    <form method="post" action="includes/cancelResv.inc.php">
                                        <input type="hidden" name="resv_id" value="<?php echo $row['resv_id']; ?>" />
                                        <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                                        <button class="btn btn-outline-dark btn-sm" name="cancel-resv" type="submit">Cancel</button>
                                    </form>
                                </td>
                                </tr>
                    <? }
                            echo "</tbody> ";
                            echo "</table>";
                            mysqli_free_result($result);
                        } else {
                            echo "No reservations yet.";
                        }
                    } else {
                        echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require "footer.php";
?>