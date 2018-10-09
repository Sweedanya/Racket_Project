<?php
define("root_path", __dir__);

/*   SERVER VARIABLES */

define("db_adress", "localhost");
define("db_username", "root");
define("db_password", "password123");
define("db_name", "racket_club_db");

/*  AGE TO JOIN CLUB */
define("age_to_join", 18);

/* Wesbite DIR */
define('DIR', 'http://sweedanya.co.uk/');
/* Club email address - verification emails are sent from here */
define('SITEEMAIL', 'james-weeden@sweedanya.co.uk');

$dsn = "mysqku:host=" . db_adress . ";dbname=" . db_name;
