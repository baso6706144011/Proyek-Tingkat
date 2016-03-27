<?php
	include "../../koneksi.php";
	if(isset($_POST['id_grup']))
	{
		$id_grup = $_POST['id_grup'];
		$sql_check = mysql_query("delete from grup where id_grup='".$id_grup."'");

		if(mysql_affected_rows()>0)
		{
			echo 'OK';
			$sql_check = mysql_query("delete from keanggotaan_grup where id_grup='".$id_grup."'");
			$sql_check = mysql_query("delete from materi where id_grup='".$id_grup."'");
			$sql_check = mysql_query("delete from tugas where id_grup='".$id_grup."'");
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