<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<?php 
 	date_default_timezone_set('Asia/Bangkok');//Set time Zone	

	$detail    = include('get_mib/get_detail.php');
	$traf_link = include('get_mib/get_traffics_toInterface.php');
	$status    = include('get_mib/get_status_interface.php');
	$topRanking     = include('get_mib/get_top_traffics.php');
	$traf_Device    = include('get_mib/get_traffics_device.php');
	//$traf_Interface = include('get_mib/get_traffics_interface.php');
	$traf_Ratio     = include('get_mib/get_traffics_ratio.php');
	$traf_sw4503    = include('get_mib/get_traffics_sw4503.php');


?>
<script>
/*function get(){
	return $.ajax({
		url:'./get_mib/get_interface.php',
		type:'get',
		async: false,
		success:function(res){	
			 
		}
	});
}
*/
	var url = "https://sheetsu.com/apis/v1.0/a265e4486e6a";//sheet2 
	//var url = "https://sheetsu.com/apis/v1.0/034125981dca";//sheet 3 
	
	//var interface_ = get();
	var time = <?php echo "'".date("H:i:s")."'"; ?>;
	var date = <?php echo "'".date("j,n,Y")."'"; ?>;
	var detail_ = <?php echo $detail; ?>;	
	var	status_ = <?php echo $status; ?>;
	var	topRanking_ = <?php echo $topRanking; ?>;
	var	traffic_device_ = <?php echo $traf_Device; ?>;
	//var	traffic_interface_ = <?php echo $traf_Interface; ?>;
	var traffic_ratio_ = <?php echo $traf_Ratio; ?>;
	var	traffic_sw4503_ = <?php echo $traf_sw4503; ?>;
	var traffic_To_Interface_ = <?php echo $traf_link; ?>;
	setInterval(function(){
		$.ajax({
			url:url,
			type:"post",
			data:{
				"date" : date,
				"time" : time,
				"detail"            : JSON.stringify(detail_),
				//"interface"         : interface_['responseText'],
				"status"            : JSON.stringify(status_),
				"topRanking"        : JSON.stringify(topRanking_),
				"traffic_device"    : JSON.stringify(traffic_device_),
				//"traffic_interface" : JSON.stringify(traffic_interface_),
				"traffic_ratio"     : JSON.stringify(traffic_ratio_),
				"traffic_sw4503"    : JSON.stringify(traffic_sw4503_),
				"traffic_toInterface"    : JSON.stringify(traffic_To_Interface_),
			},
			success:function(res){
				console.log(res)
				document.location.reload(true);
			}
		})
	},300000);
										
									 
</script>