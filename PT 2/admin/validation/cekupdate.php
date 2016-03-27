<?php
	include('../../koneksi.php');
	if( isset($_POST['username'])  &&
        isset($_POST['nama'])     &&
        isset($_POST['nis'])     &&
        isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['tgl']) &&
		isset($_POST['tipe_user']) &&
		isset($_POST['bio'])
      )
    {
        $username   = $_POST['username'];
		$olduser = $_POST['olduser'];
        $nama      = $_POST['nama'];
        $nis = $_POST['nis'];
        $password = $_POST['password'];
		$email = $_POST['email'];
		$tipe_user = $_POST['tipe_user'];
		$bio = $_POST['bio'];
		$time = $_POST['tgl'];
		$time=strtotime($time);
		$time = date('Y-m-d',$time);
		$sql = mysql_query("update user 
							set id_user = '$username', nama = '$nama',
							nis = '$nis', password = '$password',
							email='$email', tgl_lahir = '$time', user_level = '$tipe_user',
							biodata='$bio'
							where id_user = '$olduser'") or die(mysql_error());
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