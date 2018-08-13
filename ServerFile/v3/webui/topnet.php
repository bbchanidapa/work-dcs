<?php
include("db.inc.php");
include("function.inc.php");
include("ip2net.inc.php");

$select_many_join_text = "select TfRate.dv_vlanid,TfRate.de_id,TfRate.dv_vlanname ,device_interface.di_ipaddr,device_interface.di_subnet,TfRate.totaltraffic,TfRate.df_avgin,TfRate.df_avgout from device_interface join (select Tfdata.df_avgin,Tfdata.df_avgout,device_vlan.dv_vlanid,Tfdata.de_id,device_vlan.dv_vlanname ,Tfdata.totaltraffic from (select sum(device_iftraffic.df_avgin) as df_avgin,sum(device_iftraffic.df_avgout) as df_avgout,sum(device_iftraffic.df_avgin)+sum(device_iftraffic.df_avgout) as totaltraffic,device_iftraffic.de_id,device_interface.di_vlanid from device_iftraffic join device_interface on device_iftraffic.de_id = device_interface.de_id and device_iftraffic.di_ifid = device_interface.di_ifid and  dt_id=(select dt_id from device_time order by dt_id desc LIMIT 0,1) GROUP BY device_interface.di_vlanid) as Tfdata join device_vlan on device_vlan.dv_vlanid = Tfdata.di_vlanid and device_vlan.dv_vlanid != 0 and device_vlan.dv_vlanid != 99 and device_vlan.dv_vlanid != 1) as TfRate on device_interface.de_id = TfRate.de_id and device_interface.di_ifid = TfRate.dv_vlanid order by TfRate.totaltraffic desc LIMIT 0,10";

$result_many_join = mysql_query($select_many_join_text);
if(!mysql_num_rows($result_many_join))
{
	echo "Please wait while data updating and try again later";
	exit();
}

$array_slot = 0;
while($array_many_join = mysql_fetch_array($result_many_join))
{
	$array_netid[$array_slot] = ip2net($array_many_join['di_ipaddr'],$array_many_join['di_subnet']);
	$array_vlanid[$array_slot] = $array_many_join['dv_vlanid'];
	$array_vlanname[$array_slot] = $array_many_join['dv_vlanname'];
	$array_in_ocet[$array_slot] = round(($array_many_join['df_avgin']/5)/60);
	$array_out_ocet[$array_slot] = round(($array_many_join['df_avgout']/5)/60);
	$array_label[$array_slot] = $array_many_join['dv_vlanname'] ;
	$array_slot = $array_slot + 1;



}

$var_scale_text = UnitConvert($array_in_ocet,$array_out_ocet);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Top 10 Network Traffic</title>
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
					<div class="icon_novel">Top 10 Network Traffic Usage (By VLAN)</div>
				</div>
				<div class="project_list_panel" style="overflow:none;height:900px;">
					<div class="media " style="height:900px;" >
						
						<div class="span12">
						<br>
						<center>
							<span class="label label-important" style="width:55px">Outbound</span>&nbsp;&nbsp;&nbsp;
							<span class="label label-success" style="width:55px">Inbound</span>
							<br><br>
							<canvas id="canvas" height="300" width="1000"></canvas>
							<br><br><br>
							<div class="span2"></div>
							<div class="span8">
								<table border=1 class="table table-bordered">
									<caption><h3>Top 10 Network Traffic Usage</h3></caption>
									<thead>
										<tr>
											<th style="width:20px;text-align:center;">#</th>
											<th style="width:50px;text-align:center;">VLAN ID</th>
											<th style="width:100px;text-align:center;">VLAN NAME</th>
											<th style="width:100px;text-align:center;">Network ID</th>
											<th style="width:100px;text-align:center;">Inbound</th>
											<th style="width:100px;text-align:center;">Outbound</th>
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
										for($i=0;$i<count($array_netid);$i++)
										{
											echo '<tr>';
											echo '<td style="text-align:right;">'.($i+1).'</td>';
											echo '<td style="text-align:center;">'.$array_vlanid[$i].'</td>';
											echo '<td style="text-align:center;">'.$array_vlanname[$i].'</td>';
											echo '<td style="text-align:center;">'.$array_netid[$i].'</td>';
											echo '<td style="text-align:right;">'.$array_in_ocet[$i].' '.$var_scale_text.'</td>';
											echo '<td style="text-align:right;">'.$array_out_ocet[$i].' '.$var_scale_text.'</td>';
											echo '</tr>';
										}
									?>
									</tbody>
								</table>
							</div>
							<div class="span2"></div>
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
					labels : <?php echo json_encode($array_label); ?>,
					datasets : [
						{
							fillColor : "rgba(255,0,0,0.5)",
							strokeColor : "rgba(255,0,0,1)",
							data : <?php echo json_encode($array_out_ocet); ?>
						},
						{
							fillColor : "rgba(0,255,0,0.5)",
							strokeColor : "rgba(0,255,0,1)",
							data : <?php echo json_encode($array_in_ocet); ?>
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

							












			
		


