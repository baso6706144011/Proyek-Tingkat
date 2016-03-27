<?php
	include('../../koneksi.php');
	if( isset($_POST['username'])  &&
        isset($_POST['nama'])     &&
        isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['tgl']) &&
        isset($_POST['bio'])
      )
    {
        $username   = $_POST['username'];
		$olduser = $_POST['olduser'];
        $nama      = $_POST['nama'];
        $password = $_POST['password'];
		$email = $_POST['email'];
		$bio = $_POST['bio'];
		$time = $_POST['tgl'];
		$time=strtotime($time);
		$time = date('Y-m-d',$time);
		$sql = mysql_query("update user 
							set id_user = '$username', nama = '$nama', password = '$password',
							email='$email', tgl_lahir = '$time', biodata = '$bio'
							where id_user = '$olduser'") or die(mysql_error());
		if($sql){
			echo 'berhasil';
		}
		else{
			echo 'gagal';
		}
    }
	else{
		header('location: beranda.php');
	}
?>