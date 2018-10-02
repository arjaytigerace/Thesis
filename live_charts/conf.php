<?php
$dbusername = "arduino";  // enter database username, I used "arduino" in step 2.2
$dbpassword = "arduino123";  // enter database password, I used "arduinotest" in step 2.2
$server = "localhost"; // IMPORTANT: if you are using XAMPP enter "localhost", but if you have an online website enter its address, ie."www.yourwebsite.com"
	
$dbconnect = mysqli_connect($server, $dbusername, $dbpassword);
$dbselect = mysqli_select_db($dbconnect,"thesis_live");

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
?>