<?php

require_once("..\config\conn.php");


$loc_stmt=$conn->query("SELECT site_name, site_id FROM location ORDER BY site_name ASC");
$loc_exist=$loc_stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["Loc_id"])){
    $selected_ids=$_GET["Loc_id"];
$pollutant_data=$conn->query("SELECT * FROM pollutant_values WHERE site_id=$selected_ids");
$pollutant_data_exist=$pollutant_data->fetchALL(PDO::FETCH_ASSOC);

$labels = array_column($pollutant_data_exist, 'date');
$values = array_column($pollutant_data_exist, 'aqi');

echo json_encode([
        'labels' => $labels,
        'values' => $values
    ], JSON_NUMERIC_CHECK);

    exit;




}
?>





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

<div id="container">

     <?php include "..\component\sidebar.php"; ?>

    <main class="main">

        <?php include "../component/topbar.php"; ?>

        <div class="header">
            <div class="header-left">
                <h1>Analysis</h1>
                <p>Turn data into clear insights.</p>
            </div>
        </div>

        <div id="chart-box">
            <div id="chart_top"><h3>Temporal AQI Analysis</h3>
                <select name="Location" id="Location" onchange="toPHP(value)">
                <option value="">Select Location</option>

                </select>
            </div>


        <div class="chart-placeholder" >
    <canvas id="dbChart"  style="position: relative; width: 100%; height: 100%;"></canvas>
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

<script src="..\assets\js\toggle_sidebar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
//location dropdown 
const loc_dropdown=document.getElementById("Location");
const locs=<?php echo json_encode($loc_exist); ?>;



locs.forEach(location => {

    const option= new Option(location.site_name,location.site_id);


    loc_dropdown.add(option);
});


//chart part
const pathname=window.location.pathname
let myChartInstance = null;

document.getElementById("Location").addEventListener('change',function(){
chart=document.getElementById('chart-box')
if(chart){
chart.classList.add("expanded");
}}
);  

function toPHP(value){
if(!value) {    
    return;
}

  
console.log("Fetching data for site_id:", value);


fetch(pathname+"?Loc_id="+value).then(Response=>Response.json()).then(data=>{

const canvasElement = document.getElementById('dbChart');
        const ctx = canvasElement.getContext('2d');
        
     
        // remove current chart
        const existingChart = Chart.getChart(canvasElement); 
        if (existingChart) {
            existingChart.destroy();
        }
        if (myChartInstance) {
            myChartInstance.destroy();
        }
        
        //  new chart
        myChartInstance = new Chart(ctx, { 
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'AQI Levels',
                    data: data.values,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    borderWidth: 2,
                    tension: 0.2,
                    fill: true,
                    pointBackgroundColor: function(context) {
                    const index = context.dataIndex;
                    const value = context.dataset.data[index];
                    
                    if (value <= 50) {
                        return 'rgb(76, 175, 80)';   
                    } else if (value <= 100) {
                        return 'rgb(255, 152, 0)';  
                    } else {
                        return 'rgb(244, 67, 54)';   
                    }
                },
                pointBorderColor: function(context) {
                    const index = context.dataIndex;
                    const value = context.dataset.data[index];
                    
                    if (value <= 50) {
                        return 'rgb(56, 142, 60)';   
                    } else if (value <= 100) {
                        return 'rgb(230, 126, 34)';  
                    } else {
                        return 'rgb(198, 40, 40)';   
                    }
}
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    })
        .catch(err => console.error("Error updates:", err));


};





</script>




</body>
</php>