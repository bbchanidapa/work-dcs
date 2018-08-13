<?php

include("db.inc.php");
include("function.inc.php");


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Wi-Fi Overview - FITM NETWORK MONITOR</title>
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
	div.overlay {
    display:        table;
    position:       fixed;
    top:            0;
    left:           0;
    width:          100%;
    height:         100%;
	opacity:0.8;
	filter:alpha(opacity=80);
	}
	div.overlay > div {
		display:        table-cell;
		width:          100%;
		height:         100%;
		background:     #000;
		text-align:     center;
		vertical-align: middle;
	}
	
    </style>
    
	
	<link href="./css/project.css" rel="stylesheet">
	<script src="./js/jquery.js"></script>
	<script src="./js/Chart.js"></script>
	<script src="./js/bootstrap.js"></script>
	
  </head>

  <body >

  
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
				<div class="bgbold project_header" style="height:160px;">
				<div class="icon_novel">Wi-Fi Overview</div>
					<div class="row-fluid">
						<div class="span3"></div>
						<div class="span3" style="font-size:15px;border-width:0px 1px 0px 0px;border-style:solid;">Access Point
							<div class="row-fluid" style="margin:5px">
								<div class="span1"></div>
								<div class="span5" id="apOn" style="font-size:30px;font-weight:bold;text-align:right;">--</div>
								<div class="span5" id="apOff" style="font-size:30px;font-weight:bold;text-align:right;">--</div>
								<div class="span1"></div>
							</div>

							<div class="row-fluid">
								<div class="span1"></div>
								<div class="span5" style="font-size:13px;text-align:right;">Online</div>
								<div class="span5" style="font-size:13px;text-align:right;">Offline</div>
								<div class="span1"></div>
							</div>
							

						</div>

						<div class="span3" style="font-size:15px;">User Online
							<div class="row-fluid" style="margin:5px">
								<div class="span1"></div>
								<div class="span5" id="usrAuth" style="font-size:30px;font-weight:bold;text-align:right;">--</div>
								<div class="span5" id="usrPend" style="font-size:30px;font-weight:bold;text-align:right;">--</div>
								<div class="span1"></div>
							</div>

							<div class="row-fluid">
								<div class="span1"></div>
								<div class="span5" style="font-size:13px;text-align:right;">Authorized</div>
								<div class="span5" style="font-size:13px;text-align:right;">Pending</div>
								<div class="span1"></div>
							</div>
							

						</div>
						
						<div class="span3"></div>
					</div>
					
				</div>


				<div id="globalMap" style="position:relative;overflow:none;height:0px;background-color:#FFF">
					<div id="navMap" class="navbar">
						<div class="navbar-inner">
						<span class="brand" href="#">Select Map</span>
						<ul id="navMapIn" class="nav">
							
						</ul>
						</div>
					</div>
				  
					<div style="position:relative;overflow:none;height:100%;">
						<div id="map" style="width:100%;height:100%;background-size: 100% auto;background-image:url('img/wifi/fl1.png');background-repeat:no-repeat;">
						</div>
					</div>
				  
				 
				
					
				</div>
				
		



				
					
				
				</div>
			</div>			
		</div>

<div id="myModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Unifi AP Info</h3>
  </div>
  <div id="modelBody" class="modal-body">
	<div class="row-fluid">  
		<div class="span1"></div>
		<div class="span3"><img id="uni" src="img/wifi/unifi_g_big.png" style="width:128px;height:128px;"></div>
		<div class="span1"></div>
		<div class="span7"><h3><span id="apName">F1 Poungkarm1</span></h3>Software Version : <span id="apVer">Unknow</span><br>Serial : <span id="apSerial">DC9FDB947A34</span></div>
	</div>
	<div class="row-fluid">  
		<div class="span1"></div>
		<div class="span3"><center>IP : <span id="apIP">10.11.160.6</span><br>AP Client : <span id="apClient">0</span></center></div>
		<div class="span1"></div>
		<div class="span1"><img id="clock" src="img/device/clock_icon.png" style="width:32px;height:32px;"></div>
		<div class="span6"><b>Device Uptime</b><br><span id="apUtime">0d, 00:00:00</span></div>
	</div>
	<br>
	<button id="apReset" class="btn btn-large btn-inverse" type="button" style="width:100%">Restart Access Point</button>
  </div>
  <div class="modal-footer">
    <a href="#" id="modalHide" class="btn">Close</a>
  </div>
