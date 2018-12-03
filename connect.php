<?php 
$dsn = 'mysql:host=localhost;dbname=dichvu';
    // Set options
    $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    // Create a new PDO instanace
    try {
    $db = new PDO($dsn, 'root', '', $options);
    }
    // Catch any errors
    catch (PDOException $e) {
    echo $e->getMessage();
    exit();
    }

?>