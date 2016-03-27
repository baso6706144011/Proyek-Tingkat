<?php
	include "../../koneksi.php";
	if(isset($_POST['username']))
	{
		$username = $_POST['username'];
		$sql_check = mysql_query("delete from user where id_user='".$username."'");
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
