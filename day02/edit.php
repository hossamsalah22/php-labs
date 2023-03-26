<?php

$errors = [];
if ($_GET) {
    $errors = json_decode($_GET['errors'], true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $_POST['id'];
    $allowed = ["id", "fname", "lname", "address", "country", "gender", "skills", "username", "password", "dept"];
    $errors = [];
    $_POST = array_intersect_key($_POST, array_flip($allowed));
    var_dump($_POST);
    foreach ($allowed as $key) {
        if (!isset($_POST[$key])) {
            $errors[$key] = $key . " is required";
        } else {
            if ($key == "fname" && empty($_POST[$key]))
                $errors[$key] = "First Name is required";
            elseif ($key == "lname" && empty($_POST[$key]))
                $errors[$key] = "Last Name is required";
            elseif ($key == "gender" &&  !in_array($_POST['gender'], ["male", "female"]))
                $errors[$key] = "Please Choose Your Gender";
            elseif ($key == "address" && empty($_POST[$key]))
                $errors[$key] = "Address Is Required";
            elseif ($key == "password" && empty($_POST[$key]))
                $errors[$key] = "Password is required";
            elseif ($key == "skills" && empty($_POST[$key]) &&  !in_array($_POST['skills'], ["mysql", "php", "post", "java"]))
                $errors[$key] = "Please Choose One Skill Ate Least";
            elseif ($key == "username" && empty($_POST[$key]))
                $errors[$key] = "Username is required";
            elseif ($key == "country" && !in_array($_POST['country'], ["cairo", "mansoura", "damietta"]))
                $errors[$key] = "Please Choose Your Country";
        }
    }
    if ($errors) {
        header("Location:edit.php?id={$_POST['id']}&errors=" . json_encode($errors));
    } else {
        $users = file("users.txt");
        $skills = implode(",", $_POST['skills']);
        foreach ($users as $key => $user) {
            if (explode(":", $user)[0] == $_POST['id']) {
                //                unset($users[$key]);
                echo $key;
                echo $users[$key];
                $users[$key] = "{$_POST['id']}:{$_POST['fname']}:{$_POST['lname']}:{$_POST['address']}:{$_POST['country']}:{$_POST['gender']}:{$skills}:{$_POST['username']}:{$_POST['password']}:{$_POST['dept']}\n";
                break;
            }
        }
        file_put_contents("users.txt", implode("", $users));
        header("Location:users.php");
    }
    exit;
}



$user = [];
if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET["id"]) {
    $id = $_GET['id'];
    //        echo $id."<br>";
    $users = file("users.txt");
    $users = array_filter($users, function ($user) use ($id) {
        $user = explode(":", $user);
        return $user[0] == $id;
    });
    foreach ($users as $user) {
        $user = explode(":", trim($user));
        $user[6] = explode(",", $user[6]);
        break;
    }
    if (!$user) {
        header("location:users.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <form method="POST" action="edit.php">
            <input type="hidden" name="id" value="<?php echo $user[0] ?>">
            <div class="mb-3">
                <label for="fname" class="form-label">First Name : </label>
                <input name="fname" type="text" class="form-control" id="fname" value="<?php echo $user[1] ?>">
                <?php if ($errors && isset($errors['fname']) && !empty($errors['fname'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['fname'] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name : </label>
                <input name="lname" type="text" class="form-control" id="lname" value="<?php echo $user[2] ?>">
                <?php if ($errors && isset($errors['lname']) && !empty($errors['lname'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['lname'] ?>
                    </div>
                <?php } ?>

            </div>
            <!-- textarea -->
            <div class="mb-3">
                <label for="address" class="form-label">Address :</label>
                <textarea name="address" class="form-control" id="address" rows="3"><?php echo $user[3] ?></textarea>
                <?php if ($errors && isset($errors['address']) && !empty($errors['address'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['address'] ?>
                    </div>
                <?php } ?>

            </div>
            <!-- select -->
            <select name="country" class="form-select" aria-label="Default select example">
                <option disabled>Open this select menu</option>
                <option <?php echo ($user[4] == 'cairo') ? 'selected' : '' ?> value="cairo">Cairo</option>
                <option <?php echo ($user[4] == 'mansoura') ? 'selected' : '' ?> value="mansoura">Mansoura</option>
                <option <?php echo ($user[4] == 'damietta') ? 'selected' : '' ?> value="damietta">Damietta</option>
            </select>
            <?php if ($errors && isset($errors['country']) && !empty($errors['country'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errors['country'] ?>
                </div>
            <?php } ?>
            <!-- Radio checkboxes -->
            <div class="row my-3">
                <div class="col-2">
                    <label for="gender" class="form-label">Gender :</label>
                </div>
                <div class="form-check col-2">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo ($user[5] == 'male') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check col-2">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo ($user[5] == 'female') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <?php if ($errors && isset($errors['gender']) && !empty($errors['gender'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['gender'] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Skills: </label>
                <div class="row">
                    <div class="form-check">
                        <input name="skills[]" type="checkbox" class="form-check-input" id="php" value="php" <?php echo (in_array("php", $user[6])) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="php">PHP</label>
                    </div>
                    <div class="form-check">
                        <input name="skills[]" type="checkbox" class="form-check-input" id="mysql" value="mysql" <?php echo (in_array("mysql", $user[6])) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="mysql">mysql</label>
                    </div>
                    <div class="form-check">
                        <input name="skills[]" type="checkbox" class="form-check-input" id="post" value="post" <?php echo (in_array("post", $user[6])) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="post">PostGre</label>
                    </div>
                    <div class="form-check">
                        <input name="skills[]" type="checkbox" class="form-check-input" id="java" value="java" <?php echo (in_array("java", $user[6])) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="java">Java</label>
                    </div>
                    <?php if ($errors && isset($errors['skills']) && !empty($errors['skills'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errors['skills'] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- login -->
            <div class="mb-3">
                <label for="username" class="form-label">username : </label>
                <input name="username" type="text" class="form-control" id="username" value="<?php echo $user[7] ?>">
                <?php if ($errors && isset($errors['username']) && !empty($errors['username'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['username'] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password : </label>
                <input name="password" type="text" class="form-control" id="password" value="<?php echo $user[8] ?>">
                <?php if ($errors && isset($errors['password']) && !empty($errors['password'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['password'] ?>
                    </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="dept" class="form-label">dept : </label>
                <input name="dept" readonly value="<?php echo $user[9] ?>" type="text" class="form-control" id="dept">
                <?php if ($errors && isset($errors['dept']) && !empty($errors['dept'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['dept'] ?>
                    </div>
                <?php } ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>