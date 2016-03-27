<?php
	include('../../koneksi.php');
	if( isset($_POST['username'])  &&
        isset($_POST['nama'])     &&
        isset($_POST['nis'])     &&
        isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['tgl']) &&
		isset($_POST['tipe_user'])
      )
    {
		
        $username   = $_POST['username'];
        $nama      = $_POST['nama'];
        $nis = $_POST['nis'];
        $password = $_POST['password'];
		$email = $_POST['email'];
		$tipe_user = $_POST['tipe_user'];
		$time = $_POST['tgl'];
		$time=strtotime($time);
		$time = date('Y-m-d',$time);
		$foto = "../images/profil/avatar.png";
		$sql = mysql_query("insert into user (id_user,nama,password,nis,email,tgl_lahir,tgl_daftar,foto,user_level)
							values ('$username','$nama','$password','$nis','$email','$time',curdate(),'$foto',$tipe_user);") or die(mysql_error());
		if($sql){
			echo 'berhasil';
		}
		else{
			echo 'gagal';
		}
    }
	else{
		header('location: registrasi.php');
	}
?>