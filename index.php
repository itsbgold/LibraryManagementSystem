<?php
require "header.php";
require './includes/dbh.inc.php';
?>
<main>
    <h2>Welcome to Library Manage System</h2>
    <br>
    <form action="index.php" method="post">
        <p>Choose Type:
            <select name="type">
                <option value="all"> All</option>
                <option value="book"> Book</option>
                <option value="journal"> Journal</option>
                <option value="magazine"> Magazine</option>
            </select></p>
        <p>Choose Type:
            <select name="searchBy">
                <option value="title"> Title</option>
                <option value="subject"> Subject</option>
                <option value="Isbn"> ISBN</option>
                <option value="author"> Author/Publisher</option>
            </select></p>
        <p>Search: <input type="text" name="search"> </p>
        <button type="submit" name="search-submit">Show Info</button>
    </form>

    <?php

    $sql = "SELECT * FROM text WHERE 1 = 1";

    if (isset($_POST['search-submit'])) {
        $searchBy = $_POST["searchBy"];
        $search = $_POST["search"];
        $type = $_POST["type"];

        if ($type != "all") {
            $sql .= " AND  type = '%$type%' ";
        }
        if (!empty($searchBy)) {
            $sql .= " AND  $searchBy LIKE '%$search%' ";
        }
        // else {
        //     $qry = "SELECT * FROM `user` WHERE email=?";
        //     $stmt = mysqli_stmt_init($conn);
        //     if (!mysqli_stmt_prepare($stmt, $qry)) {
        //         header("Location:../login.php?error=sqlerror&email=" . $email);
        //         exit();
        //     } else {
        //         mysqli_stmt_bind_param($stmt, "s", $email);
        //         mysqli_stmt_execute($stmt);
        //         $result = mysqli_stmt_get_result(($stmt));
        //         if ($row = mysqli_fetch_assoc($result)) {
        //             $pwdcheck = password_verify($pwd, $row['password']);
        //             if ($pwdcheck == false) {
        //                 header("Location:../login.php?error=wrongpassword&email=" . $email);
        //                 exit();
        //             } else if ($pwdcheck == true) {
        //                 session_start();
        //                 $_SESSION['email'] = $row['email'];
        //                 $_SESSION['user_id'] = $row['user_id'];
        //                 $_SESSION['role'] = $row['role'];
        //                 header("Location:../index.php?login=success");
        //                 exit();
        //             } else {
        //                 header("Location:../login.php?error=wrongpassword&email=" . $email);
        //                 exit();
        //             }
        //         } else {
        //             header("Location:../login.php?error=emailnotfound");
        //             exit();
        //         }
        //     }
        // }
        // mysqli_stmt_close($stmt);
    }

    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>id</th>";
            echo "<th>Title</th>";
            echo "<th>Type</th>";
            echo "<th>Subject</th>";
            echo "<th>Author/Editor</th>";
            echo "<th>ISBN</th>";
            if (isset($_SESSION["user_id"])) {
                if ($_SESSION["role"] == "admin") {
                    echo "<th>Actions</th>";
                }
            }
            echo "</tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['text_id'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td>" . $row['subject'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['isbn'] . "</td>";
                if (isset($_SESSION["user_id"])) {
                    if ($_SESSION["role"] == "admin") { ?>
                        <td><a href="index.php?id=<? echo $row['text_id']; ?>">Delete</a></td>
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
            mysqli_query($conn, "DELETE from text WHERE text_id='$id'");
            // mysqli_query();
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