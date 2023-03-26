<?php
$title = "Users Table";
include_once("layouts/header.php");
require 'connection/db_connect.php';


$db = db_connection();
if ($db) {
    $query = 'SELECT * FROM `cafeteria`.`users`;';
    $stmt = $db->prepare($query);

    $res = $stmt->execute();
    if ($res) {
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

?>

<div class="container bg-dark text-white">
    <div class="row mt-5">
        <div class="col-12">
            <div class="h1 text-center my-3">Users</div>

            <div class="col-12">
                <table class="table table-striped table-dark text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Room No</th>
                            <th>Image</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                        <tr>
                            <th><?= $user->id ?></th>
                            <td><?= $user->name ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->password ?></td>
                            <td><?= $user->room_no ?></td>
                            <td><img src="<?= "assets/img/" . $user->image ?>" width="50px" height="50px" alt=""></td>
                            <td>
                                <a href="edit.php?id=<?= $user->id ?>" class="btn btn-info">Edit</a>


                            </td>
                            <td>
                                <a href="delete.php?id=<?= $user->id ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once("layouts/footer.php");
?>