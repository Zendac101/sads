<?php
$host="localhost";
$dbname="air_quality_database";
$username="root";
$password="12345";

try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

    $conn-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  
}
catch(PDOException $e){
    die("Database Connection Failed: ").$e->getMessage();
}

