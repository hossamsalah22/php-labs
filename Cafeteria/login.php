<?php
$title = "Cafeteria";
include_once("layouts/header.php");

session_start();
if (isset($_SESSION['email'])) {
    header("Location: welcome.php");
    exit;
}

if (isset($_POST['login'])) {
    $errors = [];

    if (empty($_POST["email"])) {
        $errors['email']['empty'] = "<div class='alert alert-danger'> Please enter your Email </div>";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $_POST['email'])) {
        $errors['email']['validation'] = "<div class='alert alert-danger'> Please enter Valid Email </div>";
    }
    if (empty($_POST["password"])) {
        $errors['password']['empty'] = "<div class='alert alert-danger'> Please enter your password </div>";
    }
    if (empty($errors)) {
        $valid = false;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $users = file("users.txt");
        $user = array_filter($users, function ($user) use ($email, $password) {
            $user_data = explode(":", trim($user));
            return ($user_data && $user_data[2] == $email && $user_data[3] == $password);
        });
        if ($user) {
            $_SESSION['user-name'] = $_POST['email'];
            header("Location: welcome.php");
            exit;
        } else {
            $errors['login'] = '<div class="alert alert-danger d-flex align-items-center text-center w-75 m-auto" role="alert"><span class="w-100 text-center">Login Failed</span></div>';
        }
    }
}
?>


<div class="container bg-dark text-white">
    <div class="row mt-5">
        <div class="col-12">
            <div class="h1 text-center my-3">Cafeteria</div>
            <form action="login.php" method="post">
                <div class="col-6 offset-3">
                    <?php if (!empty($errors['login'])) {
                        echo $errors['login'];
                    } ?>
                    <div class="form-group">
                        <label for="email" class="text-left font-weight-bold">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?php if (!empty($_POST['email'])) {
                                                                                                    echo $_POST['email'];
                                                                                                } ?>" placeholder="Please Enter Your Email">
                    </div>
                    <?php if (!empty($errors['email'])) {
                        foreach ($errors['email'] as $er) {
                            echo $er;
                        }
                    } ?>
                    <div class="form-group">
                        <label for="password" class="text-left font-weight-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php if (!empty($_POST['password'])) {
                                                                                                                echo $_POST['password'];
                                                                                                            } ?>" placeholder="Please Enter Your Password">
                    </div>
                    <?php if (!empty($errors['password'])) {
                        foreach ($errors['password'] as $err) {
                            echo $err;
                        }
                    } ?>
                    <div class="form-group">
                        <label></label>
                        <button class="btn btn-success form-control rounded" name="login" value="login">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    include_once("layouts/footer.php");
    ?>