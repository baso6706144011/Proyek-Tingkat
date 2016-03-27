<?php
	include('koneksi.php');
	if( isset($_POST['username'])  &&
        isset($_POST['nama'])     &&
        isset($_POST['nis'])     &&
        isset($_POST['password']) &&
        isset($_POST['email'])
      )
    {
        $username   = $_POST['username'];
        $nama      = $_POST['nama'];
        $nis = $_POST['nis'];
        $password = $_POST['password'];
		$email = $_POST['email'];
		$tgl = $_POST['tanggal'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$tipe_user = $_POST['tipe_user'];
		switch($bulan){
			case 'Januari': $bulan='1';break;
			case 'Februari': $bulan='2';break;
			case 'Maret': $bulan='3';break;
			case 'April': $bulan='4';break;
			case 'Mei': $bulan='5';break;
			case 'Juni': $bulan='6';break;
			case 'Juli': $bulan='7';break;
			case 'Agustus': $bulan='8';break;
			case 'September': $bulan='9';break;
			case 'Oktober': $bulan='10';break;
			case 'November': $bulan='11';break;
			case 'Desember': $bulan='12';break;
		}
		$time = $bulan."/".$tgl."/".$tahun;
		$time = strtotime($time);
		$time = date('Y-m-d',$time);
		$sql = mysql_query("insert into user (id_user,nama,password,nis,email,tgl_lahir,tgl_daftar,user_level)
							values ('$username','$nama','$password','$nis','$email','$time',curdate(),$tipe_user);");
		if($sql){
			echo "data berhasil dimasukkan!";
		}
		else{
			echo "gagal!";
		}
    }else{
        header('location: registrasi.php');
    }
?>