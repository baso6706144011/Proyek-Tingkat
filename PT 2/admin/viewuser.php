<!DOCTYPE html>
<?php
	include('session.php');
	
	$nama=$user_check;
?>
<html lang="en">

<head>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
	<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
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
                            Lihat User <small>Menu Utama</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="glyphicon glyphicon-user"></i> Lihat User
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable hidden">
							
                        </div>
                    </div>
                </div>
				
                <!-- /.row -->
					<div class="row">
            <div class="col-xs-12 col-lg-10 col-lg-offset-1">
            <div class="panel panel-primary">
				<div class="panel-heading">
					<font size="5">Daftar Guru</font>
				</div>
				<div class="panel-body">  
            <div class="table-responsive">
            	<table id="tblGuru" class="table table-striped table-hover table-bordered bootstrap-datatable datatable responsive" cellspacing="0" width="100%">
        <thead class="bg-info" style="font-weight:bold">
				<tr>
					<td>
                        	#
                        </td>
                    	<td>
                        	Nomor Induk
                        </td>
                        <td>
                        	Nama
                        </td>
                        <td>
                        	Username
                        </td>
                        <td>
                        	Jenis User
                        </td>
						<td class="text-center">
                        	Action
                        </td>
				</tr>
			</thead>
			</tbody>
				<?php
						include "../koneksi.php";
						$query = "select nama_level, nama, nis, id_user from user, level_user where user.user_level=level_user.no AND user.user_level = 2 ORDER BY nama_level;";
						$sql = mysql_query($query);
						$count=0;
						if(mysql_num_rows($sql) == 0){
							echo "<tr>
									<td colspan=\"8\" class=\"bg-default text-center\">Data Siswa Kosong!</td>
								</tr>";
						}
						else{
						while($isi=mysql_fetch_array($sql)){
							$count++;
							echo "<tr>";
							echo "<td>$count</td>";
							echo "<td>{$isi['nis']}</td>";
							echo "<td>{$isi['nama']}</td>";
							echo "<td>{$isi['id_user']}</td>";
							echo "<td>{$isi['nama_level']}</td>";
							
							echo "<td class=\"text-center\">
										<div class=\"btn-group\">
										<form action=\"lihatprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
										</div>
										</form>
										<div class=\"btn-group\">
										<form action=\"editprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
										</div>
										</form>
										<div class=\"btn-group\">
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\" data-id=".$isi['id_user']." onclick=\"test(this.value)\" data-toggle=\"modal\" data-target=\"#deleteModal\">
  <span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> Hapus </button>
										</div>
                        		  </td>";
							echo "</tr>";
						} 
						}
					?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" class="bg-info">
                        	<a href="registrasi.php">
							<button type="button" class="btn btn-success btn-xs pull-right">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            Tambah</button>
							</a>
                        </td>
				</tr>
			</tfoot>
    </table>
			</div>
                </div>
            </div>
			</div>
            <div class="col-xs-12 col-lg-10 col-lg-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<font size="5">Daftar Siswa</font>
				</div>
				<div class="panel-body">          
            <div class="table-responsive">
            	<table id="tblSiswa" class="table table-striped table-hover table-bordered bootstrap-datatable datatable responsive" cellspacing="0" width="100%">
        <thead class="bg-info" style="font-weight:bold">
				<tr>
					<td>
                        	#
                        </td>
                    	<td>
                        	Nomor Induk
                        </td>
                        <td>
                        	Nama
                        </td>
                        <td>
                        	Username
                        </td>
                        <td>
                        	Jenis User
                        </td>
						<td class="text-center">
                        	Action
                        </td>
				</tr>
			</thead>
			</tbody>
				<?php
						include "../koneksi.php";
						$query = "select nama_level, nama, nis, id_user from user, level_user where user.user_level=level_user.no AND user.user_level = 3 ORDER BY nama_level;";
						$sql = mysql_query($query);
						$count=0;
						if(mysql_num_rows($sql) == 0){
							echo "<tr>
									<td colspan=\"8\" class=\"bg-default text-center\">Data Siswa Kosong!</td>
								</tr>";
						}
						else{
						while($isi=mysql_fetch_array($sql)){
							$count++;
							echo "<tr>";
							echo "<td>$count</td>";
							echo "<td>{$isi['nis']}</td>";
							echo "<td>{$isi['nama']}</td>";
							echo "<td>{$isi['id_user']}</td>";
							echo "<td>{$isi['nama_level']}</td>";
							
							echo "<td class=\"text-center\">
										<div class=\"btn-group\">
										<form action=\"lihatprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
										</div>
										</form>
										<div class=\"btn-group\">
										<form action=\"editprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
										</div>
										</form>
										<div class=\"btn-group\">
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\" data-id=".$isi['id_user']." onclick=\"test(this.value)\" data-toggle=\"modal\" data-target=\"#deleteModal\">
  <span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> Hapus </button>
										</div>
								  </td>";
							echo "</tr>";
						} 
						}
					?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" class="bg-info">
                        	<a href="registrasi.php"><button type="button" class="btn btn-success btn-xs pull-right">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            Tambah</button></a>
                        </td>
				</tr>
			</tfoot>
    </table>
                </div>
            </div>
			</div>
        </div>
                <!-- /.row -->

               
                <!-- /.row -->
                   
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	<div class="modal fade" id="deleteModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title text-primary"><span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Delete Posting</strong></h4>
			</div>
			<div class="modal-body" id="deleteBody">
			
			</div>
			<div class="modal-footer">
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<div class ="pull-right">
							<button id="deleteUsername" name="deleteUsername" type="button" value="" class="btn btn-danger">Hapus</button>
							<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
			</div>
		  </div>
		  
		</div>
	</div>

	
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
    <script type="text/javascript">
	var user;
	function test(username){
		user=username;
		$("#deleteBody").html("Anda yakin ingin menghapus user dengan ID "+username+"?");
	}
    $(document).ready(function(){
		$('#tblGuru').DataTable();
		$('#tblSiswa').DataTable();
        $('#deleteUsername').click(function(){
			$.ajax({  
				type: "POST",  
				url: "validation/deleteuser.php",  
				data: "username="+ user,  
				success: function(msg){
				if(msg == 'OK')
				{
					$('.alert').html(msg);
					alert(user+" berhasil dihapus");
					location.reload(true);
				} 
					
				else  
				{  
					alert(user+" gagal dihapus");
					$('.alert').removeClass('hidden');
					$('.alert').attr('data gagal dihapus');
				}  
				} 
			});				
        });
    });
    </script>
</body>

</html>
