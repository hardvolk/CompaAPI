<?php
/**
 * Created by Compa for the CompaApp project
 * Date: 13/09/2016
 */
 
$servername = "localhost";
$mysql_username = "root";
$mysql_password = "";
$dbname = "compa_app";

try {
    $DB = new PDO("mysql:host=$servername;dbname=$dbname;charset=UTF8", $mysql_username, $mysql_password);
    // set the PDO error mode to exception
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}