</div>
 <div class="overlay"><div><img src="img/wifi/ajax-loader.gif" border=0></div></div>
	<script language="javascript">
		var ap_connected = 0;
		var ap_disconnected = 0;
		var usr_authorized = 0;
		var usr_pending = 0;
		var map_list;
		var curMapfileid;
		var curMapindex;
		var curMapname;
		var curMapid;
		var curAPMac;
		var apList;
		var imgwidth;
		var imgheight;
		var selectedIndex = 0;

		window.onresize = function() {
			var myHTML="";
			for(var i=0;i<apList.data.length;i++)
			{
				var tempwidth = 0;
				var tempheight = 0;
				var tempx = 0;
				var tempy = 0;
		
				if (apList.data[i].map_id == curMapid)
				{
					var percentwidth = (document.getElementById("map").offsetWidth/imgwidth)*100;
					var percentheight = Math.round(((percentwidth*imgheight/100)/imgheight)*100);

					$('#globalMap').css("height",Math.round((percentwidth*imgheight/100)) + "px");
													
					tempwidth = 32;//Math.round((percentwidth*128)/100);
					tempheight = 32;//Math.round((percentwidth*128)/100);

					tempx = Math.round((((percentwidth*apList.data[i].x)/100) - (tempwidth/2)));
					tempy = Math.round((((percentwidth*apList.data[i].y)/100) - (tempheight/2)));

					if(apList.data[i].state == 1)
													{
														/*myHTML = myHTML + '<img id="unifi1" class="unifi" data-mac="'+apList.data[i].mac+'" src="img/wifi/unifi_g.png" style="position:absolute;width:'+tempwidth+'px;height:'+ tempheight +'px;left:' +tempx+ 'px;top:'+tempy+'px;">';*/


														myHTML = myHTML + '<div class="unifi" data-mac="'+apList.data[i].mac+'" style="position:absolute;left:' +tempx+ 'px;top:'+tempy+'px;width:'+tempwidth+'px;height:'+ tempheight +'px;background-size: 100% auto;background-image:url(img/wifi/unifi_g.png);background-repeat:no-repeat;"><div style="margin-top:5px"><center>' + apList.data[i].num_sta +'</center></div></div>';
													}
													else
													{
														/*myHTML = myHTML + '<img id="unifi1" class="unifi" data-mac="'+apList.data[i].mac+'" src="img/wifi/unifi_r.png" style="position:absolute;width:'+tempwidth+'px;height:'+ tempheight +'px;left:' +tempx+ 'px;top:'+tempy+'px;">';*/
														myHTML = myHTML + '<div class="unifi" data-mac="'+apList.data[i].mac+'" style="position:absolute;left:' +tempx+ 'px;top:'+tempy+'px;width:'+tempwidth+'px;height:'+ tempheight +'px;background-size: 100% auto;background-image:url(img/wifi/unifi_r.png);background-repeat:no-repeat;"><div style="margin-top:5px"><center>0</center></div></div>';
													}
				}
												
			 }

										  //alert(myHTML);
										  
			 $('#map').html(myHTML);


		}

		$(document).ready(function(){
			reloadUnifi();
		});

		

		$(".mapMenu").live("click",function(){
				//alert($(this).attr("data-mapindex"));
				selectedIndex = $(this).attr("data-mapindex");
				reloadUnifi();
		});


		$("#modalHide").live("click",function(){
			$('#myModal').modal("hide");
				
		});
		
		$("#apReset").live("click",function(){
			$.ajax({
					  type: "POST",
					  url: "http://202.44.47.47/unifi/restart-ap",
					  data: { mac: curAPMac }
					})
					  .done(function( html ) {
						alert("Access Point is restarting...");
						$('#myModal').modal("hide");
						reloadUnifi();
					  });
		});

		$(".unifi").live("click",function(){
			//alert($(this).attr("data-mac"));
			curAPMac = $(this).attr("data-mac");
			$.ajax({
				  url: "http://202.44.47.47/unifi/ap?mac=" + $(this).attr("data-mac"),
				  cache: false
				}).done(function(html) {
					var temp = html;
					var unixtime,day,hour,mins,secs;
					$('#apName').html(html.data.name);
					$('#apSerial').html(html.data.serial);
					$('#apIP').html(html.data.ip);
					
					if(html.data.state == 1)
					{
						$('#uni').attr("src", "img/wifi/unifi_g_big.png");
						
						$('#apVer').html(html.data.version);
						$('#apClient').html(html.data.num_sta);
						unixtime = html.data.uptime;
						day = Math.round(unixtime / 86400);
						hour = Math.round((unixtime % 86400) / 3600);
						mins = Math.round((unixtime % 3600) / 60);
						secs = Math.round(unixtime % 60);
						$('#apUtime').html( day +'d, '+ hour +':'+mins+':'+secs+'');
						$('#apReset').toggleClass('disabled', false);
            

					}
					  else
					{
						$('#uni').attr("src", "img/wifi/unifi_r_big.png");
						$('#apVer').html("Unknow");
						$('#apClient').html("0");
						$('#apUtime').html('down.');
						$('#apReset').toggleClass('disabled', true);
					}

				 });
			$('#myModal').modal("show");
				
		});
		
		function reloadUnifi()
		{
			$('.overlay').fadeIn(1000);
			$.ajax({
				  url: "http://202.44.47.47/unifi/ap-count",
				  cache: false
				}).done(function(html) {
					var temp = html;
					ap_connected = html.data.connected;
					ap_disconnected = html.data.disconnected;


					$.ajax({
					  url: "http://202.44.47.47/unifi/device-count",
					  cache: false
					}).done(function(html) {
						var temp = html;
						usr_authorized = html.data.authorized;
						usr_pending = html.data.non_authorized;

						$('#apOn').html(ap_connected);
						$('#apOff').html(ap_disconnected);
						$('#usrAuth').html(usr_authorized);
						$('#usrPend').html(usr_pending);

						$.ajax({
							  url: "http://202.44.47.47/unifi/map-list",
							  cache: false
							}).done(function(html) {
								map_list = html;

								curMapfileid = map_list.data[selectedIndex].file_id;
								curMapindex = map_list.data[selectedIndex].order;
								curMapname = map_list.data[selectedIndex].name;
								curMapid = map_list.data[selectedIndex]._id;
								
								var tempHTML = "";
								for(var i=0;i<map_list.data.length;i++)
								{
									if (i == selectedIndex)
									{
										tempHTML = tempHTML + '<li  class="active" data-mapindex="' + i + '"><a href="#">' + map_list.data[i].name +'</a></li>';
									}
									else
									{
										tempHTML = tempHTML + '<li  class="mapMenu" data-mapindex="' + i + '"><a href="#">' + map_list.data[i].name +'</a></li>';
									}
									

								}
								$('#navMapIn').html(tempHTML);
								$('#map').css("background-image","url('http://202.44.47.47/unifi/map?id=" + curMapfileid + "')");
								var img = new Image();
								img.onload = function() {
									imgwidth = this.width;
									imgheight = this.height;
									$.ajax({
									  url: "http://202.44.47.47/unifi/ap",
									  cache: false
									}).done(function(html) {
										  apList = html;
											
							
										  var myHTML="";
										  for(var i=0;i<apList.data.length;i++)
										  {
												var tempwidth = 0;
												var tempheight = 0;
												var tempx = 0;
												var tempy = 0;
		
												if (apList.data[i].map_id == curMapid)
												{
													var percentwidth = (document.getElementById("map").offsetWidth/imgwidth)*100;
													var percentheight = Math.round(((percentwidth*imgheight/100)/imgheight)*100);

													$('#globalMap').css("height",Math.round((percentwidth*imgheight/100)) + "px");
													//document.getElementById("map").offsetHeight/imgheight)*100
													
													
													

													tempwidth = 32;//Math.round((percentwidth*32)/100);
													tempheight = 32;//Math.round((percentwidth*32)/100);

													tempx = Math.round((((percentwidth*apList.data[i].x)/100) - (tempwidth/2)));
													tempy = Math.round((((percentwidth*apList.data[i].y)/100) - (tempheight/2)));
													if(apList.data[i].state == 1)
													{
														/*myHTML = myHTML + '<img id="unifi1" class="unifi" data-mac="'+apList.data[i].mac+'" src="img/wifi/unifi_g.png" style="position:absolute;width:'+tempwidth+'px;height:'+ tempheight +'px;left:' +tempx+ 'px;top:'+tempy+'px;">';*/


														myHTML = myHTML + '<div class="unifi" data-mac="'+apList.data[i].mac+'" style="position:absolute;left:' +tempx+ 'px;top:'+tempy+'px;width:'+tempwidth+'px;height:'+ tempheight +'px;background-size: 100% auto;background-image:url(img/wifi/unifi_g.png);background-repeat:no-repeat;"><div style="margin-top:5px"><center>' + apList.data[i].num_sta +'</center></div></div>';
													}
													else
													{
														/*myHTML = myHTML + '<img id="unifi1" class="unifi" data-mac="'+apList.data[i].mac+'" src="img/wifi/unifi_r.png" style="position:absolute;width:'+tempwidth+'px;height:'+ tempheight +'px;left:' +tempx+ 'px;top:'+tempy+'px;">';*/
														myHTML = myHTML + '<div class="unifi" data-mac="'+apList.data[i].mac+'" style="position:absolute;left:' +tempx+ 'px;top:'+tempy+'px;width:'+tempwidth+'px;height:'+ tempheight +'px;background-size: 100% auto;background-image:url(img/wifi/unifi_r.png);background-repeat:no-repeat;"><div style="margin-top:5px"><center>0</center></div></div>';
													}
												}
												
										  }

											//$('#globalMap').css("height",(document.getElementById("map").offsetHeight) + "px");
											//alert(document.getElementById("map").offsetWidth);
	
										  //alert(myHTML);
										  
										  $('#map').html(myHTML);
										  $('.overlay').fadeOut(1000);




									});
								}
							img.src = "http://202.44.47.47/unifi/map?id=" + curMapfileid + "";

						});
					  });

				  });
		}


		


					 /* var temp = JSON.parse(html);
						alert(temp);*/
					//$( "#results" ).append( html );
				 // });
	//<img id="unifi1" src="img/wifi/unifi.png" style="position:absolute;width:32px;height:32px;left:190px;top:80px;">
	/*window.onresize = function() {
		var percentwidth = (document.getElementById("map").offsetWidth/1000)*100;
		var percentheight = (document.getElementById("map").offsetHeight/600)*100;
		document.getElementById("unifi1").style.left = (((percentwidth*190)/100) - (document.getElementById("unifi1").offsetWidth/2)) + "px";
		document.getElementById("unifi1").style.top = (((percentwidth*80)/100) - (document.getElementById("unifi1").offsetHeight/2)) + "px";
		document.getElementById("unifi1").style.width = (percentwidth*32)/100 + "px";
		document.getElementById("unifi1").style.height = (percentwidth*32)/100 + "px";*/
    //alert(document.getElementById("map").offsetWidth);
	//1005 - 5
	//600  - 3
	//32
	//32
	//<img id="unifi1" src="img/wifi/unifi.png" style="position:absolute;width:32px;height:32px;left:190px;top:80px;">
	//<img id="unifi1" src="img/wifi/unifi.png" style="position:absolute;width:32px;height:32px;left:190px;top:80px;">*/
	

	</script>	
  </body>
  
</html>
