<?php
// DSN : data source name
$dsn = 'mysql:host=localhost;dbname=my_guitar_shop1';
$username = 'mgs_user';
$password = 'pa55word';

try {
    // PDO : PHP database object
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('database_error.php'); //redirect us to here
    exit();
}
