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

<div class="container">

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

            <div class="setting-item">
                <span>Account</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>System Name / Logo</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Data Source Settings</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Air Quality Threshold Rules</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Activity Log</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Report Format Settings</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Backup & Restore</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

            <div class="setting-item">
                <span>Email Notification Settings</span>
                <i class="fas fa-ellipsis-h"></i>
            </div>

        </div>

    </main>

</div>

<script>
document.getElementById("toggleSidebar")
.addEventListener("click", function () {
    document.querySelector(".sidebar")
    .classList.toggle("collapsed");
});
</script>

</body>
</php>
