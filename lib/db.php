<?php
	$user = "root";
	$pass = "";
	$host = "localhost";
	$base = "lifeinmobile";
	$db = mysqli_connect($host, $user, $pass);
	mysqli_select_db($db, $base);
?>