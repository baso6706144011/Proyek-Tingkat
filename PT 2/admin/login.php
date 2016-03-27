<?php
	include('../koneksi.php');
	session_start(); // Memulai Session
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			echo "Username or Password is invalid";
		}
		else
		{
			// Variabel username dan password
			$username=$_POST['username'];
			$password=$_POST['password'];
			// Mencegah MySQL injection 
			$username = stripslashes($username);
			$password = stripslashes($password);
			$username = mysql_real_escape_string($username);
			$password = mysql_real_escape_string($password);
			$username = trim($username);
			// Seleksi Database
			$query = mysql_query("select * from user where password='$password' AND id_user='$username' AND user_level=1");
			$rows = mysql_num_rows($query);
				if ($rows == 1) {
					$_SESSION['login_user']=$username; // Membuat Sesi/session
					//header("location: beranda.php"); // Mengarahkan ke halaman profil
					echo 'berhasil';
				} else {
					echo 'gagal';
				}
					mysql_close($koneksi); // Menutup koneksi
		}
	}
?>