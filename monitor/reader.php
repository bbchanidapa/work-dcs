<!DOCTYPE html>
<html>
<body>

<?php
$xml_face = simplexml_load_file("interface/r124.xml");
//$xml_icmp = simplexml_load_file("project/r124/icmp.xml");
$xml_ip = simplexml_load_file("project/r124/ip&mac.xml");
//$xml = simplexml_load_file("project/r124/NetId.xml");
//$xml = simplexml_load_file("project/r124/system.xml");
//$xml = simplexml_load_file("project/r124/tcp.xml");
//$xml = simplexml_load_file("project/r124/udp.xml");
//$xml = simplexml_load_file("i.xml");
$interfaces = array();
//echo "<br>".$xml->getName() . "<br />";
 foreach($xml_face->children() as $childs)
  {
  	//echo $childs->getName() . ": " . $childs . "<br />";
  	$getPatlen = $childs->getName();
	  foreach($childs->children() as $child)
	  {
	   	 $name = $child->attributes()->name ;
	   	 echo $name;

	 	 $getname = $child->getName();
  		 foreach($child->children() as $val)
		  {
		 	$value = $val->getName() . ": " . $val ;
		 	echo $value."<br />";
		  }
	  }
  }

   //----------------
  ?><br><br><?

/*  foreach($xml_ip->children() as $childs)
  {
  	$getPatlen = $childs->getName();
	  foreach($childs->children() as $child)
	  {
	  	 echo $child->attributes()->name . ": " ;
	 	 $getname = $child->getName();
  		 foreach($child->children() as $val)
		  {
		 	echo $val->getName() . ": " . $val . "<br />";
		  }
	  }
  }*/
 

?>

</body>
</html>
