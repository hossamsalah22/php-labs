<?php
if ($_GET['id']) {
    $id = $_GET['id'];
    $users = file("users.txt");
    $users = array_filter($users, function ($user) use ($id) {
        $user = explode(":", $user);
        return $user[0] != $id;
    });
    file_put_contents("users.txt", implode("", $users));
    header("location:users.php");
}
