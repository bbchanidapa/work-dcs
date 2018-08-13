<?
include('header.php');
$url = "http://10.9.57.9:81/xml/domm1.php";
$path = "http://10.9.57.9:81/xml/";
$parameter = "id=$id";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 );
$result = curl_exec($ch);
$str = simplexml_load_string($result);
//print_r($str);
curl_close($ch);

?>
<html>
<head>
	<title></title>
</head>
<body>

   <div class="section white">
    <div class="row container">
   <div class="col s12 m12">
     <ul class="tabs">       
       <?for ($i=1; $i <= 6 ; $i++) {
		echo "<a class='waves-effect waves-light btn'  href='#$i'>";
		if ($i) { 
			$c = $i - 1;
			echo $str->movie[$c]->name;
		}
		echo "</a>"."<br>";
		}?>
		
     </ul>  
   </div>

<!-- ***************************************** -->
   <div id="1" class="col s12 m12">
	<div class="row">
			<div class="col s4 m3">
			<img src="<?echo $path.$str->movie[0]->img;?>" height="30%">
			</div> 
	        <div class="col s4 m6">
	          <div class="card blue-grey darken-1">
	            <div class="card-content white-text">
	              <span class="card-title"><?=$str->movie[0]->name;
	              ?>(
	              <?=$str->movie[0]->nameth;
	              ?>)</span>
	              <p><?=$str->movie[0]->plot;?></p>
	            </div>
	          </div>
	        </div>
	 </div>
   </div>
  <!-- **************************************** -->
   <div id="2" class="col s12">
  	<div class="row">	
			<div class="col s4 m3">
			<img src="<?echo $path.$str->movie[1]->img;?>" height="30%">
			</div> 

	        <div class="col s4 m6">
	          <div class="card blue-grey darken-1">
	            <div class="card-content white-text">
	              <span class="card-title"><?=$str->movie[1]->name;
	              ?>(
	              <?=$str->movie[1]->nameth;
	              ?>)</span>
	              <p><?=$str->movie[1]->plot;?></p>
	            </div>
	          </div>
	        </div>
	 </div>
 	</div>
 <!-- **************************************** -->
  <!--  <div id="3" class="col s12">
    	<div class="row">	
  			<div class="col s4 m3">
  			<img src="<?= $str->movie[3]->img;?>" height="30%">
  			</div> 
  
  	        <div class="col s4 m6">
  	          <div class="card blue-grey darken-1">
  	            <div class="card-content white-text">
  	              <span class="card-title"><?=$str->movie[3]->name;
  	              ?>(
  	              <?=$str->movie[3]->nameth;
  	              ?>)</span>
  	              <p><?=$str->movie[3]->plot;?></p>
  	            </div>
  	          </div>
  	        </div>
  	 </div>
   	</div> -->
<!-- **************************************** -->
 		<!-- <div class="parallax-container">
 		   			 <div class="parallax"><img src="img/bg.jpg"></div>
 		  		</div> -->
  </div>
  </div>
 </body>
 </html> 