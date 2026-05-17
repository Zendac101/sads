<?php
session_start();
require_once("conn.php");

$error_type = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_email = trim($_POST['email'] ?? '');
    $input_password = $_POST['password'] ?? '';

    if (!empty($input_email) && !empty($input_password)) {
        
        // 2. First check: Is it an Admin?
        $admin_stmt = $conn->prepare("SELECT * FROM admin_info WHERE email = :username");
        $admin_stmt->execute(['username' => $input_email]);
        $admin_exist = $admin_stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_exist) {
            // Compare plain text input against the database BCRYPT hash
            if (password_verify($input_password, $admin_exist['password'])) {
                $_SESSION['role'] = 'admin';
                $_SESSION['username'] = $admin_exist['username'];
                
                header("Location: ../dashboard.php");
                exit();
            } else {
               header("Location: ../login.php?error=password&username=" . urlencode($input_email));
            }
        } else {
            // 3. Second check: Is it a Regular User?
            $user_stmt = $conn->prepare("SELECT * FROM user_info WHERE email = :username");
            $user_stmt->execute(['username' => $input_email]);
            $user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_exist) {
                // Compare plain text input against the database BCRYPT hash
                if (password_verify($input_password, $user_exist['password'])) {
                    $_SESSION['role'] = 'user';
                    $_SESSION['username'] = $user_exist['username'];
                    
                    header("Location: ../dashboard.php");
                    exit();
                } else {
                   header("Location: ../login.php?error=password&username=" . urlencode($input_email));
                }
            } else {
                // Username wasn't found in admin_info OR user_info
                header("Location: ../login.php?error=username");
                exit();
            }
        }
    }
}
?>