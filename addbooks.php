<?php
require "header.php";
?>
<main>
    <form action="includes/addbooks.inc.php" method="post">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
                echo "<p>Empty Fields!</p>";
            } elseif ($_GET['error'] == "sqlerror") {
                echo "<p>Internal error! Please Try Again!!</p>";
            } elseif ($_GET['error'] == "emptydates") {
                echo "<p>Date not inserted!</p>";
            } elseif ($_GET['error'] == "isbnexists") {
                echo "<p>Book with same ISBN exists!</p>";
            }
        } ?>
        <input type="text" name="title" placeholder="Title"><br>
        <input type="text" name="isbn" placeholder="ISBN"><br>
        <input type="text" name="author" placeholder="Author/Publisher"><br>
        <input type="text" name="subject" placeholder="Subject"><br>
        <p>Please select the text material type:</p>
        <select name="type">
            <option value="book"> Book</option>
            <option value="journal"> Journal</option>
            <option value="magazine"> Magazine</option>
        </select><br>
        <!-- <p>Please select the subject:</p>
        <select name="type">
            <option value="book"> Book</option>
            <option value="journal"> Journal</option>
            <option value="magazine"> Magazine</option>
        </select><br> -->
        <p>Please Date of publication:</p>
        <input type="date" name="dop"><br>
        <button type="submit" name="addbooks">Add book</button>
    </form>
</main>
<?php
require "footer.php";
?>