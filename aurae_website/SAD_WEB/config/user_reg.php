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

  
// Read the JS file content
$jsContent = file_get_contents('email_auth.js');

// Match: const myVar = "value"; or var myVar = 'value';
if (preg_match('/(?:let|let|var)\s+verified_email\s*=\s*(true|false);/i', $jsContent, $matches)) {
    $verif = $matches[1];
   
}

    $admin_stmt = $conn->prepare("SELECT * FROM admin_info WHERE email = :email");
    $admin_stmt->execute(['email' => $email]);
    $admin_exist = $admin_stmt->fetch(PDO::FETCH_ASSOC);

    $user_stmt = $conn->prepare("SELECT * FROM user_info WHERE email = :email");
    $user_stmt->execute(['email' => $email]);
    $user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

    
 
    if ($admin_exist || $user_exist){


       header("Location: ..\index.php?reg_error=email_exists");
        exit();
    

    }
    if ($verif == false){


       header("Location: ..\index.php?reg_error=verification_failed");
        exit();
    

    }




  if ($password !== $con_password) {
        header("Location: ../index.php?reg_error=password_mismatch");
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
            header("Location: ../index.php?state=success"); 
        exit();
        }
        catch(PDOException $e){
            echo"failed".$e->getMessage();
            }
            
        }
}