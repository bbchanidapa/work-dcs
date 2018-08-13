<?php
include 'xml.php';
$movies = new SimpleXMLElement($xmlstr);
echo $movies->title."<br>";
echo $movies->item->link;
?>


        