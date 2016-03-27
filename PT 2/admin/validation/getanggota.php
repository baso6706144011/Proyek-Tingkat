<?php
	include ("../../koneksi.php");
	if(isset($_POST['id_grup']) && isset($_POST['id_user']))
	{
		$id_grup=$_POST['id_grup'];
		$id_user=$_POST['id_user'];
		$sql=mysql_query("select nama_grup, user.nama as nama, grup_level, status_keanggotaan from keanggotaan_grup, user, grup where keanggotaan_grup.id_grup='$id_grup' AND keanggotaan_grup.id_user='$id_user' AND user.id_user=keanggotaan_grup.id_user AND keanggotaan_grup.id_grup=grup.id_grup") or die(mysql_error());
		if(mysql_num_rows($sql)>0){
			$isi=mysql_fetch_array($sql);
			$array=array($isi['nama_grup'],$isi['nama'],$isi['grup_level'],$isi['status_keanggotaan']);
			echo json_encode($array);
		}
		else{
			
		}
	}
?>	