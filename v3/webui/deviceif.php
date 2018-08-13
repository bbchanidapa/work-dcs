<?php
if(!isset($_GET['de_id']) || !isset($_GET['ifid']))
{
	echo "Please specify device id or interface id";
	exit();
}
include("db.inc.php");
include("function.inc.php");


$n_month[1] = "Jab";
$n_month[2] = "Feb";
$n_month[3] = "Mar";
$n_month[4] = "Apr";
$n_month[5] = "May";
$n_month[6] = "Jun";
$n_month[7] = "Jul";
$n_month[8] = "Aug";
$n_month[9] = "Sep";
$n_month[10] = "Oct";
$n_month[11] = "Nov";
$n_month[12] = "Dec";





$var_parameter_de_id = $_GET['de_id'];
$var_parameter_ifid = $_GET['ifid'];

$select_device_info_text = "select * from device where de_id=".$var_parameter_de_id."";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	echo "device id not found.";
	exit();
}

$dev_array = mysql_fetch_array($result_device_info);

$select_device_interface_text = "select * from device_interface where de_id=".$var_parameter_de_id." and di_ifid=".$var_parameter_ifid."";
$result_device_interface = mysql_query($select_device_interface_text);
if(!mysql_num_rows($result_device_interface))
{
	echo "interface id not found.";
	exit();
}

$if_array = mysql_fetch_array($result_device_interface);

if($if_array['di_ifstatus'] == 1)
{
	$var_lanimage = "lan_port_green.png";
	$var_lantext = "Up";
}
else
{
	$var_lanimage = "lan_port_red.png";
	$var_lantext = "Down";
}

