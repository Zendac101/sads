<!DOCTYPE php>
<php lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aurae Admin</title>

<link rel="stylesheet" href="..\assets\css\global.css">
<link rel="stylesheet" href="..\assets\css\data_management_style.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

<div class="container">

  <?php include "..\component\sidebar.php"; ?>

    <main class="main">
<?php include "../component/topbar.php"; ?>

        <div class="header" >
            <div class="header-left">
                <h1>Data Management</h1>
                <p>Easily manage and organize air quality data.</p>
            </div>
        </div>

        <div class="data-table">
         

            <iframe src="data_table.php" scrolling="no" >
         
</iframe>

        </div>

        <div class="table-actions">
            <button class="green">Upload CSV</button>
            <button class="light">Replace Data</button>
            <button class="light">Delete Data</button>
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