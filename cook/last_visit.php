<?
session_start();
include('connect.php');
		$user = $_SESSION['username'];
		$sql = "SELECT user.cookie FROM user WHERE username = '$user' ";
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);
		$cookie = $result['cookie'];
//$mount = time()+2592000; //2592000 เวลาหนึ่งเดือน

$time_now = date("F JS, Y -g:i a");
setcookie('LastVisit', $time_now, $cookie);
echo "$time_now"."<br>";


if ($COOKIE['LastVisit']) {
	$last = $_COOKIE['LastVisit'];
	$cookie = time()+$time;
	setcookie('$last', $time_now, $cookie);
	echo $time."<br>";
}else{
	echo "Welcome...";
}
echo $_SESSION['username'];
echo "<br>"."Today is $time_now";
?>