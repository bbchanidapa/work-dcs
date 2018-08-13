<?php

include("db.inc.php");
include("function.inc.php");
include("ip2net.inc.php");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://10.4.15.101/fitmmon/v3/webui/asdm_curl.php');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

curl_close($ch);


if($result == "")
{
	echo "ASDM_CONNECTION_FAILED";
	exit();
}
$array_string = explode('<top-hosts type="receive-byte" rate_interval="3600">',$result);
$array_string2 = explode('</top-hosts>',$array_string[1]);

$xml   = simplexml_load_string("<top10>" . $array_string2[0] . "</top10>");
$json = json_encode($xml);
$array = json_decode($json,TRUE);


for($i = 0;$i<count($array['host']);$i++)
{

	$array_ip[$i] = $array['host'][$i]['ip-addr'];
	$array_totalocet[$i] = $array['host'][$i]['total'];
	$array_currentocet[$i] = ($array['host'][$i]['current']/60);

	$temp = curl_init();
	curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/unifi/user?ip='.$array_ip[$i]);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($temp);
	curl_close($temp);

	$temp_array = (array)json_decode($result);

	if($temp_array['code'] == "200")
	{
		
		
			$temp_data_x = (array)$temp_array['data'];
			$temp_data = (array)$temp_data_x[0];
			$array_mode[$i] = 2;
			if (array_key_exists('email', $temp_data)) $array_email[$i] = $temp_data['email'];
			else $array_email[$i] = "";
			if (array_key_exists('hostname', $temp_data)) $array_hostname[$i] = $temp_data['hostname'];
			else $array_hostname[$i] = "";
			if (array_key_exists('mac', $temp_data)) $array_mac[$i] = $temp_data['mac'];
			else $array_mac[$i] = "";

			$array_comid[$i] = "";
			$array_room[$i] = "";
		
	}
	else if($temp_array['code'] == "404")
	{
		$temp = curl_init();
		curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/dbapi.php?Number='.$array_ip[$i]);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($temp);
		curl_close($temp);
		
		
		$temp_array = (array)json_decode(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$result));
		//print_r($temp_array);
		if(array_key_exists("code",$temp_array))
		{
			if($temp_array['code'] == "200")
			{
				$temp_data = (array)$temp_array['data'];
				$array_mode[$i] = 1;
				$array_email[$i] = "";
				if (array_key_exists('hostname', $temp_data)) $array_hostname[$i] = $temp_data['hostname'];
				else $array_hostname[$i] = "";
				if (array_key_exists('mac_address', $temp_data)) $array_mac[$i] = str_replace("-",":",$temp_data['mac_address']);
				else $array_mac[$i] = "";
				if (array_key_exists('computer_id', $temp_data)) $array_comid[$i] = $temp_data['computer_id'];
				else $array_comid[$i] = "";
				if (array_key_exists('room', $temp_data)) $array_room[$i] = $temp_data['room'];
				else $array_room[$i] = "";

			}
			else
			{
				$array_mode[$i] = 0;
				$array_email[$i] = "";
				$array_hostname[$i] = "";
				$array_mac[$i] = "";
				$array_comid[$i] = "";
				$array_room[$i] = "";
			}
		}
		else
		{
				$array_mode[$i] = 0;
				$array_email[$i] = "";
				$array_hostname[$i] = "";
				$array_mac[$i] = "";
				$array_comid[$i] = "";
				$array_room[$i] = "";
		}
	}
	
}

$var_scale_text = UnitConvertOneNoSec($array_totalocet);
$var_scale_text2 = UnitConvertOne($array_currentocet);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Top 10 IP Destination (Recieve) Traffic</title>
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
        max-width: 1000px;
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
				<li class="dropdown active">
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
			<div class="span1"></div>
			<div class="span10 shadow">
				<div class="bgbold project_header">
					<div class="icon_novel">Top 10 IP Destination Total Usage ( Last 1 Hour )</div>
				</div>
				<div class="project_list_panel" style="overflow:none;height:900px;">
					<div class="media " style="height:900px;" >
						
						<div class="span12">
						<br>
						<center>
							
							<br><br>
							<canvas id="canvas" height="300" width="1000"></canvas>
							<br><br><br>
							<div class="span1"></div>
							<div class="span10">
								<table border=1 class="table table-bordered">
									<caption><h3>Top 10 IP Destination Total Usage ( Last 1 Hour )</h3></caption>
									<thead>
										<tr>
											<th style="width:5%;text-align:center;">#</th>
											<th style="width:35%px;text-align:center;">Username or Room / Hostname</th>
											<th style="width:20%px;text-align:center;">IP Address</th>
											<th style="width:20%px;text-align:center;">Total Usage</th>
											<th style="width:20%px;text-align:center;">Current Usage</th>
										</tr>
									</thead>
									<tbody>
									<?php
										/*$array_netid[$array_slot] = ip2net($array_many_join['di_ipaddr'],$array_many_join['di_subnet']);
										$array_vlanid[$array_slot] = $array_many_join['dv_vlanid'];
										$array_vlanname[$array_slot] = $array_many_join['dv_vlanname'];
										$array_in_ocet[$array_slot] = round(($array_many_join['df_avgin']/5)/60);
										$array_out_ocet[$array_slot] = round(($array_many_join['df_avgout']/5)/60);
										$array_label[$array_slot] = $array_many_join['dv_vlanname'] ;*/
										for($i=0;$i<count($array_totalocet);$i++)
										{
											echo '<tr>';
											echo '<td style="text-align:right;">'.($i+1).'</td>';
											if($array_mode[$i] == 0)
											{
												echo '<td style="text-align:center;">Not found</td>';
											}
											else if ($array_mode[$i] == 1)
											{
												echo '<td style="text-align:center;">'.$array_room[$i].'/'.$array_hostname[$i].'</td>';
											}
											else if ($array_mode[$i] == 2)
											{
												echo '<td style="text-align:center;">'.$array_email[$i].'/'.$array_hostname[$i].'</td>';
											}
											//echo '<td style="text-align:center;">'.$array_vlanid[$i].'</td>';
											echo '<td style="text-align:center;">'.$array_ip[$i].'</td>';
											echo '<td style="text-align:right;">'.$array_totalocet[$i].' '.$var_scale_text.'</td>';
											echo '<td style="text-align:right;">'.$array_currentocet[$i].' '.$var_scale_text2.'</td>';
											echo '</tr>';
										}
									?>
									</tbody>
								</table>
							</div>
							<div class="span1"></div>
						</center>



						</div>
					</div>

					
					
					</div>
					<div class="bgbold btn_project_home" style="height:50px;"></div>
					<br><br><br>
				</div>
			</div>
		</div>
	</div>

	<script>
		var data = {
					labels : <?php echo json_encode($array_ip); ?>,
					datasets : [
						{
							fillColor : "rgba(255,0,0,0.5)",
							strokeColor : "rgba(255,0,0,1)",
							data : <?php echo json_encode($array_totalocet); ?>
						}
					]
				};
		
			var barOption = {
				scaleShowLabels : true,
				scaleLabel : "<%=value%> <?php echo $var_scale_text;?>",
				scaleShowGridLines : true,
				scaleGridLineColor : "rgba(0,0,0,.20)",
				scaleGridLineWidth : 1,
				scaleFontColor : "#000",
				};

		var myBar = new Chart(document.getElementById("canvas").getContext("2d")).Bar(data,barOption);
		
	
	</script>
</body>
</html>

							












			
		


