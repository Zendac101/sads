<?php

require_once('conn.php');


if ($_SERVER['REQUEST_METHOD']=="POST"){
    $username=$_POST['username'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
 

    try{
        $sql="INSERT INTO user_info(username,password,date_created,first_name,last_name,email) 
        VALUES (?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$username,$password,date('Y-m-d'),$fname,$lname,$email]);
        header("Location: ../login.php"); 
    exit();
    }
    catch(PDOException $e){
        echo"failed".$e->getMessage();
        }
    


    }