if($if_array['di_vlanid'] == 0)
{
	$var_vlanmode = "Interface Mode";
}
else
{
	$var_vlanmode = "Access Mode";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Device List</title>
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
        max-width: 800px;
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
		<div class="row-fluid">
			<div class="span2"></div>
			<div class="span4">
				<center>
					<img alt="96x96" src="./img/devif/<?php echo $var_lanimage;?>" width="100" height="100"/>
				</center>
			</div>
			<div class="span6" style="color: #ccc;">
				Device Name : <?php echo $dev_array['de_hostname'];?><br>
				Interface : <?php echo $if_array['di_ifname'];?><br>
				Port Status : <?php echo $var_lantext;?><br>
				Switch Port : <?php echo $var_vlanmode;?><br>
				<?php 
					if($if_array['di_ipaddr'] != "") echo 'Interface IP : ' . $if_array['di_ipaddr'] .'<br>';
					if($if_array['di_vlanid'] != 0) echo 'Vlan Number : ' . $if_array['di_vlanid'] .'<br>';
				?>
			</div>
		</div>
		<?php 
			$select_device_time_text = "select * from device_time LIMIT 0,1";
			$result_device_time = mysql_query($select_device_time_text);
			if(!mysql_num_rows($result_device_time))
			{
				echo "No Traffic Information";
				exit();
			}

			$array_device_time = mysql_fetch_array($result_device_time);
			$var_start_datetime = new DateTime($array_device_time['dt_stime']);

			$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
			$result_device_time = mysql_query($select_device_time_text);
			if(!mysql_num_rows($result_device_time))
			{
				echo "No Traffic Information";
				exit();
			}
			$array_device_time = mysql_fetch_array($result_device_time);
			$var_end_datetime = new DateTime($array_device_time['dt_etime']);
			

			if(!isset($_GET['sy']) || !isset($_GET['sm']) || !isset($_GET['sd']) || !isset($_GET['sh']) || !isset($_GET['si'])
				 || !isset($_GET['emode'])  )
			{
				$var_form_sy = $var_end_datetime->format("Y");
				$var_form_sm = $var_end_datetime->format("m");
				$var_form_sd = $var_end_datetime->format("d");
				$var_form_sh = $var_end_datetime->format("H");
				$var_form_si = $var_end_datetime->format("i");

				/*$var_form_ey = $var_end_datetime->format("Y");
				$var_form_em = $var_end_datetime->format("m");
				$var_form_ed = $var_end_datetime->format("d");
				$var_form_eh = $var_end_datetime->format("H");
				$var_form_ei = $var_end_datetime->format("i");*/
			}
			else
			{
				$var_form_sy = $_GET['sy'];
				$var_form_sm = $_GET['sm'];
				$var_form_sd = $_GET['sd'];
				$var_form_sh = $_GET['sh'];
				$var_form_si = $_GET['si'];

				$var_form_emode = $_GET['emode'];

				/*$var_form_ey = $_GET['ey'];
				$var_form_em = $_GET['em'];
				$var_form_ed = $_GET['ed'];
				$var_form_eh = $_GET['eh'];
				$var_form_ei = $_GET['ei'];*/
				
			}

		?>
		<br><br>
		<div class="row-fluid">
			<div class="span1"></div>
			<div class="span10 shadow">
				<div class="bgbold project_header">
					<div class="icon_novel">Interface Traffic Graph</div>
				</div>
				<div class="project_list_panel" style="overflow:none;height:450px;">
					<div class="media bgodd" style="height:80px;" >
						<center>
							database have traffic data for this interface between &nbsp;
							<?php echo $var_start_datetime->format("Y-m-d H:i:s") . " - " .  $var_end_datetime->format("Y-m-d H:i:s");?>
						</center>
						<div class="span2"></div>
						<div class="span8">
							<center>
								
								<form method="GET" action="deviceif.php">
									<input type="hidden" name="de_id" value="<?php echo $var_parameter_de_id; ?>">
									<input type="hidden" name="ifid" value="<?php echo $var_parameter_ifid?>">
									From &nbsp;<select name="sy" style="width:80px">
										<?php
											for($i=$var_start_datetime->format("Y");$i<=$var_start_datetime->format("Y");$i++)
											{
												if($i == $var_form_sy) echo '<option value="'.$i.'" selected>' . $i . '</option>';
												else 
												{ 
													if($i == $var_end_datetime->format("Y"))
													{
														echo '<option value="'.$i.'" selected>' . $i . '</option>';
													}
													else
													{
														echo '<option value="'.$i.'">' . $i . '</option>';
													}
												}
											}
										?>
									</select>
									-
									<select name="sm" style="width:55px">
										<?php 
											for($i=1;$i<=12;$i++)
											{
												if($i == $var_form_sm) echo '<option value="'.$i.'" selected>' . $i . '</option>';
												else 
												{ 
													if($i == $var_end_datetime->format("m"))
													{
														echo '<option value="'.$i.'" selected>' . $i . '</option>';
													}
													else
													{
														echo '<option value="'.$i.'">' . $i . '</option>';
													}
												}
											}
										?>
									</select>
									-
									<select name="sd" style="width:55px">
										<?php
											for($i=1;$i<=31;$i++)
											{
												if($i == $var_form_sd) echo '<option value="'.$i.'" selected>' . $i . '</option>';
												else 
												{ 
													if($i == $var_end_datetime->format("i"))
													{
														echo '<option value="'.$i.'" selected>' . $i . '</option>';
													}
													else
													{
														echo '<option value="'.$i.'">' . $i . '</option>';
													}
												}
											}
										?>
									</select>
									&nbsp;&nbsp;&nbsp;
									
									<select name="sh" style="width:55px">
										<?php 
											
											for($i=0;$i<=23;$i++)
											{
												if($i == $var_form_sh)
												{
													if($i < 10) echo '<option value="'.$i.'" selected>0' . $i . '</option>';
													else echo '<option value="'.$i.'" selected>' . $i . '</option>';
		
												}
												else
												{


														if($i < 10) echo '<option value="'.$i.'" >0' . $i . '</option>';
													else echo '<option value="'.$i.'" >' . $i . '</option>';
				

													
												}
											}
										?>
									</select>
									:
									<select name="si" style="width:55px">
										<?php
											for($i=0;$i<=59;$i++)
											{
												if($i == $var_form_si)
												{
													if($i < 10) echo '<option value="'.$i.'" selected>0' . $i . '</option>';
													else echo '<option value="'.$i.'" selected>' . $i . '</option>';
												}
												else
												{

														if($i < 10) echo '<option value="'.$i.'" >0' . $i . '</option>';
													else echo '<option value="'.$i.'" >' . $i . '</option>';

												}
											}
										?>
									</select>
									
									&nbsp;View Range&nbsp;
									
									<select name="emode" style="width:200px">
										<option value="0" selected>Day</option>
										<option value="1" >Week</option>
									</select>
									
									<br>
									<input type="submit" value="View Graph">
								</form>
							</center>
						</div>
						<div class="span2"></div>
					</div>
					<br>
					<?php
						if(!isset($_GET['sy']) || !isset($_GET['sm']) || !isset($_GET['sd']) || !isset($_GET['sh']) || !isset($_GET['si'])
						|| !isset($_GET['emode']) )
						{
							$array_device_interface = mysql_fetch_array($result_device_interface);
							$select_device_traffic_text = "select * from (select * from device_iftraffic where de_id=" . $var_parameter_de_id ." and di_ifid=".$var_parameter_ifid." order by dt_id desc LIMIT 0,10) as test order by dt_id asc";

							$result_device_traffic = mysql_query($select_device_traffic_text);

							if(mysql_num_rows($result_device_traffic) < 2 )
							{

							}
							else
							{
								$var_counter = 0;
								while($array_device_traffic = mysql_fetch_array($result_device_traffic))
								{
									$select_device_time_text = "select * from device_time where dt_id=".$array_device_traffic['dt_id']."";
									$result_device_time = mysql_query($select_device_time_text);
									$array_device_time = mysql_fetch_array($result_device_time);

									$array_in_ocet[$var_counter] = round(($array_device_traffic['df_avgin']/5)/60);
									$array_out_ocet[$var_counter] = round(($array_device_traffic['df_avgout']/5)/60);

									$tempdate = new DateTime($array_device_time['dt_etime']);
									$array_label[$var_counter] = $tempdate->format("H:i");
									$var_counter = $var_counter + 1;

								}
							}
						}
						else
						{
							$date_start = strtotime($var_form_sy."-".$var_form_sm."-".$var_form_sd." ".$var_form_sh.":".$var_form_si);

			$range_start_datetime = strtotime($var_start_datetime->format("Y-m-d H:i:s"));
			$range_end_datetime = strtotime($var_end_datetime->format("Y-m-d H:i:s"));

			if($var_form_emode == 0) $date_end = $date_start + 86400;
			else if($var_form_emode == 1) $date_end = $date_start + 604800;
			else if($var_form_emode == 2) $date_end = $date_start + 2419200;


		
			if($date_start < $range_start_datetime)
			{
				$json_buffer = '{"code":"500"}'; // Please select date between
				echo $json_buffer;
				exit();
			}
			else if($date_start > $range_end_datetime)
			{
					$json_buffer = '{"code":"501"}'; // Please select date between
					echo $json_buffer;
					exit();
			}

			$select_device_join_text = "select * from device_time join device_iftraffic on device_time.dt_id = device_iftraffic.dt_id where dt_etime >= '".date('Y-m-d H:i:s',$date_start)."' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."' and de_id=".$var_parameter_de_id." and di_ifid=" . $var_parameter_ifid."";

			$result_device_join = mysql_query($select_device_join_text);
			if(!mysql_num_rows($result_device_join))
			{
				$json_buffer = '{"code":"404"}'; // Please select date between
				echo $json_buffer;
				exit();
			}

			$array_label[0]="";
			$array_in_ocet[0]="";
			$array_out_ocet[0]="";
			
			if($var_form_emode == 0)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/15);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$array_label[0] = $fetch_date->format("H:i");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("H:i");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}
			else if($var_form_emode == 1)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/15);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);

				

				$array_label[0] = $fetch_date->format("d") . " " . $n_month[$fetch_date->format("m")] ." " . $fetch_date->format(" H:i");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("d") . " " . $n_month[$fetch_date->format("m")] ." " . $fetch_date->format(" H:i");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}
			else if($var_form_emode == 2)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/15);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$array_label[0] = $fetch_date->format("Y-m-d");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("Y-m-d");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}

		}

						$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);

						?>
						<center>
							<canvas id="canvas" height="250" width="800"></canvas>
						</center>
						<br>
						<div class="span2"></div>
						<div class="span8">
							<span class="label label-important" style="width:55px">Outbound</span>
							&nbsp;&nbsp;Min : <?php echo min($array_out_ocet)." ".$var_scale_text; ?>&nbsp;&nbsp;Max : <?php echo max($array_out_ocet)." ".$var_scale_text; ?>&nbsp;&nbsp;Avg :  <?php echo (float)number_format(array_sum($array_out_ocet)/count($array_out_ocet),2)." ".$var_scale_text; ?> 
							<br>
							<span class="label label-success" style="width:55px">Inbound</span>
							&nbsp;&nbsp;Min : <?php echo min($array_in_ocet)." ".$var_scale_text; ?>&nbsp;&nbsp;Max : <?php echo max($array_in_ocet)." ".$var_scale_text; ?>&nbsp;&nbsp;Avg :  <?php echo (float)number_format(array_sum($array_in_ocet)/count($array_in_ocet),2)." ".$var_scale_text; ?>
						</div>
						<div class="span2"></div>
					</div>
					<div class="bgbold btn_project_home" style="height:50px;"></div>
					<br><br><br>
				</div>
				<div class="span1"></div>
			</div>
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
						data : <?php echo json_encode($array_out_ocet);?>
						
					},
					{
						fillColor : "rgba(0,255,0,0.5)",
						strokeColor : "rgba(0,255,0,1)",
						pointColor : "rgba(0,255,0,1)",
						pointStrokeColor : "#fff",
						data : <?php echo json_encode($array_in_ocet);?>
					}
				]
				
			}
			var lineOption = {
				scaleShowLabels : true,
				scaleLabel : "<%=value%> <?php echo $var_scale_text;?>",
				scaleShowGridLines : true,
				scaleGridLineColor : "rgba(0,0,0,.20)",
				scaleGridLineWidth : 1,
				scaleFontColor : "#000",
				pointDot : false,
					scaleFontSize : 11,

				}
		var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData,lineOption);
	
	</script>
</body>
</html>

							












			
		


