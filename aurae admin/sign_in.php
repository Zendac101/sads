<?php 
// Check if an error message was passed back in the URL
$error_message = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == "email_exists") {
        $error_message = "Email already exists!";
        ?><style>#email{background-color: #e17e7e;}</style><?php
    } elseif ($_GET['error'] == "password_mismatch") {
        $error_message = "Passwords do not match!";
        ?><style>#password{background-color: #e17e7e;}
        #con_password{background-color: #e17e7e;}
        </style><?php
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurae Admin</title>
    <link rel="preload" as="image" href="aurae_pic.png">
    <link rel="stylesheet" href="styles/sign_in_style.css">
</head>


<body>

    <form class="card" method="POST" action="connection/user_reg.php">

        <div class="logo">
            <img src="logo_aurae.png">
        </div>

        <h2>Aurae Sign Up</h2>

        <h3>Create an account</h3>
        <p>Enter your credentials to sign up for this app</p>

<?php if (!empty($error_message)): ?>
            <div class="error-msg" style="color: red; margin-bottom: 15px; font-size: 12px;">
                <?php echo htmlspecialchars($error_message); ?>
                
            </div>
        <?php endif; ?>

        <input type="text" id="username" name="username" placeholder="Username" required>

        <input type="text" id="fname" name="fname" placeholder="First Name" required>

        <input type="text" id="lname" name="lname" placeholder="Last Name" required>

        <input type="email" id="email" name="email" placeholder="@gmail.com" required>

        <input type="password" id="password" name="password" placeholder="password" minlength="8" required>
        
        <input type="password" id="con_password" name="con_password" placeholder="Confirm password" minlength="8" required>

        <button type="submit" id="submits_btn">
            Sign up 
        </button>





        <p class="terms">
            By clicking continue, you agree to our
            <span class="link">Terms of Service</span> and
            <span class="link">Privacy Policy</span>
        </p>
     
    </form>

</body>

</html>