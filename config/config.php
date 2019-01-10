<?php
const currentTheme ='air_theme';
$theme = currentTheme;

//MYSQL Database Login

$host = "localhost";
$username = "root";
$password = "";
$dbname = "flights";
$dsn = "mysql:host = $host;dbname=$dbname";
//Create connection
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

