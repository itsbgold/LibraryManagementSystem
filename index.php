<?php
$page = "index";
require "header.php";
require './includes/dbh.inc.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Search Books, Journals or Magazines</h4>
                        <hr>
                    </div>
                </div>
                <form class="form-row" action="index.php" method="post">
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Search By:</label>
                            </div>
                            <select name="searchBy" class="custom-select" id="inputGroupSelect01">
                                <option value="title"> Title</option>
                                <option value="subject"> Subject</option>
                                <option value="Isbn"> ISBN</option>
                                <option value="author"> Author/Publisher</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="staticEmail2" class="input-group-text">Search</label> </div>
                            <input type="text" class="form-control" name="search" id="staticEmail2" placeholder="search...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Type:</label>
                            </div>
                            <select name="type" class="custom-select" id="inputGroupSelect01" aria-describedby="button-addon2">
                                <option value="all"> All</option>
                                <option value="book"> Book</option>
                                <option value="journal"> Journal</option>
                                <option value="magazine"> Magazine</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-dark" name="search-submit" type="submit" id="button-addon2">Show Info</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="table-responsive">
                    <?php
                    $sql = "SELECT * FROM text WHERE 1 = 1";
                    if (isset($_POST['search-submit'])) {
                        $searchBy = $_POST["searchBy"];
                        $search = $_POST["search"];
                        $type = $_POST["type"];

                        if ($type != "all") {
                            $sql .= " AND  type = '$type' ";
                        }
                        if (!empty($searchBy)) {
                            $sql .= " AND  $searchBy LIKE '%$search%' ";
                        }
                    }

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-hover table-bordered'>";
                            echo '<thead class="thead-dark">';
                            echo "<tr>";
                            echo "<th scope='col'>Id</th>";
                            echo "<th scope='col'>Title</th>";
                            echo "<th scope='col'>Type</th>";
                            echo "<th scope='col'>Subject</th>";
                            echo "<th scope='col'>Author/Editor</th>";
                            echo "<th scope='col'>ISBN</th>";
                            echo "<th scope='col'>Status</th>";
                            if (isset($_SESSION["user_id"])) {
                                if ($_SESSION["role"] == "admin") {
                                    echo "<th scope='col'>Actions</th>";
                                }
                            }
                            echo "</tr>";
                            echo "</thead> ";
                            echo "<tbody> ";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<th scope='col'>" . $row['text_id'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['type'] . "</td>";
                                echo "<td>" . $row['subject'] . "</td>";
                                echo "<td>" . $row['author'] . "</td>";
                                echo "<td>" . $row['isbn'] . "</td>";
                                $iuid;
                                if ($row['book_state'] != "free") {
                                    $sql3  = "SELECT B.`firstname` , B.`lastname`, A.user_id, A.text_id FROM `issue` AS A INNER JOIN `user` AS B ON A.user_id = B.user_id where text_id=" . $row['text_id'] . " and `return_date` IS NULL ";
                                    if ($result3 = mysqli_query($conn, $sql3)) {
                                        if (mysqli_num_rows($result3) > 0) {
                                            while ($row1 = mysqli_fetch_array($result3)) {
                                                $iuid = $row1['user_id'];
                                                $stateText = "Issued by " . $row1["firstname"] . " " . $row1["lastname"] . " (userId: " . $row1['user_id'] . ")";
                                            }
                                        } else {
                                            $stateText = "Free";
                                        }
                                    }
                                } else {
                                    $stateText = "Free";
                                }
                                if ($stateText != "Free" && $iuid != $_SESSION['user_id']) { ?>
                                    <td><?
                                                        echo "$stateText <hr/>";
                                                        $sql3  = "SELECT * FROM `reservation` WHERE user_id=" . $_SESSION['user_id'] . "  AND text_id = " . $row['text_id'] . " ";
                                                        if ($result3 = mysqli_query($conn, $sql3)) {
                                                            if (mysqli_num_rows($result3) > 0) {
                                                                echo "Already Reserved";
                                                            } else { ?>
                                                <form method="post" action="includes/addReservations.inc.php">
                                                    <input type="hidden" name="userId" value="<?php echo $_SESSION['user_id']; ?>" />
                                                    <input type="hidden" name="textId" value="<?php echo $row['text_id']; ?>" />
                                                    <button class="btn btn-outline-dark btn-sm" name="reserve-user" type="submit">Reserve</button>
                                                </form>
                                        <? }
                                                        } ?>
                                    </td>
                                    <?php } else {
                                                    echo "<td>$stateText</td>";
                                                }
                                                if (isset($_SESSION["user_id"])) {
                                                    if ($_SESSION["role"] == "admin") { ?>
                                        <td><a class='btn btn-outline-danger btn-sm' href="index.php?id=<? echo $row['text_id']; ?>">Delete</a></td>
                    <?php }
                                }
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
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] == "admin") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            mysqli_query($conn, "DELETE from text WHERE text_id='$id'");
            header("Location: index.php");
            exit();
        }
    }
}

mysqli_close($conn);
?>
<?php
require "footer.php";
?>