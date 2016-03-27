<?php
	include('login.php'); // Memasuk-kan skrip Login 
	 
	if(isset($_SESSION['login_user'])){
		header("location: home.php");
	}
?>
 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		</link>
		</style>
		<body>
			<div id="login-header">
            	<div id="login-logo">
                	<img src="images/logo.png" height="65" width="130">
                </div>
            	<div id="login-menu">
                	<ul>
                    	<li>Masuk</li>
                    	<a href="registrasi.php"><li class="selected">Daftar</li></a>
                    </ul>
                </div>
            </div>
			<div id="kotak">
				<form action="login.php" method="POST">
					<input type="text" name="username" placeholder="Username" required>
					<input type="password" name="password" placeholder="Password" required>
					<input type="submit" name="submit" value="Masuk">
					<br>
					<input id="rememberme" type="checkbox">
					<label for="rememberme">Ingat Saya</label>
					<a href="daftar.html">Lupa Sandi?</a></p>
					</br>
				</form>
			</div>
		</body>
	</head>
</html>