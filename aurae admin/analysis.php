<!DOCTYPE php>
<php lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aurae Admin</title>

<link rel="stylesheet" href="global.css">
<link rel="stylesheet" href="analysis_style.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <aside class="sidebar">
        <div class="logo">
            <img src="logo_aurae.png" class="logo-img">
            <h2>Aurae Admin</h2>
        </div>

        <ul class="menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="data_management.php"><i class="fas fa-database"></i> Data Management</a></li>
            <li class="active"><a href="analysis.php"><i class="fas fa-chart-line"></i> Analysis</a></li>
            <li><a href="reports.php"><i class="fas fa-file-alt"></i> Reports</a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="support.php"><i class="fas fa-life-ring"></i> Support / Help</a></li>
        </ul>
    </aside>

    <main class="main">

        <div class="topbar">

            <button id="toggleSidebar" class="menu-btn">
                <i class="fas fa-bars"></i>
            </button>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search task">
            </div>

            <div class="user">
                <div class="icons">
                    <i class="fas fa-envelope"></i>
                    <i class="fas fa-bell"></i>
                </div>

                <div class="avatar"></div>

                <div class="user-info">
                    <span class="name">Jose Batumbakal</span>
                    <span class="email">josebatumbakal@gmail.com</span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-left">
                <h1>Analysis</h1>
                <p>Turn data into clear insights.</p>
            </div>
        </div>

        <div class="chart-box">
            <h3>Temporal AQI Analysis</h3>
            <div class="chart-placeholder">
                Chart Area
            </div>
        </div>

        <div class="bottom-section">

            <div class="map-box">
                <h3>48 Areas in Pangasinan</h3>
                <div class="map-placeholder">Map</div>
            </div>

            <div class="actions">
                <button class="green">Download AQI Summary</button>
                <button class="light">Add Data</button>
                <button class="light">Delete Data</button>
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