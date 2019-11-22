<?php
$page = "profile";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Your Profile</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">

                        <?php
                        $uid = $_SESSION["user_id"];
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
</div>

<div class="table-responsive">
    <?php
    $sql  = "SELECT A.issue_id, A.start_date, A.due_date, A.reissue_date_1, A.reissue_date_2, A.reissue_no, B.title , B.author, A.user_id, A.text_id FROM issue AS A INNER JOIN text AS B ON A.text_id = B.text_id where user_id=" . $_SESSION["user_id"] . " AND `return_date` IS NULL ";
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
            echo "<th scope='col'>Actions</th>";
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
                    echo "<td>" . date('m/d/Y', strtotime($row['start_date'])) . "</td>";
                } else if ($row['reissue_no'] == 1) {
                    echo "<td>" . date('d/m/Y', strtotime($row['reissue_date_1'])) . "</td>";
                } else {
                    echo "<td>" . date('d/m/Y', strtotime($row['reissue_date_2'])) . "</td>";
                }
                echo "<td>" . date('m/d/Y', strtotime($row['due_date'])) . "</td>";
                if ((int) $row['reissue_no'] < 2) {
                    $text = "SELECT count(*) FROM reservation WHERE text_id=" . $row['text_id'];
                    $qresult = mysqli_query($conn, $text);
                    $val = mysqli_fetch_assoc($qresult);
                    $count = $val['count(*)'];
                    if ($count == 0) {
                        ?>
                        <td>
                            <form method="post" action="includes/updateIssue.inc.php">
                                <input type="hidden" name="id" value="<?php echo $row['issue_id']; ?>" />
                                <input type="hidden" name="reissue" value="<?php echo $row['reissue_no']; ?>" />
                                <button class="btn btn-outline-dark btn-sm" name="reissue-user" type="submit">Re-Issue</button>
                            </form>
                        </td>
                    <?php } else { ?>
                        <td>
                            <strong>Reserved</strong>
                        </td>
                    <?php }
                                } else { ?>
                    <td>
                        <strong>Issue Limit Exceeded</strong>
                    </td>
    <?php }
                echo "</tr>";
            }
            echo "</tbody> ";
            echo "</table>";
            mysqli_free_result($result);
        } else {
            echo "No records matching your query were found.";
        }
    } else {
        echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
    }
    ?>
</div>

<?php
require "footer.php";
?>