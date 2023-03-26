<?php
require 'connection/db_connect.php';


$db = db_connection();
if ($db) {
    $query = 'DELETE FROM `users` WHERE `id`=:user_id;';

    $user_id = $_GET['id'];
    $stmt = $db->prepare($query);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $res = $stmt->execute();

    if ($res) {
        header("Location: users.php");
        exit;
    }
}
