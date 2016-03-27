<?php
	include "../../koneksi.php";
	if(isset($_POST['username']) && isset($_POST['id_grup']))
	{
		$username = $_POST['username'];
		$id_grup = $_POST['id_grup'];
		$sql_check = mysql_query("delete from keanggotaan_grup where id_user='$username' AND id_grup='$id_grup'") or die(mysql_error());
		if(mysql_affected_rows()>0)
		{
			echo 'OK';
		}
		else
		{
			echo '0';
		}
	}
	else{
		header('location: index.php');
	}
?>
