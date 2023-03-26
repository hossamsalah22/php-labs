<?php

require 'connection/db_connect.php';
//
$db = db_connection();
var_dump($db);
CREATE TABLE `cafeteria`.`users` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(225) NOT NULL , `email` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , `room_no` ENUM("App-1", "App-2", "cloud") NOT NULL , `image` VARCHAR(225) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;