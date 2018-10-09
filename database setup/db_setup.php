<?php

require __DIR__ . "/../includes/config.php";


$options = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
);

$db = new PDO($dsn, db_username, db_password, $options);

$db->query("CREATE DATABASE db_name");

$db->query("CREATE TABLE users (
	user_id INT(16) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_title VARCHAR(16) NOT NULL,
	user_first VARCHAR(64) NOT NULL,
	user_last VARCHAR(64) NOT NULL,
	user_gender VARCHAR(16) NOT NULL,
	user_dob DATE NOT NULL,
	user_pwd VARCHAR(64) NOT NULL,
	user_email VARCHAR(255) NOT NULL,
	privilege ENUM('user', 'admin') NOT NULL,
	validated ENUM('N', 'Y') NOT NULL
	);");

$db->query("CREATE TABLE auth_tokens (
	    ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255),
		verification_code VARCHAR(32) NOT NULL,
		reset_token VARCHAR(32),
        expires BIGINT(20)
	);");
