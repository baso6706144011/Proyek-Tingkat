<?php
	include('../../koneksi.php');
	if( isset($_POST['username'])  &&
        isset($_POST['nama'])     &&
        isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['tgl'])
      )
    {
		
        $username   = $_POST['username'];
        $nama      = $_POST['nama'];
        $password = $_POST['password'];
		$email = $_POST['email'];
		$time = $_POST['tgl'];
		$time=strtotime($time);
		$time = date('Y-m-d',$time);
		$foto = "../images/profil/avatar.png";
		$sql = mysql_query("insert into user (id_user,nama,password,email,tgl_lahir,tgl_daftar,foto,user_level)
							values ('$username','$nama','$password','$email','$time',curdate(),'$foto',1);") or die(mysql_error());
		if($sql){
			echo 'berhasil';
		}
		else{
			echo 'gagal';
		}
    }
	else{
		header('location: tambahadmin.php');
	}
?>