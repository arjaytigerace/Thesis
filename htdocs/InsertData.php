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
	$phLevelSQL = 'INSERT INTO arduino_thesis.phsensor (`phLevel`,`dateRet`) VALUES ("'.$read[0].'", "'.$date.'")';

	$tempLevelSQL = 'INSERT INTO arduino_thesis.tempsensor (`tempLevel`,`dateRet`) VALUES ("'.$read[1].'", "'.$date.'")';

	$turbLevelSQL = 'INSERT INTO arduino_thesis.turbidity (`turbLevel`,`dateRet`) VALUES ("'.$read[2].'", "'.$date.'")';


	//Inserting data to the database

		mysqli_query($dbconnect, $phLevelSQL);
		
		mysqli_query($dbconnect, $tempLevelSQL);

		mysqli_query($dbconnect, $turbLevelSQL);

	

	echo "HELLO KARL -- PASS ME THE DATA PLEASE :-)";
?>