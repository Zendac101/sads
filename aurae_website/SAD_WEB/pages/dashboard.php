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

<div id="container">

     <?php include "..\component\sidebar.php"; ?>

    <main class="main">
<?php include "../component/topbar.php"; ?>

        <div class="header">

            <div class="header-left">
                <h1>Dashboard</h1>
                <p>Monitor, manage, and make decisions with ease.</p>
            </div>

        <div class="header-right">
                <button class="green"><b>+ Add Device</b> </button>
                <button class="light"><b>Device Status</b> </button>
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
                
                    <div id="top_chart">
                     <div>
                        <b>Device Monitioring</b>
                    </div>   
                    <select name="devices" id="devices">
                        <option value=""></option>
                    </select>
                    </div>

                    <div id="bottom_chart">
                        <h5>Humidity: </h5>
                        <p id="humid_data"></p><br>
                        <h5>Temprature: </h5>
                        <p id="temp_data"></p>
                    </div>

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



        </div>

    </main>

</div>
.
<script src="..\assets\js\toggle_sidebar.js">

</script>
<script>
function fetchLatestReadings() {
    fetch('../api/get_latest_data.php')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                document.getElementById('temp_data').innerText = res.data.temperature + " °C";
                document.getElementById('humid_data').innerText = res.data.humidity + " %";
            }
        })
        .catch(err => console.error('Error fetching sensor data:', err));
}

// Initial fetch
fetchLatestReadings();

// Auto-refresh every 3 seconds
setInterval(fetchLatestReadings, 3000);
</script>




</body>
</php>
