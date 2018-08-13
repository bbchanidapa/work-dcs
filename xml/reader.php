<!DOCTYPE html>
<html>
<body>

<?php

$xml_face = simplexml_load_file("project/r124/interface.xml");
//$xml = simplexml_load_file("project/r124/icmp.xml");
//$xml = simplexml_load_file("project/r124/ip&mac.xml");
//$xml = simplexml_load_file("project/r124/NetId.xml");
//$xml = simplexml_load_f("projeciet/r124/NetId.xml");
//$xml = simplexml_load_file("project/r124/system.xml");
//$xml = simplexml_load_file("project/r124/tcp.xml");
//$xml = simplexml_load_file("project/r124/udp.xml");
//$xml = simplexml_load_file("i.xml");

//echo "<br>".$xml->getName() . "<br />";
 foreach($xml_face->children() as $childs)
  {
  	//echo $childs->getName() . ": " . $childs . "<br />";
  	$getPatlen = $childs->getName();
	  foreach($childs->children() as $child)
	  {
	  	echo /*$child->getName()*/  $child->attributes()->name . ": " ;
	 	 $getname = $child->getName();
  		 foreach($child->children() as $val)
		  {
		 	echo $val->getName() . ": " . $val . "<br />";
		  }

	  }
  }

?>

</body>
</html>
