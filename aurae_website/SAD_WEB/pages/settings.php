<!DOCTYPE php>
<php lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aurae Admin</title>

<link rel="stylesheet" href="..\assets\css\settings_style.css">
<link rel="stylesheet" href="..\assets\css\global.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

<div id="container" >

  <?php include "..\component\sidebar.php"; ?>

    <main class="main">

      <?php include "../component/topbar.php"; ?>
        <div class="header">
            <div class="header-left">
                <h1>Settings</h1>
                <p>Control, configure, and manage everything in one place.</p>
            </div>
        </div>

        <div class="settings-box">

            <div class="setting-item" id="setting-account">
                <div>


                    <h5><span>Account</span></h5><br>
                    <div class="content_hidden" id="account_hidden">
                     <h6>Username:<span class="profile"> <?php echo ucfirst($_SESSION['username']); ?></span></h6><br>
                      <h6>Full Name:<span class="profile"> <?php echo ucfirst($_SESSION['fname']. ' '. $_SESSION['lname']); ?></span></h6><br>
                     <h6>Role: <span class="profile"><?php echo ucfirst($_SESSION['role']); ?></span></h6><br>
                    <h6>Email:<span class="profile"> <?php echo ucfirst($_SESSION['email']); ?></span></h6><br><br>

                    
                    <button id="edit_account">Edit</button><br>
                
                    <dialog id="account_overlay">
                    <h5>edit account</h5>
                    <button id="close_but">close</button>
                    </dialog>

                    <button id="change_pass">Change Password</button>
                </div>
                </div>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-account','account_hidden')"></button>
            </div>



            <div class="setting-item" id="setting-system_name">
                <div>
                    <h5><span>System Name / Logo</span></h5>
                    <div class="content_hidden" id="">

                    </div>   
                </div>
                
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-system_name')"></button>
            </div>

            <div class="setting-item" id="setting-data_source">
                <div>
                    <h5><span>Data Source Settings</span></h5>
                    <div class="content_hidden" id="">

                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-data_source')"></button>
            </div>

            <div class="setting-item" id="setting-threshold">
                <div>
                    <h5><span>Air Quality Threshold Rules</span></h5>
                    <div class="content_hidden" id="">
                        
                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-threshold')"></button>
            </div>

            <div class="setting-item" id="setting-activity_log">
                <div>
                    <h5><span>Activity Log</span></h5>
                    <div class="content_hidden" id="">
                        
                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-activity_log')"></button>
            </div>

            <div class="setting-item" id="setting-report_format">
                <div>
                    <h5><span>Report Format Settings</span></h5>
                    <div class="content_hidden" id="">
                        
                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-report_format')"></button>
            </div>

            <div class="setting-item" id="setting-backup">
                <div>
                    <h5><span>Backup & Restore</span></h5>
                    <div class="content_hidden" id="">
                        
                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-backup')"></button>
            </div>

            <div class="setting-item" id="setting-notification">
                <div>
                    <h5><span>Email Notification Settings</span></h5>
                    <div class="content_hidden" id="">
                        
                    </div>  
                </div>

                <button class="fas fa-ellipsis-h" onclick="expansion('setting-notification')"></button>
            </div>

        </div>

    </main>

</div>
<script src="..\assets\js\setting_expand.js"></script>
<script src="..\assets\js\toggle_sidebar.js">


</script>


</body>
</php>
