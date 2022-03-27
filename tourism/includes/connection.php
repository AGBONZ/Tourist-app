<?php 
	
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "tourism";

	$connect2db = new PDO("mysql:dbname=$dbname; host=$host", $username, $password);
	if($connect2db){
			//echo 'connected';
		
	}

?>