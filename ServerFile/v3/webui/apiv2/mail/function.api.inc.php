<?php

function UnitConvertVar(&$var)
{
	$max_ocet = $var;
	$unit = "";
	if($max_ocet > 1099511627776)
	{
		$unit = "TB";
		$unitmod = 1099511627776;
	}
	else if($max_ocet  > 1073741824)
	{
		$unit = "GB";
		$unitmod = 1073741824;
	}
	else if($max_ocet  > 1048576)
	{
		$unit = "MB";
		$unitmod = 1048576;
	}
	else if($max_ocet  > 1024)
	{
		$unit = "KB";
		$unitmod = 1024;
	}
	else
	{
		$unit = "Byte";
		$unitmod = 1;
	}

		$var = number_format((float)(($var)/$unitmod),2);

	return $unit;
}


function UnitConvertVarNoSec(&$var)
{
	$max_ocet = $var*8;
	$unit = "";
	if($max_ocet  > 1073741824)
	{
		$unit = "Gbps";
		$unitmod = 1073741824;
	}
	else if($max_ocet  > 1048576)
	{
		$unit = "Mbps";
		$unitmod = 1048576;
	}
	else if($max_ocet  > 1024)
	{
		$unit = "Kbps";
		$unitmod = 1024;
	}
	else
	{
		$unit = "bps";
		$unitmod = 1;
	}

		$var = number_format((float)(($var*8)/$unitmod),2);

	return $unit;
}

function UnitConvert(&$inocet,&$outocet)
{
	$max_ocet = max(max($inocet)*8,max($outocet)*8);
	$unit = "";
	if($max_ocet  > 1073741824)
	{
		$unit = "Gbps";
		$unitmod = 1073741824;
	}
	else if($max_ocet  > 1048576)
	{
		$unit = "Mbps";
		$unitmod = 1048576;
	}
	else if($max_ocet  > 1024)
	{
		$unit = "Kbps";
		$unitmod = 1024;
	}
	else
	{
		$unit = "bps";
		$unitmod = 1;
	}

	for($i=0;$i<count($inocet);$i++)
	{
		$inocet[$i] = number_format((float)($inocet[$i]*8/$unitmod),2);
		$outocet[$i] = number_format((float)($outocet[$i]*8/$unitmod),2);

	}
	return $unit;
}

function UnitConvertOne(&$ocet)
{
	$max_ocet = (max($ocet)*8);
	$unit = "";
	if($max_ocet  > 1073741824)
	{
		$unit = "Gbps";
		$unitmod = 1073741824;
	}
	else if($max_ocet  > 1048576)
	{
		$unit = "Mbps";
		$unitmod = 1048576;
	}
	else if($max_ocet  > 1024)
	{
		$unit = "Kbps";
		$unitmod = 1024;
	}
	else
	{
		$unit = "bps";
		$unitmod = 1;
	}

	for($i=0;$i<count($ocet);$i++)
	{
		$ocet[$i] = number_format((float)($ocet[$i]*8/$unitmod),2);

	}
	return $unit;
}


function UnitConvertOneNoSec(&$ocet)
{
	$max_ocet = max($ocet);
	$unit = "";
	if($max_ocet  > 1073741824)
	{
		$unit = "GB";
		$unitmod = 1073741824;
	}
	else if($max_ocet  > 1048576)
	{
		$unit = "MB";
		$unitmod = 1048576;
	}
	else if($max_ocet  > 1024)
	{
		$unit = "KB";
		$unitmod = 1024;
	}
	else
	{
		$unit = "Byte";
		$unitmod = 1;
	}

	for($i=0;$i<count($ocet);$i++)
	{
		$ocet[$i] = number_format((float)($ocet[$i]/$unitmod),2);

	}
	return $unit;
}




?>