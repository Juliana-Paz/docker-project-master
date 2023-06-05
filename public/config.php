<?php
define('DB_SERVER', 'mysql');
define('DB_USERNAME', 'juliana');
define('DB_PASSWORD', '123');
define('DB_NAME', 'redes1');
 
// Attempt to connect to mysql database 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect to database. " . mysqli_connect_error());
}
?>
