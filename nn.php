<?php

include 'data.php';
include('header.php');
$movies = new SimpleXMLElement($xmlstr);

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
       <?for ($i=1; $i <= 3 ; $i++) { 
		echo "<a class='waves-effect waves-light btn'  href='#$i'>";
		echo $movies->movie[$i]->characters[0]->character[0]->name;
		echo "</a>"."<br>";
		}?>
     </ul>  
   </div>

<!-- ***************************************** -->
   <div id="1" class="col s12 m12">
	<div class="row">	
			<div class="col s4 m3">
			<img src="<?= $movies->movie[1]->characters[0]->character[0]->img;?>" height="30%">
			</div> 

	        <div class="col s4 m6">
	          <div class="card blue-grey darken-1">
	            <div class="card-content white-text">
	              <span class="card-title"><?=$movies->movie[1]->characters[0]->character[0]->name;
	              ?><?=$movies->movie[1]->characters[0]->character[0]->nameth;
	              ?></span>
	              <p><?=$movies->movie[1]->plot;?></p>
	            </div>
	          </div>
	        </div>
	 </div>
   </div>
  <!-- **************************************** -->
   <div id="2" class="col s12">
  	<div class="row">	
			<div class="col s4 m3">
			<img src="<?= $movies->movie[2]->characters[0]->character[0]->img;?>" height="30%">
			</div> 

	        <div class="col s4 m6">
	          <div class="card blue-grey darken-1">
	            <div class="card-content white-text">
	              <span class="card-title"><?=$movies->movie[2]->characters[0]->character[0]->name;
	              ?><?=$movies->movie[2]->characters[0]->character[0]->nameth;
	              ?></span>
	              <p><?=$movies->movie[2]->plot;?></p>
	            </div>
	          </div>
	        </div>
	 </div>
 	</div>
 <!-- **************************************** -->
   <div id="3" class="col s12">
  	<div class="row">	
			<div class="col s4 m3">
			<img src="<?= $movies->movie[3]->characters[0]->character[0]->img;?>" height="30%">
			</div> 
	        <div class="col s4 m6">
	          <div class="card blue-grey darken-1">
	            <div class="card-content white-text">
	              <span class="card-title"><?=$movies->movie[3]->characters[0]->character[0]->name;
	              ?><?=$movies->movie[3]->characters[0]->character[0]->nameth;
	              ?></span>
	              <p><?=$movies->movie[3]->plot;?></p>
	            </div>
	          </div>
	        </div>
	 </div>
 	</div>
<!-- **************************************** -->
 		<div class="parallax-container">
   			 <div class="parallax"><img src="img/bg.jpg"></div>
  		</div>
  </div>
  </div>
 </body>
 </html> 
        