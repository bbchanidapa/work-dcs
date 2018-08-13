<?php
$query = sprintf('SELECT name FROM place where id = 1');
$result = mysql_query($query);
$result = mysql_fetch_assoc($result);


// -- Feeding UTF-8 data directly WORKS
$domDocument = new DOMDocument('1.0','UTF-8');
$rootNode = $domDocument->createElement('Response');
$rootNode->appendChild($domDocument->createCDATASection('Café Belga'));
$domDocument->appendChild($rootNode);

$matcher = array('tag' => 'Response');
self::assertTag($matcher, $domDocument->saveXML(), '', FALSE);

// -- Feeding UTF-8 data from the resultset FAILS
$domDocument = new DOMDocument('1.0','UTF-8');
$rootNode = $domDocument->createElement('Response');
$rootNode->appendChild($domDocument->createCDATASection($result['name']));
$domDocument->appendChild($rootNode);

$matcher = array('tag' => 'Response');
self::assertTag($matcher, $domDocument->saveXML(), '', FALSE);



?>


<?php
/*$xmlDoc = new DOMDocument();
$xmlDoc->load("note.xml");

$x = $xmlDoc->documentElement;
foreach ($x->childNodes AS $item) {
  print $item->nodeName . " = " . $item->nodeValue . "<br>";
}*/
?>

<?php
/*$xmlstr = <<<XML
<?xml version='1.0'  ?>
<movies>

<movie>
	   	<nameth>กำเนิดศึกสองพิภพ</nameth>
	    <name>Warcraft</name> 
	    <img>img/img1.jpg</img>
  <plot>
   อาณาจักรอาซีร็อธอันเงียบสงบ กำลังใกล้จะเกิดสงครามปะทุขึ้นเมื่อความศิวิไลซ์ของอาณาจักรแห่งนี้กำลังเผชิญกับผู้รุกรานที่เป็นเผ่าพันธุ์ที่น่ากลัว นั่นก็คือ พวกนักรบออร์คซึ่งละทิ้งบ้านเกิดที่กำลังจะตายและหนีมาตั้งอาณานิคมที่ดาวดวงอื่น เมื่อประตูที่เชื่อมระหว่างสองโลกเปิดออก กองทัพฝ่ายหนึ่งเผชิญกับการทำลายล้าง ขณะที่อีกฝ่ายหนี่งเผชิญกับการสูญสิ้นเผ่าพันธุ์ 
  </plot>
 </movie>

 </movies>
XML;
?>
<?
;
$movies = new SimpleXMLElement($xmlstr);
echo $movies->movie[0]->name;*/

?>




<?php
/*$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<content min-version="1.0" version="1.0" xmlns="http://www.apple.com/DTDs/iTunesDVDContent-1.0.dtd">
<title>District 9</title>
<require min-version="7.6" what="iTunes"/>
<id>222857</id>
<vendor_id>DISTRICT_9_2009</vendor_id>
<item>
<title>District 9</title>
<fileID>901437</fileID>
<itemID>331251689</itemID>
<link length="1753320964" md5="e742efbaa7b162d16c291376968426db" file-extension="m4v" type="video/x-m4v" href="Media/FeatureMovie" rel="enclosure"/>
</item>
</content> 
XML;*/
?>


<?
/*$url = "https://maps.googleapis.com/maps/api/streetview?size=600x300&location=46.414382,10.013988&heading=151.78&pitch=-0.76&key=AIzaSyB7Z28QH5KwMluldy8-fU-fojwFZqNjy0c";

$xml = simplexml_load_file($url);
echo $xml;
echo "<br>";*/
?>
<?
/*$url = "http://maps.google.com/maps/api/directions/xml?origin=Quentin+Road+Brooklyn%2C+New+York%2C+11234+United+States&destination=550+Madison+Avenue+New+York%2C+New+York%2C+10001+United+States&sensor=false";
$xml = simplexml_load_file($url);
echo $xml->status;
echo "<br>";
echo $xml->route->summary;*/
?>