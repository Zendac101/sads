<?php

require_once("../connection/conn.php");


$loc_stmt=$conn->query("SELECT site_name, site_id FROM location ORDER BY site_name ASC");
$loc_exist=$loc_stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["Loc_id"])){
    $selected_ids=$_GET["Loc_id"];
$pollutant_data=$conn->query("SELECT * FROM pollutant_values WHERE site_id=$selected_ids");
$pollutant_data_exist=$pollutant_data->fetchALL(PDO::FETCH_ASSOC);

    echo  json_encode($pollutant_data_exist);
    exit;




}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/data_table_style.css">
    <title>Document</title>
</head>
<body>


     <div class="data-table">

            <table>
               <thead>
                <th>Date</th>  
                <th>
                    <label for="Location">Location</label>
                    <select name="Location" id="Location" onchange="toPHP(value)"><option value="">Select Location</option></select>


                </th>  
                <th>AQI</th>  
                <th>Status</th>  
                <th>SO2</th>  
                <th>O3</th>  
                <th>CO</th>  
                <th>NO2</th>  
                <th>NOX</th>  
                <th>NO</th>  
                

               </thead>


                <tbody id="table_pollutant">
                    
                </tbody>
            </table>

<script>

const loc_dropdown=document.getElementById("Location");
const locs=<?php echo json_encode($loc_exist); ?>;



locs.forEach(location => {

    const option= new Option(location.site_name,location.site_id);


    loc_dropdown.add(option);
});


function toPHP(value){
if(!value) {
    return;
}
    const site_id=""
    const pathname=window.location.pathname

fetch(pathname+"?Loc_id="+value).then(Response=>Response.json()).then(data=>{
const tbody=document.getElementById("table_pollutant");
tbody.innerHTML = "";

data.forEach(row => {
                const tr = document.createElement("tr");
                
                tr.innerHTML = `
                    <td>${row.date || 'N/A'}</td>
                    <td>${loc_dropdown.options[loc_dropdown.selectedIndex].text}</td>
                    <td>${row.aqi || 0.0}</td>
                    <td class="${(row.status || 'good').toLowerCase()}">${row.status || 'Good'}</td>
                    <td>${row.so2 || 0.0}</td>
                    <td>${row.o3 || 0.0}</td>
                    <td>${(row.co) || 0.0}</td>
                    <td>${row.no2 || 0.0}</td>
                    <td>${row.nox || 0.0}</td>
                    <td>${row.no || 0.0}</td>
                `;
                
                tbody.appendChild(tr);
            });
        })
        .catch(err => console.error("Error updates:", err));


};





</script>


        </div>
</body>
</html>