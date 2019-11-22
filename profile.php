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

<?php
require "footer.php";
?>