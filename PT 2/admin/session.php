<?php
	include('../koneksi.php');
	session_start();// Memulai Session
	if(isset($_SESSION['login_user'])){
		$user_check=$_SESSION['login_user'];
		$ses_sql=mysql_query("select nama from user where id_user='$user_check'");
		$row = mysql_fetch_assoc($ses_sql);
		$login_session =$row['nama'];
		if(!isset($login_session)){
			mysql_close($koneksi); // Menutup koneksi
			header('Location: index.php'); // Mengarahkan ke Home Page
		}
	}
	else{
		header('Location: index.php');
	}
?>