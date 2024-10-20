<?php
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
