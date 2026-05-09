<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurae Admin</title>
    <link rel="preload" as="image" href="aurae_pic.png">
    <link rel="stylesheet" href="login_style.css">


</head>



<?php
require_once("connection\conn.php");
$sql_admin="SELECT * FROM admin_info";
$sql_user="SELECT * FROM user_info";

$res_admin=$conn->query($sql_admin);
$res_user=$conn->query($sql_user);
$row_admin=$res_admin->fetchAll(PDO::FETCH_ASSOC);
$row_user=$res_user->fetchAll(PDO::FETCH_ASSOC);
$adminlist=json_encode($row_admin)?:'[]';
$userlist=json_encode($row_user)?:'[]';
?>





<body>

    <form class="card" method= "" action="" >

        <div class="logo">
            <img src="logo_aurae.png">
        </div>

        <h2>Aurae Login</h2>

        <p>Enter your email to login for this app</p>

        <input type="text" id="email" name="email" placeholder="username@gmail.com" required>
        <input type="password" id="password" name="password" placeholder="password" required>

        <button type="button" id="login_but">
            Login
        </button>
        
        <p class="divider">or continue with</p>

        <button type="button" class="google" onclick="window.location.href='sign_in.php';" >
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg">
            Continue with Google
        </button>

        <p class="terms">
            By clicking continue, you agree to our
            <span class="link">Terms of Service</span> and
            <span class="link">Privacy Policy</span>
        </p>

    </form>
    <script >
        const username=document.getElementById("email");
        const password=document.getElementById("password")
        const button_login=document.getElementById("login_but")
        const form=document.getElementsByClassName("card")
        const color="#e17e7e"

        const admin=<?php echo $adminlist ?>;
        const user=<?php echo $userlist ?>;

        button_login.addEventListener("click",function(event){
            event.preventDefault();
            const admin_exist=admin.find(admin=>admin.username===username.value)
            const user_exist=user.find(user=>user.username===username.value)


            if (admin_exist){
                username.style.backgroundColor='';
                if (password.value===admin_exist.password){
                    window.location.href="dashboard.php";
                }
                else{
                    password.style.backgroundColor=color;

                }

            }
            else if (user_exist){
                username.style.backgroundColor="";
                if (password.value=== user_exist.password){
                    window.location.href="dashboard.php";

                }
                else{
                    password.style.backgroundColor=color;
                }
            }

            else{
                username.style.backgroundColor=color;
            }
        })
    </script>
</body>

</html>