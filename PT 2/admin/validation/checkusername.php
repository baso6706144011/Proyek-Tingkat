<?php
	include "../../koneksi.php";
	if(isset($_POST['username']))
	{
	$username = $_POST['username'];

	$sql_check = mysql_query("select id_user from user where id_user='".$username."'") or die(mysql_error());

	if(mysql_num_rows($sql_check))
	{
		echo '<font color="red">username \'<STRONG>'.$username.'</STRONG>\' telah digunakan!.</font>';
	}
	else
	{
		echo 'OK';
	}
	}
	else{
		header('location: ../registrasi.php');
	}
?>