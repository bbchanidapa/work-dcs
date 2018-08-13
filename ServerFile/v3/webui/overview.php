<?php

include("db.inc.php");
include("function.inc.php");

$downlist = "";
$status = 0;

$select_device_info_text = "select * from device";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	for($i=0;$i<6;$i++)
	{
		$line[$i] = 0;
	}
}
else
{
	for($i=0;$i<6;$i++)
	{
		$line[$i] = 1;
	}
	$var_counter = 0;
	while($array_device_info = mysql_fetch_array($result_device_info))
	{
		if($array_device_info['de_retire'] != 0)
		{
			$downlist = $downlist . $array_device_info['de_hostname'] . " ";
			$status = 1;
		}

		if($array_device_info['de_id'] == 1 && $array_device_info['de_retire'] != 0)
		{
			$line[0] = 0;
			$line[1] = 0;
			$line[2] = 0;
			$line[3] = 0;
			$line[4] = 0;
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 2 && $array_device_info['de_retire'] != 0)
		{
			$line[1] = 0;
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 3 && $array_device_info['de_retire'] != 0)
		{
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 4 && $array_device_info['de_retire'] != 0)
		{
			$line[2] = 0;
		}
		else if($array_device_info['de_id'] == 5 && $array_device_info['de_retire'] != 0)
		{
			$line[3] = 0;
		}
		else if($array_device_info['de_id'] == 6 && $array_device_info['de_retire'] != 0)
		{
			$line[4] = 0;
		}
		else if($array_device_info['de_id'] == 7 && $array_device_info['de_retire'] != 0)
		{
			$line[0] = 0;
		}

		$select_device_traffic_text = "select * from (select * from device_iftraffic where de_id=" . $array_device_info['de_id'] ." and di_ifid=".$array_device_info['de_uplink_ifindex']." order by dt_id desc LIMIT 0,1) as test order by dt_id asc";

		$result_device_traffic = mysql_query($select_device_traffic_text);
		$array_device_traffic = mysql_fetch_array($result_device_traffic);
		$array_in_ocet[$var_counter] = round(($array_device_traffic['df_avgin']/5)/60);
		$array_out_ocet[$var_counter] = round(($array_device_traffic['df_avgout']/5)/60);
		$var_counter = $var_counter + 1;
	}


	$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Overview - FITM NETWORK MONITOR</title>
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
	.bar {
		
		background-color:rgba(0,0,0,.1);
		-webkit-border-radius:25px;
		-moz-border-radius:25px;
		-ms-border-radius:25px;
		border-radius:20px;
		-webkit-box-shadow:0 1px 0 rgba(255,255,255,.03),inset 0 1px 0 rgba(0,0,0,.1);
		-moz-box-shadow:0 1px 0 rgba(255,255,255,.03),inset 0 1px 0 rgba(0,0,0,.1);
		-ms-box-shadow:0 1px 0 rgba(255,255,255,.03),inset 0 1px 0 rgba(0,0,0,.1);
		box-shadow:0 1px 0 rgba(255,255,255,.03),inset 0 1px 0 rgba(0,0,0,.1);
	}
	
	.bar.vertical {
		margin: auto;
		height:60px;
		width:10px;
		padding:3px;
	}
	.bar.horizontal {
		margin:auto;
		height:20px;
		
		padding:10px;
	}
	.information{
		margin: auto;
		height:60px;
		width:58px;
		padding:3px;
		display:inline-block;
	}
	.information span {
		float:left;
		margin-top:70%;
		height:100%;
		
		width:100%;
		box-sizing:border-box;
		overflow: hidden;
	}
	/* 
	This is the actual bar with stripes
	*/	
	.bar span {
		display:inline-block;
		height:100%;
		width:100%;
		-webkit-border-radius:20px;
		-moz-border-radius:20px;
		-ms-border-radius:20px;
		border-radius:20px;
		-webkit-box-sizing:border-box;
		-moz-box-sizing:border-box;
		-ms-box-sizing:border-box;
		box-sizing:border-box;
		overflow: hidden;
		-webkit-box-shadow:inset 0 10px 0 rgba(255,255,255,.2);
		-moz-box-shadow:inset 0 10px 0 rgba(255,255,255,.2);
		-ms-box-shadow:inset 0 10px 0 rgba(255,255,255,.2);
		box-shadow:inset 0 10px 0 rgba(255,255,255,.2);
	}
	.bar span.move-down {
		-webkit-animation:move 2s linear infinite;
		-moz-animation:move 2s linear infinite;
		-ms-animation:move 2s linear infinite;
		animation:move 2s linear infinite;
	}
	.bar span.move-up {
		
		-webkit-animation:move-up 2s linear infinite;
		-moz-animation:move-up 2s linear infinite;
		-ms-animation:move-up 2s linear infinite;
		animation:move-up 2s linear infinite;
		
	}
	.bar span.warning{
		border:1px solid #ff9a1a;
		border-bottom-color:#ff6201;
		background-color:#d3d3d3;
		background-image:
			-webkit-linear-gradient(
			-45deg,
			rgba(255, 154, 26, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(255, 154, 26, 1) 50%,
			rgba(255, 154, 26, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-moz-linear-gradient(
			-45deg,
			rgba(255, 154, 26, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(255, 154, 26, 1) 50%,
			rgba(255, 154, 26, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-ms-linear-gradient(
			-45deg,
			rgba(255, 154, 26, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(255, 154, 26, 1) 50%,
			rgba(255, 154, 26, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			linear-gradient(
			-45deg,
			rgba(255, 154, 26, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(255, 154, 26, 1) 50%,
			rgba(255, 154, 26, 1) 75%,
			transparent 75%,
			transparent
		);
		-webkit-background-size:50px 50px;
		-moz-background-size:50px 50px;
		-ms-background-size:50px 50px;
		background-size:50px 50px;
	}
	.bar span.success{
		border:1px solid rgba(0, 182, 44, 1);
		border-bottom-color:rgba(0, 128, 31, 1);
		background-color:#d3d3d3;
		background-image:
			-webkit-linear-gradient(
			-45deg,
			rgba(0, 182, 44, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(0, 182, 44, 1) 50%,
			rgba(0, 182, 44, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-moz-linear-gradient(
			-45deg,
			rgba(0, 182, 44, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(0, 182, 44, 1) 50%,
			rgba(0, 182, 44, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-ms-linear-gradient(
			-45deg,
			rgba(0, 182, 44, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(0, 182, 44, 1) 50%,
			rgba(0, 182, 44, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			linear-gradient(
			-45deg,
			rgba(0, 182, 44, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(0, 182, 44, 1) 50%,
			rgba(0, 182, 44, 1) 75%,
			transparent 75%,
			transparent
		);
		-webkit-background-size:50px 50px;
		-moz-background-size:50px 50px;
		-ms-background-size:50px 50px;
		background-size:50px 50px;
	}
	
	.bar span.error{
		border:1px solid rgba(236, 51, 51, 1);
		border-bottom-color:rgba(207, 25, 25, 1);
		background-color:#d3d3d3;
		background-image:
			-webkit-linear-gradient(
			-45deg,
			rgba(236, 51, 51, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(236, 51, 51, 1) 50%,
			rgba(236, 51, 51, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-moz-linear-gradient(
			-45deg,
			rgba(236, 51, 51, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(236, 51, 51, 1) 50%,
			rgba(236, 51, 51, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-ms-linear-gradient(
			-45deg,
			rgba(236, 51, 51, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(236, 51, 51, 1) 50%,
			rgba(236, 51, 51, 1) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			linear-gradient(
			-45deg,
			rgba(236, 51, 51, 1) 25%,
			transparent 25%,
			transparent 50%,
			rgba(236, 51, 51, 1) 50%,
			rgba(236, 51, 51, 1) 75%,
			transparent 75%,
			transparent
		);
		-webkit-background-size:50px 50px;
		-moz-background-size:50px 50px;
		-ms-background-size:50px 50px;
		background-size:50px 50px;
	}
	
	.bar span.info{
		border:1px solid rgb(26, 163, 255);
		border-bottom-color:rgb(26, 145, 255);
		background-color:#d3d3d3;
		background-image:
			-webkit-linear-gradient(
			-45deg,
			rgb(26, 163, 255) 25%,
			transparent 25%,
			transparent 50%,
			rgb(26, 163, 255) 50%,
			rgb(26, 163, 255) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-moz-linear-gradient(
			-45deg,
			rgb(26, 163, 255) 25%,
			transparent 25%,
			transparent 50%,
			rgb(26, 163, 255) 50%,
			rgb(26, 163, 255) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			-ms-linear-gradient(
			-45deg,
			rgb(26, 163, 255) 25%,
			transparent 25%,
			transparent 50%,
			rgb(26, 163, 255) 50%,
			rgb(26, 163, 255) 75%,
			transparent 75%,
			transparent
		);
		background-image:
			linear-gradient(
			-45deg,
			rgb(26, 163, 255) 25%,
			transparent 25%,
			transparent 50%,
			rgb(26, 163, 255) 50%,
			rgb(26, 163, 255) 75%,
			transparent 75%,
			transparent
		);
		-webkit-background-size:50px 50px;
		-moz-background-size:50px 50px;
		-ms-background-size:50px 50px;
		background-size:50px 50px;
	}
	/*
	Animate the stripes
	*/	
	@-webkit-keyframes move{
	  0% {
		background-position: 0 0;
	  }
	  100% {
		background-position: 50px 50px;
	  }
	}	
	@-moz-keyframes move{
	  0% {
		background-position: 0 0;
	  }
	  100% {
		background-position: 50px 50px;
	  }
	}	
	@-ms-keyframes move{
	  0% {
		background-position: 0 0;
	  }
	  100% {
		background-position: 50px 50px;
	  }
	}	
	@keyframes move{
	  0% {
		background-position: 0 0;
	  }
	  100% {
		background-position: 50px 50px;
	  }
	}	
	
	/*           Move Up            */
	@-webkit-keyframes move-up{
	  100% {
		background-position: 0 0;
	  }
	  0% {
		background-position: 50px 50px;
	  }
	}	
	@-moz-keyframes move-up{
	  100% {
		background-position: 0 0;
	  }
	  0% {
		background-position: 50px 50px;
	  }
	}	
	@-ms-keyframes move-up{
	  100% {
		background-position: 0 0;
	  }
	  0% {
		background-position: 50px 50px;
	  }
	}	
	@keyframes move-up{
	  100% {
		background-position: 0 0;
	  }
	  0% {
		background-position: 50px 50px;
	  }
	}	
	.distribute{
		position:relative;
	}
	.distribute img{
		margin-top:-10px;z-index: 5000;
	}
	.distribute p{
		position:relative;
		top:-50px;
		color:white;
		margin:0px;
		padding:0px;
	}
	.row{
		margin:px!important;
	}
	
	#core{ 
		position:relative;
		top:-8px;
		height:100px;
		margin-top:-1px;
		position:relative;
		z-index: 5000;
		background-color:rgb(170,170,170);
		border:solid rgb(100,100,100);
		border-width:1px 0px;
		background: rgb(242,246,248); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(242,246,248,1) 0%, rgba(216,225,231,1) 50%, rgba(181,198,208,1) 51%, rgba(224,239,249,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(242,246,248,1)), color-stop(50%,rgba(216,225,231,1)), color-stop(51%,rgba(181,198,208,1)), color-stop(100%,rgba(224,239,249,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom,  rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f6f8', endColorstr='#e0eff9',GradientType=0 ); /* IE6-9 */

		
	}
	#distribute{ position:relative;top:-23px;}
	#distribute2{ position:relative;top:-73px;}
	#download{ position:absolute; top:0px;left:10px;}
	#upload{ position:absolute; top:30px;left:10px;}
	#inform{ position:absolute; top:60px;left:10px;}
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
				<li class="dropdown active">
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
	
   
		<div class="row-fluid">
			<div class="span10 offset1 shadow">
				<div class="bgbold project_header">
					<div class="icon_novel">Network Overview</div>
				</div>
				<div class="" style="overflow:none;height:540px;background-color:#FFF;padding:20px 0px;">
					<div class="row-fluid" style="position:relative;" >
						<div id="download" class="text-error">
							Inbound - Red
						</div>
						<div id="upload" class="text-success">
							Outbound - Green
						</div>
						<div id="inform" class="text-info">
							Unit - <?php echo $var_scale_text; ?>
						</div>
						<div class="row-fluid" id="firewall" >
							<div class="span12 text-center">
								<h4 class="text-error">FITMFW5510<br>10.9.99.1</h4>
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[6];?></span>
								</div>
								
									<img src="img/overview/fw.png" style="position:relative;z-index: 5001;width:120px;height:auto;margin-bottom:-15px"></img>
								
								<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[6];?></span>
								</div>
								<br>
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[0];?></span>
								</div>
								<?php 
									if($line[0] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
									<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[0];?></span>
								</div>	
							</div>
						</div>
						<div class="row-fluid" id="core">
							<div style="margin:15px;">
								<div class="span8" >
									<img src="img/overview/icon_log.png" style="width:50px;float:left;margin:15px;" ></img>
									<div>
										<?php
											if($status == 0)
											{
												echo '<h4>Network healtly is good.</h4>
												<p>No event Message</p>';
											}
											else
											{
												echo '<h4>Network has problem!</h4>
												<p>'. $downlist . ' is down.</p>';
											}
										?>
									</div>
								</div>
								<div class="span4">
									<h4 class="text-info">SW4503<br><br>10.77.1.1</h4>
								</div>
							</div>
							<img src="img/overview/router.png" style="width:130px;margin-top:20px;margin-left:-65px;;height:auto;position:absolute;left:50%;top:0;" ></img>
						</div>
						<div class="row" id="distribute">
							
							<div class="span3 text-center distribute">
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[1];?></span>
								</div>
								<?php 
									if($line[1] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
									<div class="information" style="display:inline-block;">
										<span class="text-center text-success" ><?php echo $array_out_ocet[1];?></span>
									</div>
								<br>
								<img src="img/overview/router.png" style="position:relative;z-index: 5001;width:130px;height:auto;" ></img>
								<p style="padding-top:3px"><font size="1">R124 (10.77.1.2)</font></p>
							</div>	
							<div class="span3 text-center distribute">
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[3];?></span>
								</div>
								<?php 
									if($line[2] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
									<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[3];?></span>
									</div>
								<br>
								<img src="img/overview/router.png" style="width:130px;height:auto;" ></img>
								<p style="padding-top:3px"><font size="1">R330A (10.77.3.2)</font></p>
							</div>
							<div class="span3 text-center distribute">
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[4];?></span>
								</div>
								<?php 
									if($line[3] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
									<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[4];?></span>
									</div>
								<br>
								<img src="img/overview/router.png" style="width:130px;height:auto;" ></img>
								<p style="padding-top:3px"><font size="1">R401 (10.77.4.2)</font></p>
							</div>
							<div class="span3 text-center distribute">
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[5];?></span>
								</div>
								<?php 
									if($line[4] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
									<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[5];?></span>
									</div>
								<br>
								<img src="img/overview/router.png" style="width:130px;height:auto;" ></img>
								<p style="padding-top:3px"><font size="1">R415 (10.77.5.2)</font></p>
							</div>
						</div>
						<div class="row" id="distribute2">
							<div class="span3  text-center distribute">
								<div class="information" style="display:inline-block;">
									<span class="text-center text-error" ><?php echo $array_in_ocet[2];?></span>
								</div>
								<?php 
									if($line[5] == 1)
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-down text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="success move-up text-center " ></span>
										</div>';
									}
									else
									{
										echo '
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center" ></span>
										</div>
										<div class="bar vertical" style="display:inline-block;">
											<span class="error text-center " ></span>
										</div>';
									}
									?>
								<div class="information" style="display:inline-block;">
									<span class="text-center text-success" ><?php echo $array_out_ocet[2];?></span>
								</div>
								<br>
								<img src="img/overview/router.png" style="width:130px;height:auto;" ></img>
								<p style="padding-top:3px"><font size="1">R101C (10.77.6.2)</font></p>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	
		
	
  </body>
</html>
