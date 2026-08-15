<?php
session_start();
require_once("users_database.php");



//to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_email = trim($_POST['email'] ?? '');
    $input_password = $_POST['password'] ?? '';

// Retain email for repopulating if login fails
    $_SESSION['old'] = [
        'login_email' => $input_email
    ];

    if (!empty($input_email) && !empty($input_password)) {
//check user
$user_stmt = $conn->prepare("
    SELECT 
        c.email,
        c.password,
        a.first_name,
        a.last_name,
        a.created_at AS date_created,
        t.role,
        a.username
    FROM users.user_credentials c
    LEFT JOIN users.user_account a ON a.user_id = c.user_id
    LEFT JOIN users.tags t ON t.user_id = c.user_id
    WHERE c.email = :email
    LIMIT 1
");

$user_stmt->execute([':email' => $input_email]);
$user_exist = $user_stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_exist) {
                // verify password
                if (password_verify($input_password, $user_exist['password'])) {
                    $_SESSION['email']=$user_exist['email'];
                    $_SESSION['role'] = $user_exist['role'];
                    $_SESSION['username'] = $user_exist['username'];
                    $_SESSION['fname'] = $user_exist['first_name'];
                $_SESSION['lname'] = $user_exist['last_name'];
                $_SESSION['created'] = $user_exist['date_created'];
                    
                    header("Location: ../pages/dashboard.php");
                    exit();
                } else {
                   header("Location: ../index.php?log_error=invalid_password" );
                }
            } else {
                // if username not exist
                header("Location: ../index.php?log_error=invalid_email");
                exit();
            }
        
    }
}
?>