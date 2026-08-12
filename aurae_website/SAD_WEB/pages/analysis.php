<?php

require_once("..\config\conn.php");


//get all location name anmd id
$loc_stmt=$conn->query("SELECT site_name, site_id FROM location ORDER BY site_name ASC");
$loc_exist=$loc_stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["Loc_id"])){
    $selected_ids=!empty($_GET["Loc_id"]) ? $_GET['Loc_id'] : '0';
    $min_date_range = !empty($_GET['min']) ? $_GET['min'] : '2000-01-01';
    $max_date_range = !empty($_GET['max']) ? $_GET['max'] : '2030-01-01';
    $pollutant_value=$_GET['pollutants'];


    //swap if minimum is larger than max
    if ($min_date_range>$max_date_range){
    [$min_date_range,$max_date_range]=[$max_date_range,$min_date_range];
    }


$stmt = $conn->prepare("SELECT * FROM pollutant_values WHERE site_id = ? AND date >= ? AND date <= ?");
$stmt->execute([$selected_ids, $min_date_range, $max_date_range]);
$pollutant_data_exist=$stmt->fetchALL(PDO::FETCH_ASSOC);

$labels = array_reverse(array_map(function($row) {
    // Combines date and time (e.g. "2024-08-31 23:00")
    return $row['date'] . ' ' . sprintf('%02d:00', $row['time']);
}, $pollutant_data_exist));

$values = array_reverse(array_column($pollutant_data_exist, $pollutant_value));


//get original date
$ori_date = $conn->prepare("SELECT MIN(date) as original_min, MAX(date) as original_max FROM pollutant_values WHERE site_id = ?");
    $ori_date->execute([$selected_ids]);
    $ori_date_exist = $ori_date->fetch(PDO::FETCH_ASSOC);


    echo json_encode([ 
        'pollutant_name'=>strtoupper($pollutant_value),
        'max_date' => $ori_date_exist['original_max'] ?? '2030-01-01',
        'min_date' => $ori_date_exist['original_min'] ?? '2000-01-01',
        'labels'   => $labels,
        'values'   => $values
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
            <div id="chart_top">
                <h3>Temporal AQI Analysis</h3>
       
                <div>
<!-- pollutant select -->
                    <label for="pollutants"><b>Pollutant:</b></label>
                    <select name="poluttants" id="pollutants" onchange="toPHP(document.getElementById('Location').value)">
                        <option value="aqi">AQI</option>
                        <option value="so2">SO2</option>
                        <option value="co">CO</option>
                        <option value="o3">O3</option>
                        <option value="nox">NOX</option>
                        <option value="no2">NO2</option>
                        <option value="no">NO</option>
                    </select>

    
                <label for="Location"><b>Location: </b></label>
                <select name="Location" id="Location" onchange="toPHP(value)">
                <option value="0">Select Location</option>

                </select>
           </div>
            </div>

<!-- graoh pollutant level -->
        <div class="chart-placeholder" >
    <canvas id="dbChart"  style="position: relative; width: 100%; height: 100%;"></canvas>
</div>


        </div><br>
        

        <div class="bottom-section">

            <div class="map-box">
                <h3>48 Areas in Pangasinan</h3>
                <div class="map-placeholder">
                
                <img src="..\assets\images\pangasinan_map.png" alt="pangasinan map" id="pang_map">

                </div>
            </div>


            <div class="actions">
                <button  id="download_graph">Download Graph</button>
                <button  id="date_range">Date Range</button>
                <button  id="reset">Reset</button>

                <dialog id="date_range_dialog">
                    <input type="date" id="min" >
                    <input type="date" id="max" >

                    <button id="date_submit" onclick="toPHP(value)">submit</button>
                </dialog>



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


//get all location databse
locs.forEach(location => {

    const option= new Option(location.site_name,location.site_id);


    loc_dropdown.add(option);
});


//date range

document.getElementById('date_range').addEventListener('click', function(){
    document.getElementById('date_range_dialog').showModal();
});


//download chart

document.getElementById('download_graph').addEventListener('click', function() {

const minDateInput = document.getElementById('min')?.value || '';
    const maxDateInput = document.getElementById('max')?.value || '';
    const pollutant_data=document.getElementById('pollutants').value;
    
    const selectElement = document.getElementById("Location");
const selectedLoc = selectElement.options[selectElement.selectedIndex].text;


    const canvas = document.getElementById('dbChart');
    

    const imageURI = canvas.toDataURL('image/png');
    
   
    const link = document.createElement('a');

    file_name="temporal-" + pollutant_data + "-" + selectedLoc + "-" + minDateInput + "/" + maxDateInput;
    link.download = file_name; // file name
    link.href = imageURI;
    
　if ((myChartInstance==null) || (selectElement.value==0)){
    console.log("No location value detected")
    return
}else{
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
});




//reset
document.getElementById('reset').addEventListener('click',function(){window.location.reload()})

//chart part
const pathname=window.location.pathname
let myChartInstance = null;

document.getElementById("Location").addEventListener('change',function(){
chart=document.getElementById('chart-box')
if(chart){
chart.classList.add("expanded");

}}
);  


function toPHP(value) {



    if(!value){console.log('fail')}

    console.log("Fetching data for site_id:", value);

   
    const minDateInput = document.getElementById('min')?.value || '2000-01-01';
    const maxDateInput = document.getElementById('max')?.value || '2199-12-31';
    const pollutant_data=document.getElementById('pollutants').value;









    // url for fetch
    const url = `${pathname}?Loc_id=${value}&min=${encodeURIComponent(minDateInput)}&max=${encodeURIComponent(maxDateInput)}&pollutants=${pollutant_data}`;

    //fetch
    fetch(url)
        .then(response => response.json())
        .then(data => {



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
                    label: data.pollutant_name + ' Level',
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


        
        min_range=document.getElementById('min');
        max_range=document.getElementById("max");

        
        min_range.min=data.min_date;
        min_range.max=data.max_date;
        max_range.min=data.min_date;
        max_range.max=data.max_date;

        
        
        submit_date=document.getElementById("date_submit");
        submit_date.value=value;


        //close overlay
        submit_date.addEventListener('click',function(){
            
            document.getElementById("date_range_dialog").close();
        })









    })
        .catch(err => console.error("Error updates:", err));


};




</script>

</body>
</php>