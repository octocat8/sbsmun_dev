<?php 
	DEFINE("HOST", "localhost");
	DEFINE("USERNAME", "root");
	DEFINE("PASSWORD", "#whydoIevenbother123");
	DEFINE("DATABASE", "sbsmun");
	$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	if($conn) {
		echo "Yay";
	} else {
		echo "BOOHOO {$conn->errno} : {$conn->error} ";
	}
	
