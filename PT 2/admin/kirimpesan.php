<?php
	include "../koneksi.php";
	if(isset($_POST['username']) && isset($_POST['tujuan']) && isset($_POST['isi'])){
		$username=$_POST['username'];
		$tujuan=$_POST['tujuan'];
		$isipesan = addslashes($_POST['isi']);
		$sql=mysql_query("select user_level from user where id_user='$username'") or die(mysql_error());
		$isi=mysql_fetch_array($sql);
		if($isi){
			$levelUser=$isi['user_level'];
			if($levelUser==1)
				$username='';
		}
		$sql=mysql_query("select user_level from user where id_user='$tujuan'") or die(mysql_error());
		$isi=mysql_fetch_array($sql);
		if($isi){
			$levelPartner=$isi['user_level'];
			if($levelPartner==1)
				$tujuan='';
		}
		$sql=mysql_query("INSERT INTO pesan (id_pesan, id_pengirim, id_penerima, waktu_kirim, isi_pesan, status) VALUES (NULL, '$username', '$tujuan', now(), '$isipesan', '0');") or die(mysql_error());
		if($sql){
			echo 'berhasil';
		}
		else{
			echo 'gagal';
		}
	}
	else{
		echo 'gada coy';
	}
?>