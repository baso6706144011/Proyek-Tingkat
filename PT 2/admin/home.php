<?php
	include('session.php');
?>
<html>
	<head>
	  <title>Halaman Awal</title>
	  <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
	</head>
<body>
	<div id="profile">
	  <b id="welcome">Selamat Datang : <i><?php echo $user_check; ?></i></b>
	  <b id="logout"><a href="logout.php">Log Out</a></b>
	</div>
</body>
</html>