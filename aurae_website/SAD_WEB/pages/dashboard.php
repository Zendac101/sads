<!DOCTYPE php>
<php lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aurae Admin</title>

<link rel="stylesheet" href="..\assets\css\global.css">
<link rel="stylesheet" href="..\assets\css\dashboard_style.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body>

<div class="container">

     <?php include "..\component\sidebar.php"; ?>

    <main class="main">
<?php include "../component/topbar.php"; ?>

        <div class="header">

            <div class="header-left">
                <h1>Dashboard</h1>
                <p>Monitor, manage, and make decisions with ease.</p>
            </div>

        <div class="header-right">
                <button class="green">+ Add Projects</button>
                <button class="light">Import Data</button>
        </div>

        </div>

        <div class="cards">
            <div class="card">
                <p>Total Records</p>
                <h2>125</h2>
            </div>

            <div class="card">
                <p>Selected Location</p>
                <h2>48 areas</h2>
            </div>

            <div class="card">
                <p>Most Affected Pollutant</p>
                <h2>NO₂</h2>
            </div>
        </div>

        <div class="content">

            <div class="chart">
                <canvas id="aqiChart">
                    
                </canvas>
            </div>

            <div class="sidepanel">

                <div class="contacts">
                    <h4>Contact Team</h4>

                    <div class="contact-item">
                        <div class="avatar-small"></div>
                        <div>
                            <p>Sofia</p>
                            <span>sofia@gmail.com</span>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="avatar-small"></div>
                        <div>
                            <p>Jollibee</p>
                            <span>jollibee@gmail.com</span>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="avatar-small"></div>
                        <div>
                            <p>Dora</p>
                            <span>dora@gmail.com</span>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="avatar-small"></div>
                        <div>
                            <p>Mickey</p>
                            <span>mickey@gmail.com</span>
                        </div>
                    </div>

                </div >

                <button class="green full">Insert Data</button>
                <button class="light full">View Data</button>
                <button class="light full">Delete Data</button>

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
