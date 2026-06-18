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
                <span>Account</span><br>
                
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-account')"></button>
            </div>

            <div class="setting-item" id="setting-system_name">
                <span>System Name / Logo</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-system_name')"></button>
            </div>

            <div class="setting-item" id="setting-data_source">
                <span>Data Source Settings</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-data_source')"></button>
            </div>

            <div class="setting-item" id="setting-threshold">
                <span>Air Quality Threshold Rules</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-threshold')"></button>
            </div>

            <div class="setting-item" id="setting-activity_log">
                <span>Activity Log</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-activity_log')"></button>
            </div>

            <div class="setting-item" id="setting-report_format">
                <span>Report Format Settings</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-report_format')"></button>
            </div>

            <div class="setting-item" id="setting-backup">
                <span>Backup & Restore</span>
                <button class="fas fa-ellipsis-h" onclick="expansion('setting-backup')"></button>
            </div>

            <div class="setting-item" id="setting-notification">
                <span>Email Notification Settings</span>
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
