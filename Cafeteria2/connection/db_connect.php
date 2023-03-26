<?php



function db_connection()
{

    $dsn = 'mysql:dbname=cafeteria;host=127.0.0.1;port=3306;'; #port number
    $user = 'root';
    $password = '';
    $db = new PDO($dsn, $user, $password);

    return $db;
}
