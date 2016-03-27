<?php
	include "/../koneksi.php";
	if(isset($_POST['editsubmit']))
	{
		$file="";
		$id_post=$_POST['editsubmit'];
		$judul=$_POST['editjudul'];
		$isi=$_POST['editisi'];
		$target=$_POST['edittujuan'];
		if(!$_FILES['editfile']['size'] == 0){
			$file=basename($_FILES['editfile']["name"]);
			$target_dir = "../images/post/";
			$target_file = $target_dir . $file;
			$path = $_FILES['editfile']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			if (move_uploaded_file($_FILES['editfile']["tmp_name"], $target_file)) {
				$newName=$id_post.".".$ext;
				rename($target_dir.$file,$target_dir.$newName);
				
			}
			else{
				
			}
			$sql=mysql_query("update posting set judul_post = '$judul', isi_post = '$isi', target = '$target', gambar='$newName' where id_posting='$id_post'") or die(mysql_error());
		}
		else{
			$sql=mysql_query("update posting set judul_post = '$judul', isi_post = '$isi', target = '$target' where id_posting='$id_post'") or die(mysql_error());
		}
	}
	
?>	