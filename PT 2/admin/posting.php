<!DOCTYPE html>
<?php
	include('session.php');
	
	include('validation/cekposting.php');
	include('validation/updateposting.php');
	$nama=$user_check;
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
  
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->

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
					<li class="active">
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
                            Posting <small>Menu Utama</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="glyphicon glyphicon-home"></i> Posting Informasi
                            </li>
                        </ol>
                    </div>
                </div>
                
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-md-offset-2">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Buat Posting</div>
							<div class="panel-body">
								<button type="button" class="btn btn-info btn-lg pull-right" data-toggle="modal" data-target="#myModal">
								<span class="glyphicon glyphicon-plus"></span><strong>&nbsp;&nbsp;Tambah Posting</button>
							</div>
						</div>
					</div>
				  <!-- Content -->
				  <div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
					
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title text-primary"><span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Posting Informasi</strong></h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" autocomplete="off" role="form" id="myform" enctype="multipart/form-data" method="post">
								<div class="form-group">
									<label for="Judul" class="col-sm-2 control-label">Judul</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="judul" id="judul" required>
									</div>
								</div>
								<div class="form-group">
									<label for="isi" class="col-sm-2 control-label">Isi</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="4" name="isi" id="isi"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-2 control-label">Target</label>
									<div class="col-sm-3">
										<label class="radio-inline"><input type="radio" name="tujuan" value="2" required>Guru</label>
									</div>
									<div class="col-sm-3">
										<label class="radio-inline"><input type="radio" name="tujuan"  value="3">Siswa</label>
									</div>
									<div class="col-sm-3">	
										<label class="radio-inline"><input type="radio" name="tujuan" value="1">Guru & Siswa</label>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-10 pull-right">
										<img class="hidden preview" src="#" alt="your image" style="max-width:300px; max-height:300px;"/>
									</div>
								</div>
								<div class="form-group">
									<label for="isi" class="col-sm-2 control-label">Gambar</label>
									<div class="col-sm-10">
										<input type="file" name="file" class="btn btn-default" id="file">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<div class ="pull-right">
										<button id="submit" name="submit" type="submit" value="" class="btn btn-primary">Post</button>
										<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</form> 
						</div>
					  </div>
					  
					</div>
				  </div>
				  
				  <div class="modal fade" id="editModal" role="dialog">
					<div class="modal-dialog">
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title text-primary"><span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Edit Posting</strong></h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" autocomplete="off" role="form" id="editform" enctype="multipart/form-data" method="post">
								<div class="form-group">
									<label for="Judul" class="col-sm-2 control-label">Judul</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="editjudul" id="judulEdit" required>
									</div>
								</div>
								<div class="form-group">
									<label for="isi" class="col-sm-2 control-label">Isi</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="4" name="editisi" id="isiEdit"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="edittujuan" class="col-sm-2 control-label">Target</label>
									<div class="col-sm-3">
									<label class="radio-inline"><input type="radio" name="edittujuan" id="rd2" value="2" required>Guru</label>
									</div>
									<div class="col-sm-3">
										<label class="radio-inline"><input type="radio" name="edittujuan" id="rd3" value="3">Siswa</label>
									</div>
									<div class="col-sm-3">	
										<label class="radio-inline"><input type="radio" name="edittujuan" id="rd1" value="1">Guru & Siswa</label>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-10 pull-right">
										<img class="hidden preview" id="editimg" src="#" alt="your image" style="max-width:300px; max-height:300px;"/>
									</div>
								</div>
								<div class="form-group">
									<label for="isi" class="col-sm-2 control-label">Gambar</label>
									<div class="col-sm-10">
										<input type="file" name="editfile" class="btn btn-default" id="editfile">
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
						<div class="modal-body">
							Anda yakin ingin menghapus postingan ini?
						</div>
						<div class="modal-footer">
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2">
										<div class ="pull-right">
										<button id="deletePost" name="deletePost" type="button" value="" class="btn btn-danger">Hapus</button>
										<button id="cancel" name="cancel" type="cancel" value="Send" class="btn btn-default" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
						</div>
					  </div>
					  
					</div>
				  </div>
					<?php
						$sql=mysql_query("select * from posting where id_poster='' order by waktu_post desc");
						if(!mysql_num_rows($sql)){
					?>	
					<div class="col-md-8 col-md-offset-2">
						<div class="alert alert-warning text-center">
							Anda tidak memiliki postingan!
						</div>
					</div>
					<?php
						}
						else{
							while($isi=mysql_fetch_array($sql)){
							$judul=$isi['judul_post'];
							$isi_post=$isi['isi_post'];
							$id_post=$isi['id_posting'];
							$gambar=$isi['gambar'];
							$target=$isi['target'];
							$waktu=$isi['waktu_post'];
					?>
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#dcdcdc;">
								<?php echo $judul;?>
								<div class="dropdown pull-right">
								  <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									Action
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><button type="button" class="btn btn-default editBtn" style="width:100%;border:none;" value="<?php echo $id_post;?>">Edit</button></li>
									<li><button type="button" class="btn btn-default deleteBtn" style="width:100%;border:none;" value="<?php echo $id_post;?>">Delete</button></li>
								  </ul>
								</div>
							</div>
							<div class="panel-body" style="max-height:800px;overflow:auto;background-color:#f6f6f6">
								<span class="pull-right">
									<small class="text-muted">
									<span class="glyphicon glyphicon-time"></span>
									<?php
										echo time_elapsed_string($waktu);
									?>
								</small>
								</span>
								<h4 class="text-primary">
									<?php echo "Target : ";
										if($target==1)
											echo "Guru & Siswa";
										else if($target==2){
											echo "Guru";
										}
										else
											echo "Siswa";
									?>
								</h4>
								<p style="white-space:pre-line;font-weight: normal;">
									<?php echo $isi_post;?>
								</p>
								<?php
									if($gambar!=""){
										$gambar="../images/post/".$gambar;
										echo '<img src="'.$gambar.'" style="max-width:100%; max-height:100%;"/>';
									}
								?>
							</div>
						</div>
					</div>
				<?php
							}
						}
				?>
				</div>
            </div>
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<script type="text/javascript">
	document.getElementById("myform").reset();
	function readURL(input, param) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $(param+'.preview').removeClass('hidden');
            reader.onload = function (e) {
                $(param+'.preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

	$(document).ready(function(){
		var idPost;
		$(".editBtn").on("click", function(){
			idPost=$(this).val();
			$("#editModal").modal();
			$.ajax({  
				type: "POST",  
				url: "validation/getposting.php",  
				data: "id_posting="+ idPost, 
				dataType: 'json',
				cache: false,					
				success: function(result){
					$('#judulEdit').val(result[0]);
					$('#isiEdit').val(result[1]);
					$('#editsubmit').val(result[4]);
					if(result[3]!=''){
						$('#editimg.preview').removeClass('hidden');
						$('#editimg.preview').attr('src','../images/post/'+result[3]);
					}
					$("#rd"+result[2]).prop("checked", true);
				}	
			});
		});
		
		$(".deleteBtn").on("click", function(){
			idPost=$(this).val();
			$("#deleteModal").modal();
		});
		$("#deletePost").on("click", function(){
			$.ajax({  
					type: "POST",  
					url: "validation/deleteposting.php",  
					data: "id_posting="+ idPost,  
					success: function(msg){
					if(msg == 'OK')
					{
						$('.alert').html(msg);
						location.reload(true);
					} 	
					else  
					{  
						$('.alert').removeClass('hidden');
						$('.alert').attr('data gagal dihapus');
					}  
					} 
				});	
		});
		$('#file').bind('change', function() {
			cekFile=false;
			if(this.files[0].size > 2097152){
				alert('Ukuran file tidak boleh melebihi 2 MB!');
				cekFile=false;
				$('#file').replaceWith($('#file').val('').clone(true));
				$('.preview').addClass('hidden');
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
					$('.preview').addClass('hidden');
				}
			}
		});
		$("#file").change(function(){
			readURL(this,"");
		});
		$('#editfile').bind('change', function() {
			cekFile=false;
			if(this.files[0].size > 2097152){
				alert('Ukuran file tidak boleh melebihi 2 MB!');
				cekFile=false;
				$('#editfile').replaceWith($('#editfile').val('').clone(true));
				$('#editimg.preview').addClass('hidden');
			}
			else{		
				var allowed_extensions = new Array("jpg","png","gif");
				var file_extension = $('#editfile').val().split('.').pop().toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.
				if(jQuery.inArray(file_extension, allowed_extensions) !== -1)
				{
					cekFile=true; // valid file extension
				}
				if(!cekFile){
					alert('File harus berupa gambar!');
					$('#editfile').replaceWith($('#editfile').val('').clone(true));
					cekFile=false;
					$('editimg.preview').addClass('hidden');
				}
			}
		});
		$("#editfile").change(function(){
			readURL(this,"#editimg");
		});
	});
</script>
</body>

</html>
