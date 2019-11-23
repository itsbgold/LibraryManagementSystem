<?php
$page = "addIssues";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Search and Issue Books</h4>
                        <hr>
                    </div>
                </div>
                <form class="form-row" action="addIssues.php" method="get">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="staticUser" class="input-group-text">User Id</label>
                            </div>
                            <input type="number" required class="form-control" name="user_id" id="staticUser" placeholder="Enter user id...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="staticText" class="input-group-text">Book Id</label>
                            </div>
                            <input type="number" required class="form-control" name="text_id" id="staticText" placeholder="Enter the book id..." aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-dark" name="search-issue-submit" type="submit" id="button-addon2">Show Info</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                if (isset($_GET["search-issue-submit"])) {
                                    $textId = $_GET["text_id"];
                                    $userId = $_GET["user_id"];
                                    $sql = "SELECT * FROM user WHERE user_id = $userId ";
                                    $sql2 = "SELECT * FROM text WHERE text_id = $textId ";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) { ?>
                                        <div class='col-md-6'>
                                            <div class='card'>
                                                <div class='card-body'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <h4>User Profile</h4>
                                                            <hr>
                                                        </div>
                                                        <?php
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_array($result)) {
                                                                        echo "
                                                        <div class='col-md-12'>
                                                            <div class='form-group row'>
                                                                <label for='name' class='col-6 col-form-label'>User ID</label>
                                                                <div class='col-6'>
                                                                " . $row['user_id'] . "</div>
                                                            </div>
                                                            <div class='form-group row'>
                                                                <label for='name' class='col-6 col-form-label'>Name</label>
                                                                <div class='col-6'>
                                                                " . $row['firstname'] . " " . $row['lastname'] . "</div>
                                                            </div>
                                                            <div class='form-group row'>
                                                                <label for='newpass' class='col-6 col-form-label'>Fine</label>
                                                                <div class='col-6'>
                                                                " . $row['fine'] . "</div>
                                                            </div>
                                                            <div class='form-group row'>
                                                                <label for='newpass' class='col-6 col-form-label'>No of Books</label>
                                                                <div class='col-6'>
                                                                " . $row['no_of_books'] . "</div>
                                                            </div>
                                                        </div>
                                                        ";
                                                                    }
                                                                } else {
                                                                    echo "Profile wasn't found.";
                                                                }
                                                                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                                if ($result2 = mysqli_query($conn, $sql2)) { ?>
                                            <div class='col-md-6'>
                                                <div class='card'>
                                                    <div class='card-body'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <h4>Book Details</h4>
                                                                <hr>
                                                            </div>
                                                            <?php
                                                                        if (mysqli_num_rows($result2) > 0) {
                                                                            while ($row = mysqli_fetch_array($result2)) {
                                                                                if ($row['book_state'] != "free") {
                                                                                    $sql3  = "SELECT B.`firstname` , B.`lastname`, A.user_id, A.text_id FROM `issue` AS A INNER JOIN `user` AS B ON A.user_id = B.user_id where text_id=$textId and `return_date` IS NULL ";
                                                                                    if ($result3 = mysqli_query($conn, $sql3)) {
                                                                                        if (mysqli_num_rows($result3) > 0) {
                                                                                            while ($row1 = mysqli_fetch_array($result3)) {
                                                                                                $stateText = "Issued by " . $row1["firstname"] . " " . $row1["lastname"] . " (userId: " . $row1['user_id'] . ")";
                                                                                            }
                                                                                        } else {
                                                                                            $stateText = "Free";
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    $stateText = "Free";
                                                                                }

                                                                                echo "
                                                                <div class='col-md-12'>
                                                                    <div class='form-group row'>
                                                                        <label for='name' class='col-6 col-form-label'>Book ID</label>
                                                                        <div class='col-6'>
                                                                        " . $row['text_id'] . "</div>
                                                                    </div>
                                                                    <div class='form-group row'>
                                                                        <label for='name' class='col-6 col-form-label'>Details</label>
                                                                        <div class='col-6'>
                                                                        " . $row['title'] . " - " . $row['author'] . " (" . $row['dop'] . ")</div>
                                                                    </div>
                                                                    <div class='form-group row'>
                                                                        <label for='newpass' class='col-6 col-form-label'>ISBN</label>
                                                                        <div class='col-6'>
                                                                        " . $row['isbn'] . "</div>
                                                                    </div>
                                                                    <div class='form-group row'>
                                                                        <label for='newpass' class='col-6 col-form-label'>State</label>
                                                                        <div class='col-6'>
                                                                        " . $stateText . "</div>
                                                                    </div>
                                                                ";
                                                                            }
                                                                            mysqli_free_result($result2);
                                                                            if ($result && mysqli_num_rows($result) > 0 && $stateText == "Free") {
                                                                                ?>
                                                                    <form method="post" action="includes/issueUser.inc.php">
                                                                        <input type="hidden" name="userId" value="<?php echo $userId; ?>" />
                                                                        <input type="hidden" name="textId" value="<?php echo $textId; ?>" />
                                                                        <button class="btn btn-warning" name="issue-user" type="submit">Issue</button>
                                                                    </form>
                                                        </div>
                                                <? }
                                                            } else {
                                                                echo "Text Material wasn't found.";
                                                            }

                                                            ?>
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                <?php
                        } else {
                            echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
                        }
                    }
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