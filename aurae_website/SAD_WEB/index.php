
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurae Admin</title>
    <link rel="preload" as="image" href="assets/images/aurae_pic.png">
    <link rel="stylesheet" href="assets/css/login_style.css">


</head>


<body>



    <form class="card" method= "POST" action="config\login_ver.php" >

        <div class="logo">
            <img src="assets\images\logo_aurae.png">
        </div>

        <h2>Aurae Login</h2>    

        <p>Enter your email to login for this app</p>



        <input type="text" id="email" name="email" placeholder="username@gmail.com" required>
        <input type="password" id="password" name="password" placeholder="password" required>

        <button type="submit" id="login_but">
            Login
        </button>
        
        <p class="divider">or continue with</p>

        <button type="button" class="google" onclick="window.location.href='pages/sign_in.php';" >
            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg">
            Continue with Google
        </button>

        <p class="terms">
            By clicking continue, you agree to our
            <span class="link">Terms of Service</span> and
            <span class="link">Privacy Policy</span>
        </p>

    </form>
    
</body>

</html>