<?php
/**
 * Title: Database Model
 * Purpose: To configure the connection to the database
 */

$dsn = 'mysql:host=localhost;dbname=spotifyClone';
$username = 'spotifyClone';
$password = 'password';

try
{
    $db = new PDO($dsn, $username, $password);
}
catch (PDOException $e)
{
    $title = "Database Error";
    $body = $e->getMessage();
    include('views/error.php');
    exit();
}
?>
