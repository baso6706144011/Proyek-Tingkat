<?php
	include('koneksi.php');
	
	session_start(); // Memulai Session
	$error=''; // Variabel untuk menyimpan pesan error
	if (isset($_POST['submit'])) {
		
		if (empty($_POST['username']) || empty($_POST['password'])) {
				$error = "Username or Password is invalid";
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
			// SQL query untuk memeriksa apakah karyawan terdapat di database?
			$query = mysql_query("select * from user where password='$password' AND id_user='$username'");
			$rows = mysql_num_rows($query);
				if ($rows == 1) {
					$_SESSION['login_user']=$username; // Membuat Sesi/session
					header("location: home.php"); // Mengarahkan ke halaman profil
				} else {
					
				}
					mysql_close($koneksi); // Menutup koneksi
			echo $error;
		}
	}
?>