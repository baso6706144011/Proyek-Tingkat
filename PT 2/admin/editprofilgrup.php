<!DOCTYPE html>
<?php
	include('session.php');
	include('validation/cekuploadgrup.php');
	if(!isset($_GET['id'])){
		header('location: viewgroup.php');
	}
	$nama=$user_check;
	$id_grup=$_GET['id'];
	$sql1=mysql_query("select  nama_grup, mata_pelajaran, foto_grup, deskripsi, tgl_buat,
					user.nama as pembuat, user.nis as nis from user, grup where 
					user.id_user=grup.user_pembuat AND grup.id_grup=$id_grup;") or die(mysql_error());
	$isi=mysql_fetch_array($sql1);
	if(!$isi){
		header('location: viewgroup.php');
	}
	$namagrup=$isi['nama_grup'];
	$mapel=$isi['mata_pelajaran'];
	$foto=$isi['foto_grup'];
	$deskripsi=$isi['deskripsi'];
	$tgl=$isi['tgl_buat'];
	$pembuat=$isi['pembuat'];
	$nis=$isi['nis'];
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
                    <li class="active">
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

			  <h1 class="page-header">Lihat Profil Grup</h1>
			  <div class="row">
				<!-- left column -->
				<div class="col-md-4 col-sm-6 col-xs-12">
				  <div class="text-center">
					<img src="<?php echo "../images/grup/".$foto; ?>" class="avatar img-thumbnail img-responsive img-rounded" alt="../images/grup/avatar.png" height="300" width="300">
					<h6>Upload a different photo...</h6>
					<form method="POST" enctype="multipart/form-data" id="formupload">
						<div class ="form-group">
							<input type="file" id="file" name="file" class="text-center center-block well well-sm">
						</div>
						<div class ="form-group">
							<button type="submit" class="btn btn-primary" id="btnupload" name="btnupload" value="<?php echo $id_grup;?>">Upload</button>
						</div>
					</form>
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
							<font size="5">Grup info</font>
							
						</div>
						<div class="panel-body">
										  
				  
				  <form class="form-horizontal" role="form" id="form" name="form">
					<div class="form-group">
					  <label class="col-lg-3 control-label">ID Grup</label>
					  <div class="col-lg-8">
						<input class="form-control" value="<?php echo $id_grup;?>" type="text" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-lg-3 control-label">Nama Grup</label>
					  <div class="col-lg-8">
						<input class="form-control" id="namagrup" value="<?php echo $namagrup;?>" type="text">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-lg-3 control-label">Mata Pelajaran</label>
					  <div class="col-lg-8">
						<input class="form-control" id="mapel" value="<?php echo $mapel;?>" type="text">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Pembuat</label>
					  <div class="col-md-8">
						<input class="form-control" value="<?php echo $pembuat." (".$nis.")";?>" type="text" readonly>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Tanggal Pembuatan</label>
					  <div class="col-md-8">
						<input type="date" name="date" id="date" value="<?php echo $tgl;?>" class="form-control" disabled>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label">Deskripsi</label>
					  <div class="col-md-8">
						<textarea id="deskripsi" rows="3" size="30" value="<?php echo $deskripsi;?>" class="form-control"><?php echo $deskripsi;?></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-3 control-label"></label>
					  <div class="col-md-8">
					   
						<button type="submit" class="btn btn-primary" value="<?php echo $id_grup;?>" id="submit" name="submit">Save</button>
					   
						<span></span>
						<a href="viewuser.php">
						<input type="button" class="btn btn-default" id="back" value="Cancel">
						</a>
					  </div>
					</div>
				  </form>
				  </div>
				</div>
				  
				<div class="panel panel-primary">
					<div class="panel-heading">
						<font size="5">Anggota Grup</font>
					</div>
					<div class="panel-body">
						
				  <div class="table-responsive">
            	<table id="tblGroup" class="table table-striped table-hover table-bordered bootstrap-datatable datatable responsive" cellspacing="0" width="100%">
        <thead class="bg-info">
				<tr>
					<td>
                        	#
                        </td>
                    	<td>
                        	NIS
                        </td>
                        <td>
                        	Nama
                        </td>
                        <td>
                        	Jenis
                        </td>
                        <td>
                        	Status
                        </td>
						<td width="15%">
                        	Tanggal Bergabung
                        </td>
						<td class="text-center">
                        	Action
                        </td>
				</tr>
			</thead>
			</tbody>
				<?php
						include "../koneksi.php";
						$query = "select keanggotaan_grup.id_user as id_user, user.nama as nama, user.nis as nis,level_grup.nama_level as level, 
								status_keanggotaan, tgl_bergabung from keanggotaan_grup,user,level_grup where keanggotaan_grup.id_grup=$id_grup 
								AND keanggotaan_grup.id_user=user.id_user and keanggotaan_grup.grup_level=level_grup.no;";
								
								
						$sqllagi = mysql_query($query) or die(mysql_error());
						$count=0;
						if(mysql_num_rows($sqllagi) == 0){
							echo "<tr>
									<td colspan=\"8\" class=\"bg-default text-center\">Data Anggota Kosong!</td>
								</tr>";
						}
						else{
						while($isi=mysql_fetch_array($sqllagi)){
							$count++;
							echo "<tr>";
							echo "<td>$count</td>";
							echo "<td>{$isi['nis']}</td>";
							echo "<td>{$isi['nama']}</td>";
							echo "<td>{$isi['level']}</td>";
							if($isi['status_keanggotaan']==0){
								echo "<td class=\"btn-warning\"><span class=\"glyphicon glyphicon-time\"></span>&nbsp;&nbsp;Pending</td>";
							}
							else if($isi['status_keanggotaan']==1){
								echo "<td class=\"btn-success\"><span class=\"glyphicon glyphicon-ok\"></span>&nbsp;&nbsp;Aktif</td>";
							}
							else if($isi['status_keanggotaan']==2){
								echo "<td class=\"btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span>&nbsp;&nbsp;Terblokir</td>";
							}
							else{
								
							}
							echo "<td>
										{$isi['tgl_bergabung']}
                        		  </td>";
							echo "<td class=\"text-center\">
									<div class=\"btn-group\">
										<div class=\"btn-group\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-info btn-xs editBtn pull-right\" onclick=\"editanggota(this.value)\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit</button>
										</div>
										<div class=\"btn-group\">
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\" data-id=".$isi['id_user']." onclick=\"deleteanggota(this.value)\" data-toggle=\"modal\" data-target=\"#deleteModal\">
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
					
				</tr>
			</tfoot>
    </table>
                </div>
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
	
	<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title text-primary"><span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Edit Keanggotaan Grup</strong></h4>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" autocomplete="off" role="form" id="editform" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label for="namagrup" class="col-sm-2 control-label">Grup</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="namagrup1" id="namagrup1" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="anggota" class="col-sm-2 control-label">Anggota</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="anggota" id="anggota" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="tipe_user" class="col-lg-2 control-label">Tipe Anggota</label>
						<div class="col-lg-10">
							<select class="form-control" name="tipe_user" id="tipe_user">
								<option value="1">Admin</option>
								<option value="2">User</option>
							</select>
						</div>
				</div>
				<div class="form-group">
					<label for="tipe_user" class="col-lg-2 control-label">Status Anggota</label>
						<div class="col-lg-10">
							<select class="form-control" name="statusanggota" id="statusanggota">
								<option value="0">Pending</option>
								<option value="1">Aktif</option>
								<option value="2">Terblokir</option>
							</select>
						</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<div class ="pull-right">
						<button id="editsubmit" name="editsubmit" type="submit" value="" class="btn btn-primary">Update</button>
						<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</form> 
		</div>
	  </div>
	  
	</div>
	</div>
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
							<button id="deleteAnggota" name="deleteAnggota" type="button" value="" class="btn btn-danger">Hapus</button>
							<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
			</div>
		  </div>
		  
		</div>
	</div>
    <!-- jQuery -->
     <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
	var user;
	var grup="<?php echo $id_grup;?>";
	function deleteanggota(username){
		user=username;
		$("#deleteBody").html("Anda yakin ingin menghapus user dengan ID "+username+" dari grup ini?");
	}
	function editanggota(username){
		user=username;
	}
    $(document).ready(function(){
		$('#tblGroup').DataTable();
		$(".editBtn").on("click", function(){
			$("#editModal").modal();
			$.ajax({  
				type: "POST",  
				url: "validation/getanggota.php",  
				data: {id_grup:grup, id_user:user}, 
				dataType: 'json',
				cache: false,
				success: function(result){
					$('#namagrup1').val(result[0]);
					$('#anggota').val(result[1]);
					$('#tipe_user option[value='+result[2]+']').attr('selected','selected');
					$('#statusanggota option[value='+result[3]+']').attr('selected','selected');
				}
			});
		});
		$('#editform').submit(function(){
			var status = $('#statusanggota').val();
			var tipe = $('#tipe_user').val();
			$.ajax({
				type: "POST",
				url: "validation/updateanggota.php",
				data: {id_grup:grup, id_user:user, status_keanggotaan:status, grup_level:tipe},
				success: function(msg){
					if(msg == 'OK'){
						alert('Update Anggota Grup Berhasil!');
						location.reload(true);
					}
					else{
						alert('Update Anggota Grup gagal!');
					}
				}
			});
			return false;
		});
		$('#deleteAnggota').click(function(){
			$.ajax({  
				type: "POST",  
				url: "validation/deleteanggota.php",
				data: {username : user, id_grup : grup},
				success: function(msg){
				if(msg == 'OK')
				{
					$('.alert').html(msg);
					alert(user+" berhasil dihapus dari grup");
					location.reload(true);
				} 
					
				else  
				{  
					alert(user+" gagal dihapus dari grup");
					$('.alert').removeClass('hidden');
					$('.alert').attr('data gagal dihapus');
				}  
				} 
			});	
			return false;
		});
		$('#file').bind('change', function() {
			cekFile=false;
			if(this.files[0].size > 1048576){
				alert('Ukuran file tidak boleh melebihi 1 MB!');
				cekFile=false;
				$('#file').replaceWith($('#file').val('').clone(true));
			}
			else{		
				var allowed_extensions = new Array("jpg","png","gif");
				var file_extension = $('#file').val().split('.').pop().toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.
				if(jQuery.inArray(file_extension, allowed_extensions) !== -1)
				{
					cekFile=true; // valid file extension
				}
				if(!cekFile){
					alert('File harus berupa gambar!');
					$('#file').replaceWith($('#file').val('').clone(true));
					cekFile=false;
				}
			}
		});
		
		$('#back').click(function(){
			var c = confirm('Anda yakin ingin membatalkan?');
			if(c==true){
				window.location.href = 'viewgroup.php';
			}
			else{
				return false;
			}
		});
		
		$("#formupload").submit(function(){
			if(document.getElementById("file").files.length == 0 ){
				$("#alertnya").removeClass("alert-success");
				$("#alertnya").removeClass("hidden");
				$("#alertnya").addClass("alert-warning");
				$("#alertnya").html('Pilih Foto terlebih dahulu!');
				return false;
			}
		});
		
		$("#form").submit(function() {
			
				var id_grup = "<?php echo $id_grup;?>";
				var namagrup = $('#namagrup').val();
				var mapel = $('#mapel').val();
				var deskripsi = $('#deskripsi').val();
				$.ajax({
					type: "POST",
					url: "validation/cekupdategrup.php",
					data:  {id_grup:id_grup, namagrup:namagrup, mapel:mapel, deskripsi:deskripsi},
					success: function(msg){
						alert(msg);
						if(msg=='berhasil'){
							
							$("#alertnya").removeClass("alert-warning");
							$("#alertnya").removeClass("hidden");
							$("#alertnya").addClass("alert-success");
							$("#alertnya").html('Update Data Berhasil!');
						}
						else{
							$("#alertnya").removeClass("alert-success");
							$("#alertnya").removeClass("hidden");
							$("#alertnya").addClass("alert-warning");
							$("#alertnya").html('Update Data Gagal');
						}
					}
				});
				return false;
			});
		});
	</script>
	
</body>

</html>
