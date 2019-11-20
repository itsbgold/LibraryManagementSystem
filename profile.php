<?php
$page = "profile";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<h1>Your Profile</h1>
<?php
$uid = $_SESSION["user_id"];
$sql = "SELECT * FROM user WHERE user_id = $uid ";

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
        // if (isset($_SESSION["user_id"])) {
        //     if ($_SESSION["role"] == "admin") {
        //         echo "<th>Actions</th>";
        //     }
        // }
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
            // if (isset($_SESSION["user_id"])) {
            //     if ($_SESSION["role"] == "admin" && $_SESSION["user_id"] != $row['user_id']) {
            //         echo    '<td><a href="searchmember.php?id=' . $row['user_id'] . '>Delete</a></td>';
            //     }
            // }
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "Profile wasn't found.";
    }
} else {
    echo "ERROR: Could not able to execute the query." . mysqli_error($conn);
}
?>


<?php
require "footer.php";
?>