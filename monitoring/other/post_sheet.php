<?php
$url = "http://localhost/monitoring/get_detail.php";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
//print_r(($result));
//API Url
$url = 'https://sheetsu.com/apis/v1.0/44ffd6759661';
$jsonString = array('id'=>'7','name'=>'aaaa',"score"=> "69" );
 
 //include('http://localhost/monitoring/get_detail.php');  
                                                              
// // You can directly replace your JSON string with $jsonString variable.
// $ch = curl_init();
// $timeout = 0; // Set 0 for no timeout.
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
// 'Content-Type: application/json',
// 'Content-Length: ' . strlen($jsonString),)
// );
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
// $result = curl_exec($ch);
// curl_close($ch);

?>
<script>
	 $.ajax({
			url:  "https://sheetsu.com/apis/v1.0/59fa224b0c36",
			type: "post",
			data: data,
			success:function(res){
				console.log(res)
			}
		})   
</script>