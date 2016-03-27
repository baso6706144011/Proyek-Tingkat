<?php
	include ('/../koneksi.php');
	if(isset($_POST['btnupload']) && !empty($_FILES['file']['name'])){
		$target_dir = "../images/profil/";
		$namafile=$_POST['btnupload'];
		$target_file = $target_dir . basename($_FILES['file']["name"]);
		if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
			
			$path = $_FILES['file']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$newName=$namafile.".".$ext;
			rename($target_dir . basename($_FILES['file']["name"]),$target_dir.$newName);
			$sql=mysql_query("update user set foto = '$newName' where id_user='$namafile'") or die(mysql_error());
		} else {
			
		}
	}
?>