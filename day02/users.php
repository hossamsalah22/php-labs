<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = ["fname", "lname", "address", "country", "gender", "skills", "username", "password", "dept"];
    $errors = [];
    $_POST = array_intersect_key($_POST, array_flip($data));
    foreach ($data as $key) {
        if (in_array($key, $data) && empty($_POST[$key]))
            if ($key == "fname")
                $errors[$key] = "First Name is required";
            elseif ($key == "lname")
                $errors[$key] = "Last Name is required";
            elseif ($key == "gender" &&  !in_array($_POST['gender'], ["male", "female"]))
                $errors[$key] = "Please Choose Your Gender";
            elseif ($key == "address")
                $errors[$key] = "Address Is Required";
            elseif ($key == "password")
                $errors[$key] = "Password is required";
            elseif ($key == "skills" &&  !in_array($_POST['skills'], ["mysql", "php", "post", "java"]))
                $errors[$key] = "Please Choose One Skill Ate Least";
            elseif ($key == "username")
                $errors[$key] = "Username is required";
            elseif ($key == "country" && !in_array($_POST['country'], ["cairo", "mansoura", "damietta"]))
                $errors[$key] = "Please Choose Your Country";
    }
    if (!empty($errors)) {
        header("Location:registerform.php?errors=" . json_encode($errors) . "&old=" . json_encode($_POST));
    } else {
        $file = fopen("users.txt", "a+");
        $id = microtime(true) * 10000;
        $skills = implode(",", $_POST['skills']);
        $userData = "{$id}:{$_POST['fname']}:{$_POST['lname']}:{$_POST['address']}:{$_POST['country']}:{$_POST['gender']}:{$skills}:{$_POST['username']}:{$_POST['password']}:{$_POST['dept']}\n";
        fwrite($file, $userData);
        fclose($file);
        header("Location:users.php");
    }
    exit;
}
$users = file("users.txt");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-center text-decoration-underline">Users Table</h1>
        <table class="table table-dark table-bordered text-center align-middle">

            <head>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>Gender</th>
                    <th>Skills</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Department</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </head>

            <body>
                <?php
                $i = 0;
                foreach ($users as $user) {
                    $user = explode(":", $user);
                    $i++;
                    echo "
                    <tr>
                        <td>{$user[0]}</td>
                        <td>{$user[1]}</td>
                        <td>{$user[2]}</td>
                        <td>{$user[3]}</td>
                        <td>{$user[4]}</td>
                        <td>{$user[5]}</td>
                        <td>{$user[6]}</td>
                        <td>{$user[7]}</td>
                        <td>{$user[8]}</td>
                        <td>{$user[9]}</td>
                        <td><a href='edit.php?id={$user[0]}' class='btn btn-warning'>Edit</a></td>
                        <td><a href='delete.php?id={$user[0]}' class='btn btn-danger'>Delete</a></td>
                    </tr>
                    ";
                }; ?>
            </body>
        </table>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>