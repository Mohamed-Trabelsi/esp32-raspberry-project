
<?php

$host= 'localhost';
$user='root';
$pass='';
$db='hardware';
$mysqli=  new \MySQLi($host,$user,$pass,$db) ;


$data1='';
$data2='';
$data22='';
//SELECT val FROM `temperature` ORDER BY val DESC LIMIT 1;
$sql="SELECT * from `temperature`";
$sql2="SELECT * from `gaz`";
$sql3="SELECT * from `pression`";

$result= mysqli_query($mysqli,$sql);
$result2= mysqli_query($mysqli,$sql2);
$result3= mysqli_query($mysqli,$sql3);

while($row = mysqli_fetch_array($result))
{
	$data1 = $data1 . '"'. $row['val'].'",';
	
	$data3 = $row['val'];
	
}
$result= mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_array($result2))
{
	$data2 = $data2 . '"'. $row['val'].'",';
	
	$data22 = $row['val'];
	
}
$result= mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_array($result3))
{
	$data33 = $data1 . '"'. $row['val'].'",';
	
	$data333 = $row['val'];
	
}
$data1=trim($data1,",");
$data2=trim($data2,",");
$data33=trim($data33,",");

$mysqli -> close();

?>


<!DOCTYPE html>
<html>
	<head>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<meta http-equiv="refresh" content="1" >
	</head>



<body>
    <div class="container-fluid">
        <div class="row-">
            <div class="col-20">
                    <div class="card">
                        <div class="card-title">
                            <h3 class="bg-success text-white text-center py-3"> Simple System Dashboard</h3>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <div class="card-body">
                                    <table class="table table-bordered  ">
										
													
                                        <tr class="table-active">
                                            <td ><b>Température: </b></td>
											
                                            <td ><b id="temp"></b><?php echo $data3;?> </td>
                                            <td ><b>°C </b></td>
                                        </tr>
										
                                        <tr>
                                            <td><b>Pression: </b></td>
                                            <td><b id="lum"></b><?php echo $data22;?></td>
                                            <td><b> Pa </b></td>
                                        </tr>
                                    
                                        <tr>
                                            <td><b>Gaz: </b></td>
                                            <td><b id="sound"></b><?php echo $data333;?></td>
                                            <td><b> W/H </b></td>
                                        </tr>                                             
                                    </table>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        
                    </div>
            </div>
        </div>
    </div>



<table width="100%" >

	<tr>
		<td  width="33%"><canvas id="tempChart"></canvas></td>
		<td  width="33%"><canvas id="lumChart"></canvas></td>
		<td  width="34%"><canvas id="soundChart"></canvas></td>
	</tr>
	
	<tr>
		<td  width="33%"><b>Température</b></td>
		<td  width="33%"><b>Pression</b></td>
		<td  width="34%"><b>Gaz</b></td>
	</tr>
</table>

	


</body>
</html>


<script>

var maxValues=5;
var tempUpdateCount=0;
var lumUpdateCount=0;
var soundUpdateCount=0;

const onRefresh = chart => {
  const now = Date.now();
  chart.data.datasets.forEach(dataset => {
    dataset.data.push({
      x: now,
      y: Utils.rand(-100, 100)
    });
  });
};
	let tempChartDisplay=document.getElementById('tempChart').getContext('2d');
	var myChart=new Chart(tempChartDisplay,{
		type:'line',
		
		data:{
			labels:[
					
					<?php echo $data1;?>
				],
			datasets:[{
				label:"Temperature",
				data:[
					
					<?php echo $data1;?>
				],
				backgroundColor:'green'

				}
				
			],

		},
		options: {
    scales: {
      x: {
        type: 'realtime',
        realtime: {
          duration: 20000,
          refresh: 1000,
          delay: 2000,
          onRefresh: onRefresh
        }
      },
      y: {
        title: {
          display: true,
          text: 'Value'
        }
      }
    },
    interaction: {
      intersect: false
    }
  }
	})
	
	
	//let pressionChartDisplay=document.getElementById('lumChart').getContext('2d');
	//var mychartlum= new Chart(lumChart,lumConfig) ; 


	lumConfig={
		type:'line',
		
		data:{
			labels:[
					
					<?php echo $data2;?>
				],
			datasets:[{
				label:"Luminosité",
				data:[
					
					<?php echo $data2;?>
				],
				backgroundColor:'blue',
				
			}],

		},
		options:{
			

		}
	}
	let lumChart= new Chart(document.getElementById('lumChart').getContext('2d'),lumConfig) ; 


soundConfig={
		type:'line',
		labels:[
					
					<?php echo $data33;?>
				],
		data:{
			labels:[
					
					<?php echo $data2;?>
				],
			datasets:[{
				label:"Niveau sonore",
				data:[
					
					<?php echo $data33;?>
				],
				backgroundColor:'red',
				
			}],

		},
		options:{}
	}

	let soundChart= new Chart(document.getElementById('soundChart').getContext('2d'),soundConfig) ; 


	

</script>



<script>


function updateTempChart(newValue){
	let today = new Date();
	tempConfig.data.labels.push(today.getHours() 
	    			+ ":" + today.getMinutes()
	    			+" : "+today.getSeconds());

				tempConfig.data.datasets.forEach(function(dataset) {
						
						dataset.data.push(newValue);
					});

				if(tempUpdateCount>maxValues){
					temperatureChart.data.labels.shift();
					temperatureChart.data.datasets[0].data.shift();
				}
				else
					tempUpdateCount++;
				temperatureChart.update();
}

function updateLumChart(newValue){
	let today = new Date();
	lumConfig.data.labels.push(today.getHours() 
	    			+ ":" + today.getMinutes()
	    			+" : "+today.getSeconds());

				lumConfig.data.datasets.forEach(function(dataset) {
						
						dataset.data.push(newValue);
					});

				if(lumUpdateCount>maxValues){
					lumChart.data.labels.shift();
					lumChart.data.datasets[0].data.shift();
				}
				else
					lumUpdateCount++;
				lumChart.update();
}

function updateSoundChart(newValue){
	let today = new Date();
	soundConfig.data.labels.push(today.getHours() 
	    			+ ":" + today.getMinutes()
	    			+" : "+today.getSeconds());

				soundConfig.data.datasets.forEach(function(dataset) {
						
						dataset.data.push(newValue);
					});

				if(soundUpdateCount>maxValues){
					soundChart.data.labels.shift();
					soundChart.data.datasets[0].data.shift();
				}
				else
					soundUpdateCount++;
				soundChart.update();
}
	function loadDoc(link,id) {
		
		
		


	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var s = this.responseText;
	    	var result;
	    	if (s.indexOf('.')>0)
	    		result=s.split('.')[0]+"."+s.split('.')[1].substring(0,2);
	    	else 
	    		result=s;


		//Refresh charts
	    	if(id=="temp"){
	    		updateTempChart(result);
	    	}
	    	if(id=="lum"){
	    		updateLumChart(s);
	    	}
	    	if(id=="sound"){
	    		updateSoundChart(s);
	    	}


		document.getElementById(id).innerHTML = result;


	    }
	  };
	  xhttp.open("GET", link, true);
	  xhttp.send();
	}

	setInterval(function(){
	    loadDoc("http://127.0.0.1:3000/getTemp","temp")
	}, 800);


	setInterval(function(){
	    loadDoc("http://127.0.0.1:3000/getLum","lum")
	}, 2000);


	setInterval(function(){
	    loadDoc("http://127.0.0.1:3000/getSound","sound")
	}, 5000);
</script>