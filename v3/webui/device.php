<?php
if(!isset($_GET['de_id']))
{
	echo "Please specify device id";
	exit();
}
include("db.inc.php");
include("function.inc.php");
$var_parameter_de_id = $_GET['de_id'];
$select_device_info_text = "select * from device where de_id=".$var_parameter_de_id."";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	echo "device id not found.";
	exit();
}

$array_device_info = mysql_fetch_array($result_device_info);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Network Device Info - FITM NETWORK MONITORv1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
	

    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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
              <li class=""><a href="index.php">Dashboard</a></li>
               <li class="dropdown active">
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
		<div class="row-fluid" style="height:150px">
			<div class="span2"></div>
			<div class="span4">
				<center style="margin-top:20px">
					<img alt="140x140" src="./img/device/sw.png" width="320" height="61"/>
				</center>
			</div>
			<div class="span6" style="color: #ccc;">
				Hostname : <?php echo $array_device_info['de_hostname']; ?><br>
				Model : <?php echo $array_device_info['de_model']; ?><br>
				IOS Version : <?php echo $array_device_info['de_version']; ?><br>
				Description : <?php echo $array_device_info['de_description']; ?><br>
				IP Address : <?php echo $array_device_info['de_ipaddr']; ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span2"></div>
			<div class="span4 shadow">
				<div class="bgbold project_header">
					<div class="icon_novel">Device Interface</div>
				</div>
				<div class="project_list_panel" style="overflow:auto;height:370px;">
				<?php 
					$select_device_interface_join_device_iftraffic_text ="select device_interface.di_ifid,device_interface.di_ifname,device_interface.di_ifstatus,device_iftraffic.df_avgin,device_iftraffic.df_avgout from 
					(select * from device_interface where de_id=".$var_parameter_de_id.") as device_interface join
					(select * from device_iftraffic where de_id=".$var_parameter_de_id." and dt_id=
					(select dt_id from device_time order by dt_id desc LIMIT 0,1)) as device_iftraffic on 
					device_interface.di_ifid = device_iftraffic.di_ifid";
					
					$result_device_interface_join_device_iftraffic = mysql_query($select_device_interface_join_device_iftraffic_text);
					if(!mysql_num_rows($result_device_interface_join_device_iftraffic))
					{
						echo '
								<div class="media bgodd">
									<a class="pull-left" href="#"><img class="media-object" src="./img/lan_port_green.png"></a>
									<div class="media-body">
										<h4 class="media-heading"><a href="#">Interface data</a></h4>
										Not available.
									</div>
								</div>
								';
					}
					else
					{
						$temp_check = 0;
						while($array_device_interface_join = mysql_fetch_array($result_device_interface_join_device_iftraffic))
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

							if($array_device_interface_join['di_ifstatus'] == 1) $var_lanimage = "lan_port_green.png";
							else $var_lanimage = "lan_port_red.png";

							echo '<a class="pull-left" href="#"><img class="media-object" src="./img/device/'. $var_lanimage .'"></a>';
							echo '<div class="media-body">';
							echo '<h4 class="media-heading"><a href="deviceif.php?de_id='.$var_parameter_de_id.'&ifid='.$array_device_interface_join['di_ifid'].'">'.$array_device_interface_join['di_ifname'].'</a></h4>';

							$avg_in_per_sec = round(($array_device_interface_join['df_avgin']/5)/60);
							$avg_out_per_sec = round(($array_device_interface_join['df_avgout']/5)/60);

							$tmpUnit = UnitConvertVar($avg_in_per_sec);
							echo "Inbound : " . $avg_in_per_sec . " " . $tmpUnit . "<br>";

							$tmpUnit = UnitConvertVar($avg_out_per_sec);
							echo "Outbound : " . $avg_out_per_sec . " " . $tmpUnit . "<br>";

							echo "</div></div>";
						}
					}
				?>
				</div>
				<div class="bgbold btn_project_home" style="height:50px;"></div>
			</div>
			<div class="span6">
				<div class="row-fluid">
						<?php
							$select_device_usage_text = "select * from device_usage where de_id=" . $var_parameter_de_id . " order by du_id desc LIMIT 0,1";
							$result_device_usage = mysql_query($select_device_usage_text);
							if(!mysql_num_rows($result_device_usage))
							{
								$var_cpu = 0;
								$var_mem = 0;
								$var_temp = "Unknow";
								$var_uptime = "Unknow";
								$final_mem = 0;
								$var_ping = 0;
							}
							else
							{
								$array_device_usage = mysql_fetch_array($result_device_usage);
								$var_cpu = $array_device_usage['du_cpu'];
								$var_mem = $array_device_usage['du_memory'];
								$var_temp = $array_device_usage['du_temp'];
								$var_uptime = $array_device_usage['du_uptime'];

								$final_mem = round(($var_mem * 100) / $array_device_info['de_memory']);
								$var_ping = $array_device_usage['du_ping'];
							}
						?>
						<div class="span1">
							<img alt="140x140" src="./img/device/cpu_icon.png" width="48" height="48"/>
						</div>
						<div class="span4" style="color: #ccc;height:50px">
							<small>CPU Load Average ( <?php echo $var_cpu; ?>% )</small>
							<div class="progress" style="height:10px;width:200px">
								<div class="bar bar-danger" style="width: <?php echo $var_cpu; ?>%;"></div>
								<div class="bar bar-success" style="width: <?php echo (100-$var_cpu); ?>%;"></div>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span1">
							<img alt="140x140" src="./img/device/ram_icon.png" width="48" height="48"/>
						</div>
						<div class="span4" style="color: #ccc;height:50px">
							<small>Memory Usage ( <?php echo $final_mem; ?>% )</small>
							<div class="progress" style="height:10px;width:200px">
								<div class="bar bar-danger" style="width: <?php echo $final_mem; ?>%;"></div>
								<div class="bar bar-success" style="width: <?php echo (100-$final_mem); ?>%;"></div>
							</div>	
						</div>
					</div>
					<?php if($var_parameter_de_id != 7) { ?>
					<div class="row-fluid">
						<div class="span1">
							<img alt="140x140" src="./img/device/temp_icon.png" width="48" height="48"/>
						</div>
						<div class="span4" style="color: #ccc;height:50px">
								<small>Temperature <br> <?php echo $var_temp; ?> Degree</small>
						</div>
					</div>
					<?php } ?>
					<div class="row-fluid">
						<div class="span1">
							<img alt="140x140" src="./img/device/clock_icon.png" width="48" height="48"/>
						</div>
						<div class="span4" style="color: #ccc;height:50px">
							<small>Uptime <br> <?php echo $var_uptime; ?></small>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span1">
							<img alt="140x140" src="./img/device/ping_icon.png" width="48" height="48"/>
						</div>
						<div class="span4" style="color: #ccc;height:50px">
							<small>Ping <br> <?php echo $var_ping; ?> ms</small>
						</div>
					</div>
					<?php
						$select_device_interface_text = "select * from device_interface where de_id=" . $var_parameter_de_id ." and di_ifid=".$array_device_info['de_uplink_ifindex']."";

						$result_device_interface = mysql_query($select_device_interface_text);
						if(!mysql_num_rows($result_device_interface))
						{
							echo ' <div class="row-fluid">
										<div class="span12" style="color: #ccc;">
											Uplink Traffic ( Uplink port not specify )
											<br>
										</div>
									</div>';
						}
						else
						{
							$array_device_interface = mysql_fetch_array($result_device_interface);
							$select_device_traffic_text = "select * from (select * from device_iftraffic where de_id=" . $var_parameter_de_id ." and di_ifid=".$array_device_info['de_uplink_ifindex']." order by dt_id desc LIMIT 0,7) as test order by dt_id asc";

							$result_device_traffic = mysql_query($select_device_traffic_text);

							if(mysql_num_rows($result_device_traffic) < 2 )
							{
								echo '
								<div class="row-fluid">
									<div class="span12" style="color: #ccc;">
										Uplink Traffic ( '.$array_device_interface['di_ifname'].' ) 
										<br><br>
										 Data Traffic is not available
										<br>
									</div>
								</div>';
							}
							else
							{
								echo '
									<div class="row-fluid">
										<div class="span12" style="color: #ccc;">
											Uplink Traffic ( '.$array_device_interface['di_ifname'].' ) 
											<span class="label label-important">Outbound</span> 
											<span class="label label-success">Inbound</span><br><br>
											<canvas id="canvas" height="200" width="400"></canvas>
											<br>
										</div>
									</div>';

									$array_count = 0;
									while($array_device_traffic = mysql_fetch_array($result_device_traffic))
									{
										$select_device_time_text = "select * from device_time where dt_id=".$array_device_traffic['dt_id']."";
										$result_device_time = mysql_query($select_device_time_text);
										$array_device_time = mysql_fetch_array($result_device_time);

										$var_device_time = new DateTime(date("H:i:s", strtotime($array_device_time['dt_etime'])));
										$array_label[$array_count] = $var_device_time->format("H:i");
										$array_outocet[$array_count] = round(($array_device_traffic['df_avgout']/5)/60);
										$array_inocet[$array_count] = round(($array_device_traffic['df_avgin']/5)/60);
									
										$array_count = $array_count +1;

									}
									$lineunit =  UnitConvert($array_outocet,$array_inocet);
							}
						}




						
					?>
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
							scaleGridLineColor : "rgba(255,255,255,.20)",
							scaleGridLineWidth : 1,
							scaleFontColor : "#ccc",

							}
					var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData,lineOption);
	
					
				</script>
			</div>
		</div>
	</div>
	<br><br>
</body>
</html>

	
