<?php
	include ("../../koneksi.php");
	if(isset($_POST['id_posting']))
	{
		$id_post=$_POST['id_posting'];
		$sql=mysql_query("select * from posting where id_posting='$id_post'");
		if(mysql_num_rows($sql)){
			$isi=mysql_fetch_array($sql);
			$array=array($isi['judul_post'],$isi['isi_post'],$isi['target'],$isi['gambar'],$isi['id_posting']);
			echo json_encode($array);
		}
		else{
			
		}
	}
?>	