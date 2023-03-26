<?php
$title = "Welcome";
include_once("layouts/header.php");
session_start();
if (isset($_POST['logout'])) {
    unset($_SESSION['email']);
    session_destroy();
    header("Location: login.php");
    exit;
}
?>


<div class="container bg-dark text-white">
    <div class="row mt-5">
        <div class="col-12">
            <div class="h1 text-center my-3">Cafeteria</div>
            <?php
            if (isset($_SESSION['email'])) { ?>
                <div class="alert alert-success text-center" role="alert">
                    <?= "Welcome, " . $_SESSION['email']; ?>
                </div>
            <?php
            } else {
                header("Location:login.php");
                exit;
            }
            ?>
        </div>
        <form action="welcome.php" method="post">
            <div class="col-12 text-center">
                <div class="form-group">
                    <button class="btn btn-success form-control rounded" name="logout" value="logout">Logout</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once("layouts/footer.php");
?>