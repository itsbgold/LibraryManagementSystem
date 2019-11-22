<?php
$page = "searchmember";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
?>


<form class="form-row" action="searchmember.php" method="post">
    <div class="col-md-5">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="staticEmail2" class="input-group-text">Search</label> </div>
            <input type="text" class="form-control" name="search" id="staticEmail2" placeholder="Search by firstname, lastname, email or phone number...">
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Role:</label>
            </div>
            <select name="role" class="custom-select" id="inputGroupSelect01">
                <option value="all">All</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Gender:</label>
            </div>
            <select name="gender" class="custom-select" id="inputGroupSelect01" aria-describedby="button-addon2">
                <option value="all">All</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="others">Others</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-dark" name="search-user-submit" type="submit" id="button-addon2">Show Info</button>
            </div>
        </div>
    </div>
</form>
<br>
<div class="table-responsive">
    <?php
    $uid = $_SESSION["user_id"];
    $sql = "SELECT * FROM user WHERE 1 = 1 ";
    if (isset($_POST['search-user-submit'])) {
        $search = $_POST["search"];
        $role = $_POST["role"];
        $gender = $_POST["gender"];

        if ($gender != "all") {
            $sql .= " AND  gender = '$gender' ";
        }
        if ($role != "all") {
            $sql .= " AND  role = '$role' ";
        }
        if (!empty($search)) {
            $sql .= " AND  ( firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' )";
        }
    }

    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-hover table-bordered'>";
            echo '<thead class="thead-dark">';
            echo "<tr>";
            echo "<th scope='col'>Id</th>";
            echo "<th scope='col'>Firstname</th>";
            echo "<th scope='col'>Lastname</th>";
            echo "<th scope='col'>Email</th>";
            echo "<th scope='col'>Phone No</th>";
            echo "<th scope='col'>Role</th>";
            echo "<th scope='col'>Books</th>";
            echo "<th scope='col'>Fine</th>";
            echo "<th scope='col'>Address</th>";
            echo "<th scope='col'>Gender</th>";
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
                echo "<th scope='row'>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>" . $row['no_of_books'] . "</td>";
                echo "<td>" . $row['fine'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                if (isset($_SESSION["user_id"])) {
                    if ($_SESSION["role"] == "admin" && $_SESSION["user_id"] != $row['user_id']) { ?>
                        <td><a href="searchmember.php?id=<? echo $row['user_id']; ?>">Delete</a></td>
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
</main>
<?php
if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] == "admin") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_SESSION["user_id"] != $id)
                mysqli_query($conn, "DELETE from user WHERE user_id = $id ");
            header("Location: searchmember.php");
            exit();
        }
    }
}

mysqli_close($conn);
?>
<?php
require "footer.php";
?>