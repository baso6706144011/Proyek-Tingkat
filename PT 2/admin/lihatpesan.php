<!DOCTYPE html>
<?php
	include('session.php');
	$nama=$user_check;
	$id_pengirim="";
	if(!isset($_GET['id'])){
		$sql=mysql_query("select id_pengirim, id_penerima from pesan where (id_pengirim='' or id_penerima = '') order by waktu_kirim desc limit 1;");
		$isi=mysql_fetch_array($sql);
		if($isi){
			//$id_pengirim=$isi['id_pengirim'];
			if($isi[id_penerima]=='')
			header('location: lihatpesan.php?id='.$isi['id_pengirim']);
			else
			header('location: lihatpesan.php?id='.$isi['id_penerima']);
		}
	}
	else{
		$id_pengirim=$_GET['id'];
		$sql=mysql_query("select * from pesan where (id_pengirim='$id_pengirim' and id_penerima='') or (id_penerima='$id_pengirim' and id_pengirim='')");
		if(!mysql_num_rows($sql)){
			header('location: lihatpesan.php');
		}
	}
	if($id_pengirim!=""){
		$sql=mysql_query("update pesan set status=1 where id_pengirim='$id_pengirim' and id_penerima=''");
	}
	else{
		//header('location: beranda.php');
	}
	function time_elapsed_string($datetime, $full = false) {
			date_default_timezone_set('Asia/Jakarta');
			$now = new DateTime;
			$ago = new DateTime($datetime);
			$diff = $now->diff($ago);

			$diff->w = floor($diff->d / 7);
			$diff->d -= $diff->w * 7;

			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'minute',
				's' => 'second',
			);
			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}

			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>On-Learning Admin</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<script src="js/time.js"></script>

		<!-- (Optional) Latest compiled and minified JavaScript translation files -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	 <script src="js/time.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="beranda.php">On-Learning Admin</a>
            </div>
            <!-- Top Menu Items -->
            <?php
			$sql=mysql_query("select count(*) as jumlah_notif from pesan where id_penerima='' AND status=0;");
			$isi=mysql_fetch_array($sql);
			$count=$isi['jumlah_notif'];
			
			$sql=mysql_query("select * from pesan as q where waktu_kirim=(select max(waktu_kirim) from pesan where (id_pengirim=q.id_pengirim and id_penerima='')) OR waktu_kirim=(select max(waktu_kirim) from pesan where (id_penerima=q.id_penerima and id_pengirim='')) ORDER BY waktu_kirim DESC;") or die(mysql_error());
			?>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i>&nbsp;<span class="badge" style="background-color:#269abc"><?php echo $count?></span><b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <?php
							
							$arrayPartner=array();
							$jumlah=0;
							while($isi=mysql_fetch_array($sql)){
								if($jumlah<3){
								$id_pesan=$isi['id_pesan'];
								$pengirim=$isi['id_pengirim'];
								$penerima=$isi['id_penerima'];
								$isichat=$isi['isi_pesan'];
								$waktu_kirim=$isi['waktu_kirim'];
								$status=$isi['status'];
								if($pengirim==""){
									$partner=$penerima;
								}
								else{
									$partner=$pengirim;
								}
								if(!in_array($partner, $arrayPartner)){
									
									array_push($arrayPartner, $partner);
									$jumlah=count($arrayPartner);
									$sql1=mysql_query("select nama from user where id_user='$partner'");
									$isi1=mysql_fetch_array($sql1);
									$namauser=$isi1['nama'];
						?>
						<li class="message-preview" <?php if($status==0) echo "style=\"-color:#F0F0F0;\"";?>>
                            <a href=<?php echo "lihatpesan.php?id=".$partner;?>>
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src=" " alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
											<strong>
													<?php echo $namauser;?>
													<?php 
															$sql1=mysql_query("select count(*) as jumlah from pesan where id_pengirim='$partner' and status=0");
															$isi1=mysql_fetch_array($sql1);
															if($isi1['jumlah']!=0) {
																echo "<span class=\"badge\" style=\"background-color:#269abc\">";
																echo $isi1['jumlah'];
																echo "</span>";
															}
													?>
											</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i>
										<script>
											startLive = new Date(<?php echo strtotime($waktu_kirim. ' GMT+0700')*1000;?>);
											document.write(timeDifference(new Date(), startLive));
										</script>
										</p>
                                        <p>
											<?php
												if(strlen($isichat)<=50)
													echo $isichat ;
												else{
													echo substr($isichat,0,50)."... <strong><font color=\"blue\">[Selengkapnya]</font></strong>";
												}
											?>
										</p>
                                    </div>
                                </div>
                            </a>
                        </li>
						
						<?php
									}
								}
							}
						?>
                        <li class="message-footer">
                            <a href="lihatpesan.php">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php
													echo $nama;
												?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profil.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="lihatpesan.php"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Beranda</a>
                    </li>
                    <li class="active">
                        <a href="viewuser.php"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Lihat User</a>
                    </li>
                    <li>
                        <a href="registrasi.php"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;Tambah User</a>
                    </li>
                    <li>
                        <a href="viewgroup.php"><i class="glyphicon glyphicon-tasks"></i>&nbsp;&nbsp;Lihat Grup</a>
                    </li>
					<li>
                        <a href="tambahadmin.php"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Tambah Admin</a>
                    </li>
					<li>
                        <a href="posting.php"><i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Posting Informasi</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Lihat Pesan <small>Menu Utama</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="glyphicon glyphicon-envelope"></i> Messaging
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row 

                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                        </div>
                    </div>
                </div>
				
				-->
                <!-- /.row -->
				<div class="row">
		<div class="col-lg-5 col-md-5 col-sm-5">
                <div class="panel panel-primary" >
					<div class="panel-heading text-center">
					<div class="pull-left">
						<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
					</div>
					<span class="panel-title" id="countChat">
                        List Chat (0)
                    </span>
					<div class="pull-right">
					<span class="panel-title btn-group">
                        <button type="button" onclick="refreshList()" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </span>
					</div>
                        
					</div>
                    <div class="panel-body chat-box-new" id="panellist">
						<ul class="chat" id="listchat">
							
						</ul>
                    </div>

                </div>

            </div>
        <div class="col-md-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
                        <button type="button" onclick="refreshChat()" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </div>
                </div>
                <div class="panel-body" id="isichat">
                    
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-warning btn-sm" id="btn-chat">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">
							
							  <!-- Modal content-->
							  <div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal">&times;</button>
								  <h4 class="modal-title text-primary"><span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Pesan Baru</strong></h4>
								</div>
								<div class="modal-body">
									<form class="form-horizontal" role="form" id="formKu">
										<div class="form-group">
											<label for="name" class="col-sm-2 control-label">Tujuan</label>
											<div class="col-sm-10">
												<select class="form-control selectpicker" id="name" data-live-search="true">
													<option>- Pilih Tujuan -</option>
													<?php
															$username=$nama;
															$sql=mysql_query("select user_level from user where id_user='$username'");
															$isi=mysql_fetch_array($sql);
															$level = $isi['user_level'];
															$sql1=mysql_query("select nama, nis, id_user from user where id_user != '$username' AND user_level!=1");
															if($level!=1){
													?>
																<option value="" class="text-center">- Admin On-Learning -</option>
													<?php
															}
															while($isi1=mysql_fetch_array($sql1)){
																$namanya=$isi1['nama'];
																$nis=$isi1['nis'];
																$id_user=$isi1['id_user'];
													?>
															<option value="<?php echo $id_user;?>">
																	<?php echo $namanya;?>
															</option>
													<?php
															
															}
													?>
												 </select>
											</div>
										</div>
										<div class="form-group">
											<label for="message" class="col-sm-2 control-label">Message</label>
											<div class="col-sm-10">
												<textarea class="form-control" rows="4" name="message" id="message" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10 col-sm-offset-2">
												<div class ="pull-right">
												<button id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">Send</button>
												<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
												</div>
											</div>
										</div>
									</form> 
								</div>
							  </div>
							  
							</div>
						  </div>

			</div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Morris Charts JavaScript -->

	<script type="text/javascript" src="../jquery-1.2.6.min.js"></script>
	<script type="text/javascript">
		var tujuan="<?php echo $id_pengirim?>";
		
		function refreshChat(){
			clickMe(tujuan);
		}
		setInterval(function refreshList(){
			listchat(tujuan);
			clickMe(tujuan);
		},10000);
		function clickMe(username){
			var nama="<?php echo $nama?>";
			$("#"+tujuan).removeClass("bg-info");
			$("#"+username).addClass("bg-info");
			tujuan=username;
			isichat(nama, username);
		}
		function listchat(username){
			$.ajax({
				type: "POST",
				url: "kirim.php",
				data: {username : username},
				success: function(msg){
					var n = msg.split(" ");
					var count = n[n.length - 1];
					$('#countChat').text("List Chat "+count);
					var lastIndex = msg.lastIndexOf(" ");
					msg = msg.substring(0, lastIndex);
					document.getElementById('listchat').innerHTML=msg;
				}
			});
		}
		function isichat(username, tujuan){
			//$("#isichat").html('<div class="text-center"><img src="../images/loader.gif" align="absmiddle">&nbsp;Loading</div>');
			$.ajax({
				type: "POST",
				url: "isipesan.php",
				data: {username : username, tujuan : tujuan},
				success: function(msg){
					document.getElementById('isichat').innerHTML=msg;
					ChangeUrl('lihatpesan','lihatpesan.php?id='+tujuan);
				}
			});
		}
		function ChangeUrl(title, url) {
			if (typeof (history.pushState) != "undefined") {
				var obj = { Title: title, Url: url };
				history.pushState(obj, obj.Title, obj.Url);
			} else {
				alert("Browser does not support HTML5.");
			}
		}
		function kirimChat(isi){
			var username="<?php echo $nama?>";
			if(isi!=""){
				$.ajax({
					type: "POST",
					url: "kirimpesan.php",
					data: {username : username, tujuan : tujuan, isi : isi},
					success: function(msg){
						if(msg=='berhasil'){
							refreshChat();
							$("#btn-input").val('');
						}
						else{
							alert('gagal');
						}
					}
				});
			}
		}
		$(document).ready(function(){
			
			listchat(tujuan);
			clickMe(tujuan);
			var posisi=$("#name")[0].selectedIndex;
			$("#name").change(function(){
				posisi=$("#name")[0].selectedIndex;
			});
			$("#formKu").submit(function(){
				if(posisi==0){
					alert('Pilih Tujuan terlebih dahulu!');
				}
				else{
					document.getElementById(tujuan).className = "";
					document.getElementById(tujuan).className = "left clearfix";
					tujuan=$("#name").val();
					kirimChat($("#message").val());
					$('#myModal').modal('hide');
				}
				return false;
			});
			$("#btn-input").keyup(function (e) {
				if (e.keyCode == 13) {
					kirimChat($("#btn-input").val());
				}
			});
			$("#btn-chat").click(function(){
				kirimChat($("#btn-input").val());
			});
		});
	</script>
</body>

</html>
