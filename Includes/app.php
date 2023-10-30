<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'thesun');

include_once('DatabaseConnection.php');
$db = new DatabaseConnection; // use this->conn = $db->conn; for classes
$conn = $db->connect(); // use $dbc for main class database calls

?>