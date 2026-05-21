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
        VALUES (:username,:password,:date_created,:fname,:lname,:email)";
        $stmt=$conn->prepare($sql);
        $stmt->execute([
                        ":username" => $username,               
                        ":password" => $password,               
                        ":date_created" => date("Y-m-d"),               
                        ":fname" => $fname,               
                        ":lname" => $lname,               
                        ":email" => $email,               
                        ]);
        header("Location: ../login.php"); 
    exit();
    }
    catch(PDOException $e){
        echo"failed".$e->getMessage();
        }
        
    }