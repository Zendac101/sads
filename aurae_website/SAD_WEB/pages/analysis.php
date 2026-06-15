<!DOCTYPE php>
<php lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aurae Admin</title>

<link rel="stylesheet" href="..\assets\css\global.css">
<link rel="stylesheet" href="..\assets\css\analysis_style.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

<div class="container">

     <?php include "..\component\sidebar.php"; ?>

    <main class="main">

        <?php include "../component/topbar.php"; ?>

        <div class="header">
            <div class="header-left">
                <h1>Analysis</h1>
                <p>Turn data into clear insights.</p>
            </div>
        </div>

        <div class="chart-box">
            <h3>Temporal AQI Analysis</h3>
            <div class="chart-placeholder">
                
            </div>
        </div>

        <div class="bottom-section">

            <div class="map-box">
                <h3>48 Areas in Pangasinan</h3>
                <div class="map-placeholder">
                
                <img src="..\assets\images\pangasinan_map.png" alt="pangasinan map" id="pang_map">

                </div>
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