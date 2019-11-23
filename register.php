<?php
$page = "register";
require "header.php";
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Add a Member</h4>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="includes/register.inc.php" method="post" class="border border-light">
                            <?php
                            if (isset($_GET['error'])) {
                                if ($_GET['error'] == "emptyfields") {
                                    echo "<p class='alert alert-danger' role='alert'>Empty Fields!</p>";
                                } elseif ($_GET['error'] == "passworderror") {
                                    echo "<p class='alert alert-danger' role='alert'>Passwords do not match!</p>";
                                } elseif ($_GET['error'] == "sqlerror") {
                                    echo "<p class='alert alert-danger' role='alert'>Internal error! Please Try Again!!</p>";
                                } elseif ($_GET['error'] == "invalidemail") {
                                    echo "<p class='alert alert-danger' role='alert'>Invalid email!</p>";
                                } elseif ($_GET['error'] == "emailexists") {
                                    echo "<p class='alert alert-danger' role='alert'>Email used by some other user!</p>";
                                } elseif ($_GET['error'] == "invalidphone") {
                                    echo "<p class='alert alert-danger' role='alert'>Invalid Phone number!</p>";
                                }
                            } ?>
                            <br>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-label-group">
                                        <input name="firstname" type="text" id="inputNameF" class="form-control" placeholder="First name">
                                        <label for="inputNameF">First name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-label-group">
                                        <input name="lastname" type="text" id="inputName2" class="form-control" placeholder="Last name">
                                        <label for="inputName2">Last name</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-label-group">
                                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="E-mail">
                                <label for="inputEmail">E-mail</label>
                            </div>
                            <br>
                            <div class="form-label-group">
                                <input name="phone" type="text" id="inputNum" class="form-control" placeholder="Phone number">
                                <label for="inputNum">Phone number</label>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Gender:</label>
                                        </div>
                                        <select name="gender" class="custom-select" id="inputGroupSelect01">
                                            <option selected value="male"> Male</option>
                                            <option value="female"> Female</option>
                                            <option value="others"> Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Role</label>
                                        </div>
                                        <select name="role" class="custom-select" id="inputGroupSelect01">
                                            <option value="member">Member</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-label-group">
                                <textarea name="address" class="form-control" placeholder="Address" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-label-group">
                                        <input type="password" name="pwd" id="inputPwd" class="form-control" placeholder="Password">
                                        <label for="inputPwd">Password</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-label-group">
                                        <input type="password" name="pwd2" id="inputPwd2" class="form-control" placeholder="Confirm Password">
                                        <label for="inputPwd2">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Sign up button -->
                            <button name="register" class="btn btn-info my-4 btn-block" type="submit">Add Member</button>

                        </form>
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