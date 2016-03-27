<!DOCTYPE html>
<?php
	//include('login.php'); // Memasuk-kan skrip Login 
	session_start(); // Memulai Session
	if(isset($_SESSION['login_user'])){
		header("location: beranda.php");
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<title>Log In Admin</title>
	
	<link href="http://fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
</head>
<body>

	<section class="container-fluid">
			<div class="alert text-center" role="alert" id="passwordSalah">
			  
			</div>

			<section class="login-form">
				<form method="POST" role="login" name="form" id="form">
					<section class="form-outer">
						<h2>Login Admin</h2>
						<input type="text" id="username" name="username" placeholder="Username" required class="form-control input-lg" />
						<input type="password" id="password" name="password" placeholder="Password" required class="form-control input-lg" />
						<button type="submit" id="submit" name="submit" class="btn btn-lg btn-block" >Log in</button>
					</section>
					<div class="form-outer">
						<input type="checkbox" name="remember" value="1" /> Remember me
						<a href="#" class="pull-right">Forget Password?</a>
					</div>
				</form>
			</section>
	</section>

	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
	<script type="text/javascript" src="../jquery-1.2.6.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
			$("#form").submit(function(){
				var formTemp=$("#form").serialize();
				$.ajax({
					type: "POST",
					url: "login.php",
					data:  formTemp,
					success: function(msg){
						if(msg=='berhasil'){
							window.location.href = 'beranda.php';
						}
						else{
							$("#passwordSalah").addClass("alert-danger");
							$("#passwordSalah").html('<span><p>Kombinasi username dan password anda salah!</p></span>');
						}
					}
				});
				return false;
			});
		});
	</script>
	
</body>
</html>