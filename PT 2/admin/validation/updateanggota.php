<?php
	include "../../koneksi.php";
	if(isset($_POST['id_grup']) &&
	   isset($_POST['id_user']) &&
	   isset($_POST['grup_level']) &&
	   isset($_POST['status_keanggotaan'])
	)
	{
		$id_grup = $_POST['id_grup'];
		$id_user = $_POST['id_user'];
		$grup_level = $_POST['grup_level'];
		$status = $_POST['status_keanggotaan'];
		
		$sql = mysql_query("update keanggotaan_grup set grup_level=$grup_level,
							status_keanggotaan = $status WHERE
							id_grup='$id_grup' AND id_user='$id_user'") or die(mysql_error());
		if($sql){
			echo 'OK';
		}
		else{
			echo '0';
		}
	}
	
?>	