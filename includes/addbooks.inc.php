<?php
if (isset($_POST['addbooks'])) {

    require 'dbh.inc.php';
    $title = $_POST["title"];
    $isbn = $_POST["isbn"];
    $dop = $_POST["dop"];
    $author = $_POST["author"];
    $subject = $_POST["subject"];
    $type = $_POST["type"];
    if (empty($dop) || empty($title) || empty($isbn) || empty($author) || empty($subject) || empty($type)) {
        header("Location:../addbooks.php?error=emptyfields&title=" . $title . "&isbn=" . $isbn . "&author=" . $author . "&subject=" . $subject . "&type=" . $type);
        exit();
    } else if (empty($dop) && $type !== "book") {
        header("Location: ../addbooks.php?error=emptydates&title=" . $title . "&isbn=" . $isbn .  "&author=" . $author . "&subject=" . $subject . "&type=" . $type);
        exit();
    } else {
        $qry = "SELECT * FROM `text` WHERE isbn=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $qry)) {
            header("Location:../addbooks.php?error=sqlerror&title=" . $title . "&isbn=" . $isbn . "&author=" . $author . "&subject=" . $subject . "&type=" . $type);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $isbn);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result(($stmt));
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0) {
                header("Location: ../addbooks.php?error=isbnexists&title=" . $title . "&author=" . $author . "&subject=" . $subject . "&type=" . $type);
                exit();
            } else {
                $qry = "INSERT INTO text ( title, isbn, dop, type, subject, author) VALUES
                (?, ?, ?, ?, ?, ?);";

                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $qry)) {
                    header("Location:../addbooks.php?error=sqlerror&title=" . $title . "&isbn=" . $isbn . "&dop=" . $dop . "&author=" . $author . "&subject=" . $subject . "&type=" . $type);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssss", $title, $isbn, $dop, $type, $subject, $author);
                    mysqli_stmt_execute($stmt);
                    header("Location:../addbooks.php?success=addbookssuccess");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
    exit();
}
