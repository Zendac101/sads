<?php
session_start();
require_once("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_email = trim($_POST['email'] ?? '');
    $input_password = $_POST['password'] ?? '';

    if (!empty($input_email) && !empty($input_password)) {
        
        //check if admin
        $admin_stmt = $conn->prepare("SELECT * FROM admin_info WHERE email = :username");
        $admin_stmt->execute(['username' => $input_email]);
        $admin_exist = $admin_stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_exist) {
            // verify password
            if (password_verify($input_password, $admin_exist['password'])) {
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $admin_exist['username'];
                
                header("Location: ../pages/dashboard.php");
                exit();
            } else {
               header("Location: ../index.php?error=password&username=" . urlencode($input_email));
            }
        } else {
            // check id user
            $user_stmt = $conn->prepare("SELECT * FROM user_info WHERE email = :username");
            $user_stmt->execute(['username' => $input_email]);
            $user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_exist) {
                // verify password
                if (password_verify($input_password, $user_exist['password'])) {
                    $_SESSION['role'] = 'user';
                    $_SESSION['username'] = $user_exist['username'];
                    
                    header("Location: ../pages/dashboard.php");
                    exit();
                } else {
                   header("Location: ../index.php?error=password&username=" . urlencode($input_email));
                }
            } else {
                // if username not exist
                header("Location: ../index.php?error=username");
                exit();
            }
        }
    }
}
?>