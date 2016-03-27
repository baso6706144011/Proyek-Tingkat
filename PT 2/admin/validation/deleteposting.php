<?php
	include "../../koneksi.php";
	if(isset($_POST['id_posting']))
	{
		$id_post = $_POST['id_posting'];
		$sql_check = mysql_query("delete from posting where id_posting='".$id_post."'");
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