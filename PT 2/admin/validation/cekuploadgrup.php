<?php
	include ('/../koneksi.php');
	if(isset($_POST['btnupload']) && !empty($_FILES['file']['name'])){
		$target_dir = "../images/grup/";
		$namafile=$_POST['btnupload'];
		$target_file = $target_dir . basename($_FILES['file']["name"]);
		if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
			$path = $_FILES['file']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$newName=$namafile.".".$ext;
			rename($target_dir . basename($_FILES['file']["name"]),$target_dir.$newName);
			$sql=mysql_query("update grup set foto_grup = '$newName' where id_grup='$namafile'") or die(mysql_error());
		} else {
			
		}
	}
?>