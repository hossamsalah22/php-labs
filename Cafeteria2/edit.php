<?php
$title = "Edit User";
include_once("layouts/header.php");
require 'connection/db_connect.php';


$db = db_connection();
if ($db) {
    $query = 'SELECT * FROM `cafeteria`.`users` WHERE id=:user_id;';
    $user_id = $_GET['id'];
    $stmt = $db->prepare($query);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $res = $stmt->execute();
    if ($res) {
        $user = $stmt->fetchObject();
    }
    if (isset($_POST['update-user'])) {
        $errors = [];

        // $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        // $max_file_size = 2000000; // 2 MB

        // $file_name = $_FILES["profile-pic"]["name"];
        // $file_size = $_FILES["profile-pic"]["size"];
        // $file_temp = $_FILES["profile-pic"]["tmp_name"];
        // $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check Errors Of User Data Entry 
        if (empty($_POST["user-name"])) {
            $errors['user-name'] = "<div class='alert alert-danger'> Please enter your name </div>";
        }
        if (empty($_POST["email"])) {
            $errors['email']['empty'] = "<div class='alert alert-danger'> Please enter your Email </div>";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $_POST['email'])) {
            $errors['email']['validation'] = "<div class='alert alert-danger'> Please enter Valid Email </div>";
        }
        if (empty($_POST["password"])) {
            $errors['password']['empty'] = "<div class='alert alert-danger'> Please enter your password </div>";
        } elseif (!preg_match("/^[a-z0-9_]{8}$/", $_POST["password"])) {
            $errors['password']['validation'] = "<div class='alert alert-danger'> Password must be 8 small characters and only underscore allowed </div>";
        }
        if (empty($_POST["confirm-password"])) {
            $errors['confirm-password'] = "<div class='alert alert-danger'> Please Confirm Your Password </div>";
        }
        if ($_POST['password'] != $_POST["confirm-password"]) {
            $errors['match-password'] = "<div class='alert alert-danger'> Passwords Doesn't Match </div>";
        }
        if (empty($_POST["room"])) {
            $errors['room'] = "<div class='alert alert-danger'> Please Select Your Room </div>";
        }

        // if ($request->hasFile('profile-pic')) {
        //     if (!in_array($file_ext, $allowed_extensions) || $file_size >= $max_file_size) {
        //         $errors['profile-pic'] = "<div class='alert alert-danger'> Invalid Image </div>";
        //     } else {
        //         $upload_dir = "assets/img/";
        //         $upload_file = $upload_dir . basename($file_name);
        //         session_start();
        //         if (move_uploaded_file($file_temp, $upload_file)) {
        //             // File uploaded successfully
        //             $_SESSION["success_message"] = "Image uploaded successfully!";
        //         } else {
        //             // Error moving the file
        //             $_SESSION["error_message"] = "Error uploading the file!";
        //         }
        //     }
        // }
        if (empty($errors)) {
            $query = "UPDATE `users`
            SET `name` =:user_name , `email`=:user_email, `password`=:user_password,`room_no`=:user_room_no
            WHERE `id`=:user_id";

            $user_name = $_POST['user-name'];
            $user_email = $_POST['email'];
            $user_password = $_POST['password'];
            $room_no = $_POST['room'];

            $statement = $db->prepare($query);

            $db->beginTransaction();
            $statement->execute([
                'user_name' => $user_name, "user_email" => $user_email,
                "user_password" => $user_password, "user_room_no" => $room_no, 'user_id' => $user_id
            ]);

            $db->commit();

            header("Location:login.php");
            exit;
        }
    }
}

?>


<div class="container bg-dark text-white">
    <div class="row mt-5">
        <div class="col-12">
            <div class="h1 text-center my-3">Update User</div>
            <form action="edit.php?id=<?= $user->id ?>" method="post" enctype="multipart/form-data">
                <div class="col-6 offset-3">
                    <!-- User Info Table -->
                    <?php if (!empty($img['error'])) {
                        echo $img['error'];
                    } ?>
                    <div class="form-group">
                        <label for="user-name" class="text-left font-weight-bold">User Name</label>
                        <input type="text" name="user-name" id="user-name" class="form-control"
                            value="<?= $user->name ?>" placeholder="Please Enter Your Name">
                    </div>
                    <?php if (!empty($errors['user-name'])) {
                        echo $errors['user-name'];
                    } ?>
                    <div class="form-group">
                        <label for="email" class="text-left font-weight-bold">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?= $user->email ?>"
                            placeholder="Please Enter Your Email">
                    </div>
                    <?php if (!empty($errors['email'])) {
                        foreach ($errors['email'] as $err) {
                            echo $err;
                        }
                    } ?>
                    <div class="form-group">
                        <label for="password" class="text-left font-weight-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            value="<?= $user->password ?>" placeholder="Please Enter Your Password">
                    </div>
                    <?php if (!empty($errors['password'])) {
                        foreach ($errors['password'] as $err) {
                            echo $err;
                        }
                    } ?>
                    <div class="form-group">
                        <label for="confirm-password" class="text-left font-weight-bold">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" class="form-control"
                            value="<?= $user->password ?>" placeholder="Please Enter Your confirm-password">
                    </div>
                    <?php if (!empty($errors['confirm-password'])) {
                        echo $errors['confirm-password'];
                    } ?>
                    <?php if (!empty($errors['match-password'])) {
                        echo $errors['match-password'];
                    } ?>

                    <div class="form-group">
                        <label for="room" class="text-left font-weight-bold">Room No</label>
                        <select name="room" id="room" class="form-control">
                            <option value="0" selected disabled>Select Your Room</option>
                            <option value="App-1" <?php if ($user->room_no == "App-1") {
                                                        echo "selected";
                                                    } ?>>Application 1</option>
                            <option value="App-2" <?php if ($user->room_no == "App-2") {
                                                        echo "selected";
                                                    } ?>>Application 2</option>
                            <option value="cloud" <?php if ($user->room_no == "cloud") {
                                                        echo "selected";
                                                    } ?>>Cloud</option>
                        </select>
                    </div>
                    <?php if (!empty($errors['room'])) {
                        echo $errors['room'];
                    } ?>
                    <!-- <div class="form-group">
                        <label for="profile-pic">Profile Picture:</label>
                        <input type="file" id="profile-pic" name="profile-pic">
                    </div>
                    <?php if (!empty($errors['profile-pic'])) {
                        echo $errors['profile-pic'];
                    } ?> -->
                    <div class="form-group">
                        <label></label>
                        <button class="btn btn-success form-control rounded" name="update-user"
                            value="update-user">Update
                            User</button>
                    </div>
                </div>
            </form>
        </div>
        </form>
    </div>
</div>

<?php
include_once("layouts/footer.php");
?>