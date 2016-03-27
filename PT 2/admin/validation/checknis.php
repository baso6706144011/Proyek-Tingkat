<?php
	include "../../koneksi.php";
	if(isset($_POST['nis']))
	{
	$nis = $_POST['nis'];
	$sql_check = mysql_query("select nis from user where nis='".$nis."'") or die(mysql_error());

	if(mysql_num_rows($sql_check))
	{
		echo '<font color="red">Nomor Induk \'<STRONG>'.$nis.'</STRONG>\' telah digunakan! Periksa lagi.</font>';
	}
	else
	{
		echo 'OK';
	}
}
?>
