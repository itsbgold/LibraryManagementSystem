<?php
$page = "addbooks";
require "header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Add a Book</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="includes/addbooks.inc.php" method="post" class="border border-light">
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "emptyfields") {
                                        echo "<p class='alert alert-danger' role='alert'>Empty Fields!</p>";
                                    } elseif ($_GET['error'] == "sqlerror") {
                                        echo "<p class='alert alert-danger' role='alert'>Internal error! Please Try Again!!</p>";
                                    } elseif ($_GET['error'] == "emptydates") {
                                        echo "<p class='alert alert-danger' role='alert'>Date not inserted!</p>";
                                    } elseif ($_GET['error'] == "isbnexists") {
                                        echo "<p class='alert alert-danger' role='alert'>Book with same ISBN exists!</p>";
                                    }
                                } ?>

                                <div class="form-label-group">
                                    <input type="text" name="title" id="Title" class="form-control" placeholder="Title">
                                    <label for="Title">Title</label>
                                </div>

                                <div class="form-label-group">
                                    <input type="text" name="author" id="author" class="form-control" placeholder="Author/Publisher">
                                    <label for="author">Author/Publisher</label>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-label-group">
                                            <input name="subject" type="text" id="subject" class="form-control" placeholder="Subject">
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-label-group">
                                            <input name="isbn" type="text" id="ISBN" class="form-control" placeholder="ISBN">
                                            <label for="ISBN">ISBN</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Text type:</label>
                                            </div>
                                            <select name="type" class="custom-select" id="inputGroupSelect01">
                                                <option selected value="book"> Book</option>
                                                <option value="journal"> Journal</option>
                                                <option value="magazine"> Magazine</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Date of Publication: </label>
                                            </div>
                                            <input type="date" name="dop">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info my-4 btn-block" name="addbooks">Add book</button>
                            </form>
                        </div>
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