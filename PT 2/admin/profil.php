<!DOCTYPE html>
<?php
	include('session.php');
	include('validation/cekupload.php');

	$nama=$user_check;
	$sql=mysql_query("select foto, nama, id_user, 
					email, tgl_lahir, biodata, password from user
					where id_user='$nama' and user_level=1");
	$isi=mysql_fetch_array($sql);
	$foto=$isi['foto'];
	$namaadmin=$isi['nama'];
	$username=$isi['id_user'];
	$password=$isi['password'];
	$tgl_lahir=$isi['tgl_lahir'];
	$email=$isi['email'];
	$biodata=$isi['biodata'];
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>On-Learning Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                    <li>
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

			  <h1 class="page-header">Edit Profil Admin</h1>
			  <div class="row">
				<!-- left column -->
				<div class="col-md-4 col-sm-6 col-xs-12">
				  <div class="text-center">
					<img src="<?php echo "../images/profil/".$foto; ?>" class="avatar img-thumbnail img-responsive img-rounded" alt="avatar" height="300" width="300">
				 </div>
				</div>
				<!-- edit form column -->
				<div class="col-md-8 col-sm-6 col-xs-12 personal-info">
				<div class="alert hidden alert-dismissable text-center" id="alertnya">
				<a class="panel-close close" data-dismiss="alert">×</a> 
				<i class="fa fa-coffee"></i>

				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<font size="5">Personal Info</font>
					</div>
					<div class="panel-body">
				  <form action="editprofil.php" class="form-horizontal" role="form" id="form" name="form" method="POST">
					<div class="form-group">
					  <label class="col-lg-3 control-label">Nama</label>
					  <div class="col-lg-8">
						<input class="form-control" value="<?php echo $namaadmin;?>" type="text" id="nama" name="nama" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-lg-3 control-label">Username</label>
					  <div class="col-lg-8">
						<input class="form-control" value="<?php echo $username;?>" type="text" id="username" name="username" readonly>
						<span class="help-block" id="status">Username minimal 6 digit karakter</span>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Password</label>
					  <div class="col-md-8">
						<input class="form-control" value="<?php echo $password; ?>" type="password" id="password" name="password" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Email</label>
					  <div class="col-md-8">
						<input class="form-control" value="<?php echo $email;?>" id="email" name="email" type="text" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Tanggal Lahir</label>
					  <div class="col-md-8">
						<input type="date" name="tgl" id="tgl" value="<?php echo $tgl_lahir;?>" class="form-control" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Biodata</label>
					  <div class="col-md-8">
						<textarea rows="3" size="30" value="<?php echo $biodata;?>" class="form-control" readonly><?php echo $biodata;?></textarea> 
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label"></label>
					  <div class="col-md-8">
						<input class="btn btn-primary" value="Edit" type="submit" name="edit" id="edit">
						<span></span>
						
						<a href="beranda.php"><input type="button" class="btn btn-default" value="Back" id="back" name="back"></a>
						
					  </div>
					</div>
				  </form>
				  </div>
				</div>
				</div>
			  </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
	
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
