<?php
$host = "localhost";
$port = "5432";
$dbname = "aurae_user_database"; 
$username = "postgres";
$password = "password";
try{
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
  
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
}
catch(PDOException $e){
    die("Database Connection Failed: ".$e->getMessage());
}

