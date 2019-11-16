<?php
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
?>
<form action="searchmember.php" method="post">
    <p>Search by firstname, lastname, email or phone number: <input type="text" name="search"> </p>
    <p>Role:
        <select name="role">
            <option value="all">All</option>
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select><br></p>
    <p>Gender:
        <select name="gender">
            <option value="all">All</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="others">Others</option>
        </select><br></p>
    <button type="submit" name="search-user-submit">Show Info</button>
</form>

<?php
$uid = $_SESSION["user_id"];
$sql = "SELECT * FROM user WHERE user_id != $uid ";
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
        echo "<table>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>FirstName</th>";
        echo "<th>LastName</th>";
        echo "<th>Email</th>";
        echo "<th>Phone No.</th>";
        echo "<th>Role</th>";
        echo "<th>No Of Books</th>";
        echo "<th>Fine</th>";
        echo "<th>Address</th>";
        echo "<th>Gender</th>";
        if (isset($_SESSION["user_id"])) {
            if ($_SESSION["role"] == "admin") {
                echo "<th>Actions</th>";
            }
        }
        echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
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
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
}
?>

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