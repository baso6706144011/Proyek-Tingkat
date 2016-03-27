<?php
	include "../koneksi.php";
	
	$username = '12345678';
	$sql_check = mysql_query("delete from user where id_user='".$username."'");

	if(mysql_affected_rows()>0)
	{
		echo 'OK';
	}
	else
	{
		echo '0';
	}
?>