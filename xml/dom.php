<?php
$con = mysql_connect('localhost', 'root', '1234');
	mysql_select_db('xml', $con);
	mysql_set_charset('utf-8');
	mysql_query("SET character_set_results=UTF8");
	mysql_query("SET character_set_client=UTF8");
	mysql_query("SET character_set_connection=UTF8");

$ran = rand(1,100);

$sql = sprintf("SELECT * FROM movie ORDER BY rand($ran) limit 2");
		$query = mysql_query($sql);
			
		// "Create" the document.
		$xml = new DOMDocument( "1.0","UTF-8");
		$movies = $xml->createElement( "movies" );
		while ($result = mysql_fetch_array($query)) {
			// Create some elements.
			$movie = $xml->createElement( "movie");
				$nameth = $xml->createElement( "nameth",$result['nameth']);
				$movie->appendChild( $nameth );
				$name = $xml->createElement( "name",$result['name']);
				$movie->appendChild( $name );
				$img = $xml->createElement( "img",$result['img']);
				$movie->appendChild( $img );
				$plot = $xml->createElement( "plot",$result['plot']);
				$movie->appendChild( $plot );
			
			$movies->appendChild( $movie );
		$xml->appendChild( $movies );
	
	}  
		print $xml->saveXML();

	/*$count =1;
	if ($count == 1) {
			$sql1 = sprintf("SELECT * FROM movie WHERE id = '$ran1' or id ");
		$query1 = mysql_query($sql1);
			
		// "Create" the document.
		$xml = new DOMDocument( "1.0","UTF-8");
		$movies = $xml->createElement( "movies" );
		$result1 = mysql_fetch_array($query1);

		// Create some elements.
			$movie = $xml->createElement( "movie");
				$nameth = $xml->createElement( "nameth",$result1['nameth']);
				$movie->appendChild( $nameth );
				$name = $xml->createElement( "name",$result1['name']);
				$movie->appendChild( $name );
				$img = $xml->createElement( "img",$result1['img']);
				$movie->appendChild( $img );
				$plot = $xml->createElement( "plot",$result1['plot']);
				$movie->appendChild( $plot );
			
			$movies->appendChild( $movie );
		$xml->appendChild( $movies );
		print $xml->saveXML();
		$count++;
		echo "<br>";
	}
	if ($count == 2) {
			$sql2 = sprintf("SELECT * FROM movie WHERE id = '$ran2' ");
		$query2 = mysql_query($sql2);
			
		// "Create" the document.
		$xml = new DOMDocument( "1.0","UTF-8");
		$movies = $xml->createElement( "movies" );
		$result2 = mysql_fetch_array($query2);

		// Create some elements.
			$movie = $xml->createElement( "movie");
				$nameth = $xml->createElement( "nameth",$result2['nameth']);
				$movie->appendChild( $nameth );
				$name = $xml->createElement( "name",$result2['name']);
				$movie->appendChild( $name );
				$img = $xml->createElement( "img",$result2['img']);
				$movie->appendChild( $img );
				$plot = $xml->createElement( "plot",$result2['plot']);
				$movie->appendChild( $plot );
			
			$movies->appendChild( $movie );
		$xml->appendChild( $movies );
print $xml->saveXML();
	}*/



/*
echo "<br>"."Random1 = ".$ran1."<br>";
echo "Random2 = ".$ran2;*/



?>

<!-- $name = $xml->createElement( "name",str_replace(" ", "%20", $result['name'])); -->