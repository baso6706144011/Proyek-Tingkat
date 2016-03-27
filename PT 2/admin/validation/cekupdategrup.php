<?php
	include('../../koneksi.php');
	if( isset($_POST['id_grup'])  &&
	isset($_POST['namagrup'])  &&
	isset($_POST['mapel'])  &&
	isset($_POST['deskripsi']))
    {
        $id_grup = $_POST['id_grup'];
        $namagrup = $_POST['namagrup'];
        $mapel = $_POST['mapel'];
        $deskripsi = $_POST['deskripsi'];
		$sql = mysql_query("update grup 
							set nama_grup = '$namagrup',
							mata_pelajaran = '$mapel', deskripsi = '$deskripsi'
							where id_grup = '$id_grup'") or die(mysql_error());
		if($sql){
			echo 'berhasil';
		}
		else{
			echo 'gagal';
		}
    }
	else{
		header('location: editprofiluser.php');
	}
?>