<?php
$page = "reservations";
require "header.php";
require './includes/dbh.inc.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}

?>

<br />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Reservations Details</h4>
                        <hr>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php
                    $sql  = "SELECT resv_id, time_of_resv, title , author, A.user_id, A.text_id, firstname, lastname FROM reservation AS A INNER JOIN text AS B ON A.text_id = B.text_id INNER JOIN user AS C ON A.user_id = C.user_id ";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-hover table-bordered'>";
                            echo '<thead class="thead-dark">';
                            echo "<tr>";
                            echo "<th scope='col'>Id</th>";
                            echo "<th scope='col'>Book details</th>";
                            echo "<th scope='col'>User details</th>";
                            echo "<th scope='col'>Reservation date</th>";
                            echo "<th scope='col'>Actions</th>";
                            echo "</tr>";
                            echo "</thead> ";
                            echo "<tbody> ";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<th scope='col'>" . $row['resv_id'] . "</td>";
                                echo "<td>" . $row['title'] . " - " . $row['author'] . " ( Id: " . $row['text_id'] . " )</td>";
                                echo "<td>" . $row['firstname'] . " " . $row['lastname'] . " ( Id: " . $row['user_id'] . " )</td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['time_of_resv'])) . "</td>";
                                ?>
                                <td>
                                    <form method="post" action="includes/cancelResv.inc.php">
                                        <input type="hidden" name="resv_id" value="<?php echo $row['resv_id']; ?>" />
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