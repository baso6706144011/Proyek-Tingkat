<?php
	include "/../koneksi.php";
	if(isset($_POST['submit']))
	{
		$file="";
		$poster=$_POST['submit'];
		$judul=$_POST['judul'];
		$isi=$_POST['isi'];
		$target=$_POST['tujuan'];
		$cek=false;
		if(!$_FILES['file']['size'] == 0){
			$cek=true;
			$file=basename($_FILES['file']["name"]);
			$target_dir = "../images/post/";
			$target_file = $target_dir . $file;
			$path = $_FILES['file']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
				
			}
			else{
				
			}
		}
		
		$sql=mysql_query("insert into posting(id_posting,judul_post, id_poster,isi_post, gambar, target) values(NULL,'$judul', '$poster', '$isi', '$file',$target)") or die(mysql_error());
		if($sql){
			$id=mysql_insert_id();
			if($cek){
				$newName=$id.".".$ext;
				rename($target_dir.$file,$target_dir.$newName);
				$sql=mysql_query("update posting set gambar='$newName' where id_posting='$id'");
			}
		}
	}
?>	