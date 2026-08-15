<?php
session_start();
require_once('users_database.php');





if ($_SERVER['REQUEST_METHOD']=="POST"){


$_SESSION['old'] = [
        'username' => $_POST['username'] ?? '',
        'fname'    => $_POST['fname'] ?? '',
        'lname'    => $_POST['lname'] ?? '',
        'email'    => $_POST['email'] ?? ''
    ];


   $username     = trim($_POST['username'] ?? '');
    $fname        = trim($_POST['fname'] ?? '');
    $lname        = trim($_POST['lname'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';
    $con_password = $_POST['con_password'] ?? '';
  
// Read the JS file content
$jsContent = file_get_contents('email_auth.js');

    $user_stmt = $conn->prepare("SELECT * FROM users.user_credentials WHERE email = :email");
    $user_stmt->execute(['email' => $email]);
    $user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

    
 
    if ($user_exist){


       header("Location: ..\index.php?reg_error=email_exists");
        exit();
    

    }


  if ($password !== $con_password) {
        header("Location: ../index.php?reg_error=password_mismatch");
        exit();
    }   



    else{
        try{
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql="WITH registered_user as (
            INSERT INTO users.user_account (username, first_name, last_name, created_at)
            VALUES (:username, :fname, :lname, :date_created)
            RETURNING user_id
            ),

            reg_cred as (
            INSERT INTO users.user_credentials (user_id,email, password)
            SELECT user_id, :email, :password FROM registered_user
            RETURNING user_id
            )


            INSERT INTO users.tags (user_id, role)
            SELECT user_id, 'client' FROM reg_cred;

            


            ";

            $stmt=$conn->prepare($sql);
            $stmt->execute([
                            ":username" => $username,               
                            ":password" => $hashed_password,               
                            ":date_created" => date("Y-m-d"),               
                            ":fname" => $fname,               
                            ":lname" => $lname,               
                            ":email" => $email,               
                            ]);

            unset($_SESSION['old']);
            header("Location: ../index.php?state=success"); 
        exit();
        }
        catch(PDOException $e){
            echo"failed".$e->getMessage();
            }
            
        }
}