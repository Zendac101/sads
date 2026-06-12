<?php
session_start();
require_once('conn.php');


if ($_SERVER['REQUEST_METHOD']=="POST"){
    $username=$_POST['username'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $con_password=$_POST['con_password'];

    if ($password !== $con_password) {
        header("Location: ../sign_in.php?error=password_mismatch");
        exit();
    }   


    $admin_stmt = $conn->prepare("SELECT * FROM admin_info WHERE email = :username");
    $admin_stmt->execute(['username' => $email]);
    $admin_exist = $admin_stmt->fetch(PDO::FETCH_ASSOC);

    $user_stmt = $conn->prepare("SELECT * FROM user_info WHERE email = :username");
    $user_stmt->execute(['username' => $email]);
    $user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

    
 
    if ($admin_exist || $user_exist){


       header("Location: ..\pages\sign_in.php?error=email_exists");
        exit();
    

    }





    else{
        try{
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql="INSERT INTO user_info(username,password,date_created,first_name,last_name,email) 
            VALUES (:username,:password,:date_created,:fname,:lname,:email)";
            $stmt=$conn->prepare($sql);
            $stmt->execute([
                            ":username" => $username,               
                            ":password" => $hashed_password,               
                            ":date_created" => date("Y-m-d"),               
                            ":fname" => $fname,               
                            ":lname" => $lname,               
                            ":email" => $email,               
                            ]);
            header("Location: ../index.php"); 
        exit();
        }
        catch(PDOException $e){
            echo"failed".$e->getMessage();
            }
            
        }
}