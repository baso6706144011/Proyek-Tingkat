<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "pt_2";
	$koneksi = mysql_connect($host, $username, $password);
	$select_db = mysql_select_db($database, $koneksi);
?>