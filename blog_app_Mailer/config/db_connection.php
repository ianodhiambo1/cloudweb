<?php
require_once "db_constants.php";
$db_connect = new mysqli ($servername , $username , $password , $dbname);
If ($db_connect->connect_error){
    die("Connection failed: ".$db_connect->connect_error);
}
?>