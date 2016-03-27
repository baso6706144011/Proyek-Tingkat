<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap 101 Template</title>
        
        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body>
	
    <div class="container">
    	
    	<div class="row">
        
			<!--
        	<div class="col-md-4 col-md-push-8 bg-danger">
            	column1
            </div>
            <div class="col-md-8 col-md-pull-4 bg-success">
            	column2
            </div>
            <div class="col-xs-12 bg-info">
            	<h1>This is a header<small>Secondary text</small></h1>
                <p class="lead">This is a leading paraghraph</p>
                <p>This is a normal paraghraph</p>
            </div>
            <div class="col-xs-12 bg-danger">
            	You can <mark>highlight</mark> texts using <mark>mark</mark>
                <del>deleted text</del>
            </div>
            <div class="col-xs-12 bg-info">
            	<p class="text-left">left aligned text.</p>
                <p class="text-center">center aligned text.</p>
                <p class="text-right">right aligned text.</p>
                <p class="text-justify">justify aligned text.</p>
            </div>
            <div class="col-xs-12 bg-info">
            	<p class="text-lowercase">THIS IS LOWERCASE</p>
            </div>
            -->
            <div class="col-xs-10 col-xs-offset-1">
            <h3>Daftar Guru</h3>
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
						$query = "select nama_level, nama, nis, id_user from user, level_user where user.user_level=level_user.no AND user.user_level = 2 ORDER BY nama_level;";
						$sql = mysql_query($query);
						$count=0;
						if(mysql_num_rows($sql) == 0){
							echo "<tr>
									<td colspan=\"8\" class=\"bg-warning text-center\">Data Guru Kosong!</td>
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
                        				
										<button type=\"button\" name=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
                       			  </td>";
							echo "<td>
										<button type=\"submit\" name=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
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
									<td colspan=\"8\" class=\"bg-warning text-center\">Data Siswa Kosong!</td>
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
                        				
										<button type=\"button\" name=".$isi['id_user']." class=\"btn btn-info btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit </button>
                       			  </td>";
							echo "<td>
										<button type=\"submit\" name=".$isi['id_user']." class=\"btn btn-primary btn-xs pull-right\">
  <span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span> Lihat </button>
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
  </body>
</html>


    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-1.12.0.min.js"></script>
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
				alert('berhasil');
				location.reload(true);				
			}
			else{
				
			}
        });
    });
    </script>