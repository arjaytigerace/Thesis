<?php
	require_once 'conf.php';
    session_start();

	$read = array();

	//Data sent by arduino will be passed into this variable
	$Temp = $_POST["x"];
    $read = explode("-", $Temp);


	//Setting newt_textbox_set_height(textbox, height) default timezone
	date_default_timezone_set('Asia/Manila');
	$date = date("Y/m/d H:i:sa");

	//Inserting data to different table
	$phLevelSQL = 'INSERT INTO thesis_live.phsensor (`phLevel`,`dateRet`) VALUES ("'.$read[0].'", "'.$date.'")';

	$tempLevelSQL = 'INSERT INTO thesis_live.tempsensor (`tempLevel`,`dateRet`) VALUES ("'.$read[1].'", "'.$date.'")';

	$turbLevelSQL = 'INSERT INTO thesis_live.turbsensor (`turbLevel`,`dateRet`) VALUES ("'.$read[2].'", "'.$date.'")';


	//Inserting data to the database

		mysqli_query($dbconnect, $phLevelSQL);
		
		mysqli_query($dbconnect, $tempLevelSQL);

		mysqli_query($dbconnect, $turbLevelSQL);

	

	
?>