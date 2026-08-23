<?php 
session_start();

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

// Check if an error message was passed back in the URL
$default_form = 'login_form';
$error_message = ""; 

if (isset($_GET['reg_error'])) {
    
    if ($_GET['reg_error'] == "email_exists") {
        $error_message = "Email already exists!";
        $default_form="register_form";
        ?><style>.reg_email{background-color: #e17e7e;}</style><?php
    } 
    
    elseif ($_GET['reg_error'] == "password_mismatch") {
        $error_message = "Passwords do not match!";
        $default_form="register_form";
        ?><style>.reg_password{background-color: #e17e7e;}
        .con_password{background-color: #e17e7e;}
        </style><?php
    } 

    elseif ($_GET['reg_error'] == "verification_failed") {
        $error_message = "Email verification failed";
        $default_form="register_form";
        ?><style>.reg_email{background-color: #e17e7e;}
        </style><?php
    } }
        

if(isset($_GET['log_error'])){    
    if($_GET['log_error']=="invalid_password"){
        $error_message="Wrong Password";
        $default_form="login_form";
        ?><style>.log_password{background-color: #e17e7e;}
        </style><?php
    }
    elseif($_GET['log_error']=="invalid_email"){
        $error_message="Invalid email";
        $default_form="login_form";
        ?><style>.log_email{background-color: #e17e7e;}
        </style><?php
    }
}

if(isset($_GET['state'])){
    if ($_GET['state']=="success"){
        $state_message="Registration Successful";
    }
}

?>  





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


<div class="form-box <?php echo ($default_form === 'login_form') ? 'active' : ''; ?>"  id="login_form">
    <form class="card" id="login_form" method= "POST" action="config\login_ver.php" >

        <div class="logo">
            <img src="assets\images\logo_aurae.png">
        </div>

        <h2>Aurae Login</h2>    

        <p>Enter your email to login for this app</p>

 
        <?php if (!empty($error_message)&&($default_form=="login_form")): ?>
            <div class="error-msg" style="color: red; margin-bottom: 15px; font-size: 12px;">
                <?php echo htmlspecialchars($error_message); ?>
                
            </div>
        <?php endif; ?>

        <input type="text" class="log_email" id="email" name="email" value="<?php echo htmlspecialchars($old['login_email'] ?? ''); ?>" placeholder="username@gmail.com" required>
      
        <input type="password" class="log_password" id="password" name="password" placeholder="password" required>

       
        <button type="submit" id="login_but">
            Login
        </button>
        
        <p class="divider">or continue with</p>

          <button type="button" class="google" id="google_btn">
            Google
        </button>

        <button type="button"  onclick="showForm('register_form')" >
            
            Sign up
        </button>

        <p class="terms">
            By clicking login, you agree to our
            <span class="link">Terms of Service</span> and
            <span class="link">Privacy Policy</span>
        </p>    

    </form>
    </div>



        <!-- register form -->
<div class="form-box <?php echo ($default_form === 'register_form') ? 'active' : ''; ?>" id="register_form">

<form class="card" id="signUp_form" method="POST" action="config\user_reg.php" >

        <div class="logo">
            <img src="assets\images\logo_aurae.png">
        </div>

        <h2>Aurae Sign Up</h2>

        <h3>Create an account</h3>
        <p>Enter your credentials to sign up for this app</p>

<?php if (!empty($error_message)&&($default_form=="register_form")): ?>
            <div class="error-msg" style="color: red; margin-bottom: 15px; font-size: 12px;">
                <?php echo htmlspecialchars($error_message); ?>
                
            </div>
        <?php endif; ?>

<?php if (!empty($state_message)): ?>
            <div class="error-msg" style="color: green; margin-bottom: 15px; font-size: 12px;">
                <?php echo htmlspecialchars($state_message); ?>
                
            </div>
        <?php endif; ?>

        <input type="text" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($old['username'] ?? ''); ?>" required>

        <input type="text" id="fname" name="fname" placeholder="First Name" value="<?php echo htmlspecialchars($old['fname'] ?? ''); ?>" required>

        <input type="text" id="lname" name="lname" placeholder="Last Name" value="<?php echo htmlspecialchars($old['lname'] ?? ''); ?>" required>

        <input type="email" class="reg_email" id="signUp_email" name="email" placeholder="@gmail.com" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required> <button type="button" id="but_verify"><h6>Verify</h6></button>

        <input type="password" class="reg_password" id="signUp_password" name="password" placeholder="password" minlength="8" required>
        
        <input type="password" class="con_password" id="con_password" name="con_password" placeholder="Confirm password" minlength="8" required>

        <button type="submit" id="submits_btn" >
            Sign up 
        </button>

        <button type="button" onclick="showForm('login_form')">
            Login
        </button>

        <p class="terms">
            By clicking continue, you agree to our
            <span class="link">Terms of Service</span> and
            <span class="link">Privacy Policy</span>
        </p>
     
    </form>

</div>




<script src="assets\js\form_change.js"></script>
<script type="module" src="config\email_auth.js"></script>

</body>

</html>