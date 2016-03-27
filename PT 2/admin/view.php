<!DOCTYPE html>
<?php
	include('session.php');
	
	$nama=$user_check;
?>
<html lang="en">

<head>
	 <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
           <div class="container-fluid">
            <h3>Daftar Guru</h3>
            <div class="table-responsive">
            	<table class="table table-striped table-hover" id="datatables">
                	<tr class="info">
                    	<th>
                        	#
                        </th>
                    	<th>
                        	Nomor Induk
                        </th>
                        <th>
                        	Nama
                        </th>
                        <th>
                        	Username
                        </th>
                        <th colspan="4">
                        	Jenis User
                        </th>
                    </tr>
                    <?php
						include "../koneksi.php";
						$query = "select nama_level, nama, nis, id_user from user, level_user where user.user_level=level_user.no AND user.user_level = 2 ORDER BY nama_level;";
						$sql = mysql_query($query);
						$count=0;
						if(mysql_num_rows($sql) == 0){
							echo "<tr>
									<td colspan=\"8\" class=\"bg-default text-center\">Data Guru Kosong!</td>
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
							
							echo "<td>
										<form action=\"lihatprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
										</form>
                       			  </td>";
							echo "<td>
										<form action=\"editprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
										</form>
								  </td>";
							echo "<td>
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\">
  <span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> Hapus </button>
                        		  </td>";
							echo "</tr>";
						} 
						}
					?>
                    <tr>
                    	<td colspan="8" class="info">
                        	<button type="button" class="btn btn-success btn-xs pull-right">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            Tambah</button>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1">
            <h3>Daftar Siswa</h3>
            <div class="table-responsive">
            	<table class="table table-striped table-hover">
                	<tr class="info">
                    	<th>
                        	#
                        </th>
                    	<th>
                        	Nomor Induk
                        </th>
                        <th>
                        	Nama
                        </th>
                        <th>
                        	Username
                        </th>
                        <th colspan="4">
                        	Jenis User
                        </th>
                    </tr>
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
							
							echo "<td>
										<form action=\"lihatprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
										</form>
                       			  </td>";
							echo "<td>
										<form action=\"editprofiluser.php\" method=\"GET\">
										<button type=\"submit\" name=\"id\" value=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
										</form>
								  </td>";
							echo "<td>
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\">
  <span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> Hapus </button>
                        		  </td>";
							echo "</tr>";
						} 
						}
					?>
                    <tr>
                    	<td colspan="8" class="info">
                        	<button type="button" class="btn btn-success btn-xs pull-right">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            Tambah</button>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
	</div>
</div>


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
        $('.btnhapus').click(function(){
			
			var username=$(this).val();
			var r = confirm("Anda yakin ingin menghapus pengguna dengan username : "+username+" ?");
			if (r == true) {
				$.ajax({  
						type: "POST",  
						url: "deleteuser.php",  
						data: "username="+ username,  
						success: function(msg){
					   $(".alert").ajaxComplete(function(event, request, settings){
						if(msg == 'OK')
						{
							$(this).html(msg);
						} 
							
						else  
						{  
							$(this).attr('data gagal dihapus');
						}  
					   
						});
						} 
					   
					  });
				location.reload(true);				
			}
			else{
				
			}
        });
    });
    </script>
</body>

</html>
