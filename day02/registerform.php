<?php
$errors = [];
if ($_GET) {
	$errors = json_decode($_GET['errors'], true);
	$old = json_decode($_GET['old'], true);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Register form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <h1 class="mb-5 text-center">Welcome, Lab01 Solution</h1>
        <form method="post" action="users.php">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control"
                    value="<?= ($old && $old['fname']) ? $old['fname'] : '' ?>" />
                <?php if ($errors && isset($errors['fname']) && !empty($errors['fname'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['fname'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control"
                    value="<?= ($old && $old['lname']) ? $old['lname'] : '' ?>" />
                <?php if ($errors && isset($errors['lname']) && !empty($errors['lname'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['lname'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="3"
                    value="<?= ($old && $old['address']) ? $old['address'] : '' ?>"></textarea>
                <?php if ($errors && isset($errors['address']) && !empty($errors['address'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['address'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Country</label>
                <select class="form-select form-select-lg" name="country" id="">
                    <option selected disabled>Select one</option>
                    <option <?= ($old && $old['country'] && $old['country'] == 'cairo') ? 'selected' : '' ?>
                        value="cairo">Cairo</option>
                    <option <?= ($old && $old['country'] && $old['country'] == 'mansoura') ? 'selected' : '' ?>
                        value="mansoura">Mansoura</option>
                    <option <?= ($old && $old['country'] && $old['country'] == 'damietta') ? 'selected' : '' ?>
                        value="damietta">Damietta</option>
                </select>
                <?php if ($errors && isset($errors['country']) && !empty($errors['country'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['country'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Gender</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                        <?= ($old && $old['gender'] && $old['gender'] == 'male') ? 'checked' : '' ?> />
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                        <?= ($old && $old['gender'] && $old['gender'] == 'female') ? 'checked' : '' ?> />
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <?php if ($errors && isset($errors['gender']) && !empty($errors['gender'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['gender'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Skills</label>
                <div class="form-check">
                    <input class="form-check-input" name="skills[]" type="checkbox" value="php" id="php"
                        <?= ($old && $old['skills'] && in_array("php", $old["skills"])) ? 'checked' : '' ?> />
                    <label class="form-check-label" for="php"> PHP </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="skills[]" type="checkbox" value="mysql" id="mysql"
                        <?= ($old && $old['skills'] && in_array("mysql", $old["skills"])) ? 'checked' : '' ?> />
                    <label class="form-check-label" for="mysql"> MySql </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="skills[]" type="checkbox" value="post" id="post"
                        <?= ($old && $old['skills'] && in_array("post", $old["skills"])) ? 'checked' : '' ?> />
                    <label class="form-check-label" for="postgre"> PostGre </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="skills[]" type="checkbox" value="java" id="java"
                        <?= ($old && $old['skills'] && in_array("java", $old["skills"])) ? 'checked' : '' ?> />
                    <label class="form-check-label" for="java"> Java </label>
                </div>
                <?php if ($errors && isset($errors['skills']) && !empty($errors['skills'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['skills'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                    value="<?= ($old && $old['username']) ? $old['username'] : '' ?>" />
                <?php if ($errors && isset($errors['username']) && !empty($errors['username'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['username'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    value="<?= ($old && $old['password']) ? $old['password'] : '' ?>">
                <?php if ($errors && isset($errors['password']) && !empty($errors['password'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['password'] ?>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="dept" class="form-control"
                    value="<?= ($old && $old['dept']) ? $old['dept'] : 'OpenSource' ?>" readonly />
                <?php if ($errors && isset($errors['dept']) && !empty($errors['dept'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['dept'] ?>
                </div>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary mb-5">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>