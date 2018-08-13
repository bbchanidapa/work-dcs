<?php
	include("db.inc.php");
	include("function.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dashboard - FITM NETWORK MONITORv1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="./css/bootstrap.css" rel="stylesheet">
	
	

    <style>
      body {
        padding-top: 60px; 
		position:relative;
		height:100%;
		background:url(./img/bg.jpg);
      }
	   canvas{
        width: 100% !important;
        max-width: 400px;
        height: auto !important;
    }

    </style>
    
	
	<link href="./css/project.css" rel="stylesheet">
	<script src="./js/jquery.js"></script>
	<script src="./js/Chart.js"></script>
	<script src="./js/bootstrap.js"></script>
	
  </head>

  <body>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">FITM Netmonv1</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Dashboard</a></li>
               <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Device
					<b class="caret"></b>
					</a>
					 <ul class="dropdown-menu">
						<li><a href="device.php?de_id=1">SW4503</a></li>
						<li><a href="device.php?de_id=2">R124</a></li>
						<li><a href="device.php?de_id=3">R101C</a></li>
						<li><a href="device.php?de_id=4">R330A</a></li>
						<li><a href="device.php?de_id=5">R401</a></li>
						<li><a href="device.php?de_id=6">R415</a></li>
						<li><a href="device.php?de_id=7">FITMFW5510</a></li>
					 </ul>
					
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Top 10 Ranking
					<b class="caret"></b>
					</a>
					 <ul class="dropdown-menu">
						<li><a href="topnet.php" >Network Ranking</a></li>
						<li><a href="servicerecv.php">Service Ranking</a></li>
						<li><a href="iprecv.php">IP Recieve Ranking</a></li>
						<li><a href="ipsend.php">IP Send Ranking</a></li>
					 </ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Network
					<b class="caret"></b>
					</a>
					 <ul class="dropdown-menu">
						<li><a href="overview.php">Wired Network</a></li>
						<li><a href="wifioverview.php">Wireless Network</a></li>
					 </ul>
				</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
	<div class="row-fluid">

	
	<div class="span3 shadow">
		<div class="row-fluid" style="height:500px;">
						<div class="bgbold project_header">
							<div class="icon_router">Device</div>
						</div>
						<div class="project_list_panel" style="overflow:auto;height:470px;">
						<?php
							$select_device_info_text = "select * from device";
							$result_device_info = mysql_query($select_device_info_text);
							if(!mysql_num_rows($result_device_info))
							{
								echo'<div class="media bgodd">
									<div class="media-body">
										<h4 class="media-heading">
											Device not found
										</h4>
									</div>
								</div>';
								echo "device id not found.";
								
							}
							else
							{
								$temp_check = 0;
								while($array_device_info = mysql_fetch_array($result_device_info))
								{
									if ($temp_check == 0)
									{
										echo '<div class="media bgodd">';
										$temp_check = 1;
									}
									else
									{
										echo '<div class="media bgeven">';
										$temp_check = 0;
									}
									
									if($array_device_info['de_retire'] == 0)
									{
										if($array_device_info['de_id'] == 7) $var_devimage = "fw_up.png";
										else $var_devimage = "sw_up.png";
									}
									else
									{
										if($array_device_info['de_id'] == 7) $var_devimage = "fw_down.png";
										else $var_devimage = "sw_down.png";
									}

									echo '<a class="pull-left" href="#"><img class="media-object" src="./img/dashboard/'. $var_devimage .'"></a>';
									echo '<div class="media-body">';
									echo '<h4 class="media-heading"><a href="device.php?de_id='.$array_device_info['de_id'].'">'.$array_device_info['de_hostname'].'</a></h4>';
									echo 'IP : ' . $array_device_info['de_ipaddr'] . '</div></div>';




								}



							}
						?>

						</div>
						<div class="bgbold btn_project_home" style="height:50px;"></div>
				</div>
		</div>
		<?php
			$de_id = 7;
			$select_device_info_text = "select * from device where de_id=".$de_id;
			$result_device_info = mysql_query($select_device_info_text);
			$array_device_info = mysql_fetch_array($result_device_info);


			$select_device_traffic_text = "select * from (select device_iftraffic.*,device_time.dt_etime from device_iftraffic  join device_time on device_iftraffic.dt_id = device_time.dt_id where device_iftraffic.de_id=" . $de_id ." and device_iftraffic.di_ifid=".$array_device_info['de_uplink_ifindex']." order by device_time.dt_id desc LIMIT 0,7) as test order by dt_id asc";
			
			
			$result_device_traffic_text = mysql_query($select_device_traffic_text);
			
			$array_count = 0;
			$cur_date = "";
			while($array_device_traffic = mysql_fetch_array($result_device_traffic_text))
			{
				$var_device_time = new DateTime(date("H:i:s", strtotime($array_device_traffic['dt_etime'])));
				$array_label[$array_count] = $var_device_time->format("H:i");
				$array_outocet[$array_count] = round(($array_device_traffic['df_avgout']/5)/60);
				$array_inocet[$array_count] = round(($array_device_traffic['df_avgin']/5)/60);
			
				$array_count = $array_count +1;
				$cur_date = $var_device_time->format("Y/m/d");
			}
			
			$lineunit =  UnitConvert($array_outocet,$array_inocet);
		?>
		<div class="span6">
			<div class="row-fluid" style="height:350px;">
							<div class="bgbold project_header">

								<div class="icon_novel">Internet Traffic (Firewall Uplink) <span style="float:right"> <?php echo  $cur_date; ?> </span></div>
							</div>
							<div class="project_list_panel" style="overflow:none;height:260px;">
								<div class="media bgeven" style="height:240px">
									
									
										<center>
											<canvas id="canvas" height="200"  width="400"></canvas>
										</center>
									
									<div class="span1"></div>
									<div class="span10">
										<span class="label label-important" style="width:55px">Outbound</span>&nbsp;&nbsp;Min : <?php echo min($array_outocet) ." ". $lineunit;?>&nbsp;&nbsp;Max : <?php echo max($array_outocet) ." ". $lineunit;?>&nbsp;&nbsp;Avg :  <?php echo number_format(array_sum($array_outocet)/count($array_outocet),2) ." ". $lineunit;?> 
										<br>
										<span class="label label-success" style="width:55px"><center>Inbound</center></span>&nbsp;&nbsp;Min : <?php echo min($array_outocet) ." ". $lineunit;?>&nbsp;&nbsp;Max : <?php echo max($array_inocet) ." ". $lineunit;?>&nbsp;&nbsp;Avg :  <?php echo number_format(array_sum($array_inocet)/count($array_inocet),2) ." ". $lineunit;?> 

									</div>
									<div class="span1"></div>
								</div>
							</div>
							
			</div>
			
			<div class="row-fluid" style="height:120px;">

							<div class="bgbold project_header">
								<div class="icon_log">Event Log</div>
							</div>
							<div class="project_list_panel" style="overflow:auto;height:120px;">
							<?php
								$select_device_event_text = "select * from device_event order by devt_id desc";
								$result_device_event= mysql_query($select_device_event_text);
								if(!mysql_num_rows($result_device_event))
								{
									echo '<div class="media bgeven">
											<div class="span3"></div>
											<div class="span9">No event</div>
										</div>';
								}
								else
								{
									$temp_check = 0;
									while($array_device_event = mysql_fetch_array($result_device_event))
									{
										if ($temp_check == 0)
										{
											echo '<div class="media bgodd">';
											$temp_check = 1;
										}
										else
										{
											echo '<div class="media bgeven">';
											$temp_check = 0;
										}
										echo '<div class="span3">' . $array_device_event['devt_dtime'] . '</div>';
										echo '<div class="span9">' . $array_device_event['devt_message'] . '</div>';
										echo '</div>';
									}
								}
							?>

							</div>
							<div class="bgbold btn_project_home" style="height:50px;"></div>
							
			</div>
		</div>
		<?php 
			$select_device_info_text = "select * from device";
			$result_device_info = mysql_query($select_device_info_text);

			$array_count = 0;
			while($array_device_info = mysql_fetch_array($result_device_info))
			{
				$de_id = $array_device_info['de_id'];
				if($de_id != 1 && $de_id != 7)
				{
					$select_device_traffic_text = "select * from (select device_iftraffic.*,device_time.dt_etime from device_iftraffic  join device_time on device_iftraffic.dt_id = device_time.dt_id where device_iftraffic.de_id=" . $de_id ." and device_iftraffic.di_ifid=".$array_device_info['de_uplink_ifindex']." order by device_time.dt_id desc LIMIT 0,1) as test order by dt_id asc";
					
					$result_device_traffic = mysql_query($select_device_traffic_text);
					$array_device_traffic = mysql_fetch_array($result_device_traffic);

					$array_label_pie[$array_count] = $array_device_info['de_hostname'];
					$array_traffic[$array_count] = round(($array_device_traffic['df_avgout']/5)/60) + round(($array_device_traffic['df_avgin']/5)/60);

					
					
					$array_count = $array_count + 1;
				}


			}
			$chartscale = UnitConvertOne($array_traffic);
			$array_traffic[0] = $array_traffic[0] - $array_traffic[1]; // FIX 124 to 101C Uplink
			
		?>
		
		<div class="span3">
			<div class="row-fluid" style="height:500px;">
							<div class="bgbold project_header">
								<div class="icon_novel">Traffic Ratio</div>
							</div>
							<div class="project_list_panel" style="overflow:none;height:470px;">
								<div class="media bgeven" style="height:470px;">
									<center><canvas id="canvas2" height="400" width="400"></canvas></center>
									<div class="span1"></div>
									<div class="span1">
										<span class="label" style="background-color:#F38630;height:10px;width:10px"> </span><br>
										<span class="label" style="background-color:#E0E4CC;height:10px;width:10px"> </span><br>
										<span class="label" style="background-color:#69D2E7;height:10px;width:10px"> </span><br>
										<span class="label" style="background-color:#FF0000;height:10px;width:10px"> </span><br>
										<span class="label" style="background-color:#FFFF00;height:10px;width:10px"> </span><br>
									</div>
									<div class="span1"></div>
									<div class="span7">
										<?php echo $array_label_pie[0]; ?> (<?php echo $array_traffic[0] . " " .$chartscale;?>)<br>
										<?php echo $array_label_pie[1]; ?> (<?php echo $array_traffic[1] . " " .$chartscale;?>)<br>
										<?php echo $array_label_pie[2]; ?> (<?php echo $array_traffic[2] . " " .$chartscale;?>)<br>
										<?php echo $array_label_pie[3]; ?> (<?php echo $array_traffic[3] . " " .$chartscale;?>)<br>
										<?php echo $array_label_pie[4]; ?> (<?php echo $array_traffic[4] . " " .$chartscale;?>)<br>
									</div>
									
									<div class="span1"></div>
									

								</div>
							</div>
							<div class="bgbold btn_project_home" style="height:50px;"></div>
							
			</div>
			
			<!--<div class="row-fluid" style="height:200px;">
							<div class="bgbold project_header">
								<div class="icon_novel">Event Log</div>
							</div>
							<div class="project_list_panel" style="overflow:auto;height:120px;">
								<div class="media bgeven" height="height:40px;">
									<div class="span3">2013-24-07 15:50</div>
									<div class="span8">Device 'SW4503' cpu usage is threshold 40%</div>
									<div class="span1"></div>
								</div>
								<div class="media bgodd" height="height:40px;">
									<div class="span3">2013-24-07 15:50</div>
									<div class="span8">Device 'R415' uplink traffic is threshold to 15 MB/s</div>
									<div class="span1"></div>
								</div>
								<div class="media bgodd" height="height:40px;">
									<div class="span3">2013-24-07 13:32</div>
									<div class="span8">Device 'R415' come back from down state.</div>
									<div class="span1"></div>
								</div>
								<div class="media bgeven" height="height:40px;">
									<div class="span3">2013-24-07 13:30</div>
									<div class="span8">Device 'R415' changed state to down.</div>
									<div class="span1"></div>
								</div>

							</div>
							<div class="bgbold btn_project_home" style="height:50px;"></div>
							
			</div>
		</div>-->


	</div>
	</div>

	<script>

		var lineChartData = {
			labels : <?php echo json_encode($array_label);?>,
			datasets : [
				{
					fillColor : "rgba(255,0,0,0.5)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					data :  <?php echo json_encode($array_outocet);?>
					
				},
				{
					fillColor : "rgba(0,255,0,0.5)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					data :  <?php echo json_encode($array_inocet);?>
				}
			]
			
		}
		var lineOption = {
			scaleShowLabels : true,
			scaleLabel : "<%=value%> <?php echo $lineunit;?>",
			scaleShowGridLines : true,
			scaleGridLineColor : "rgba(0,0,0,.20)",
			scaleGridLineWidth : 1,
			scaleFontColor : "#000",

			}
	var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData,lineOption);
	


	var cirdata = [
	{
		value: <?php echo $array_traffic[0];?>,
		color:"#F38630"
	},
	{
		value : <?php echo $array_traffic[1];?>,
		color : "#E0E4CC"
	},
	{
		value : <?php echo $array_traffic[2];?>,
		color : "#69D2E7"
	},
	{
		value : <?php echo $array_traffic[3];?>,
		color : "#FF0000"
	},	
	{
		value : <?php echo $array_traffic[4];?>,
		color : "#FFFF00"
	},	
	];

	var ciroptions = {
	//Boolean - Whether we should show a stroke on each segment
	segmentShowStroke : true,
	
	//String - The colour of each segment stroke
	segmentStrokeColor : "#fff",
	
	//Number - The width of each segment stroke
	segmentStrokeWidth : 2,
	
	//Boolean - Whether we should animate the chart	
	animation : true,
	
	//Number - Amount of animation steps
	animationSteps : 100,
	
	//String - Animation easing effect
	animationEasing : "easeOutBounce",
	
	//Boolean - Whether we animate the rotation of the Pie
	animateRotate : true,

	//Boolean - Whether we animate scaling the Pie from the centre
	animateScale : false,
	
	//Function - Will fire on animation completion.
	onAnimationComplete : null
}
	var myCir = new Chart(document.getElementById("canvas2").getContext("2d")).Pie(cirdata,ciroptions);
	</script>

  </body>
</html>
