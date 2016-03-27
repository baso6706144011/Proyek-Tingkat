<?php
	include('../koneksi.php');
?>


<html>
	<head>
		



		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
		<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable();
		} );
</script>
	</head>
	<body>
		<h3>Daftar Siswa</h3>
		<div class="table-responsive">
		<table id="example" class="table table-striped table-hover table-bordered bootstrap-datatable datatable responsive" cellspacing="0" width="100%">
        <thead class="bg-primary">
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
						<td>
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
							
							echo "<td>
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
										<button type=\"button\" value=".$isi['id_user']." class=\"btn btn-danger btn-xs btnhapus pull-right\">
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
                        	<button type="button" class="btn btn-success btn-xs pull-right">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            Tambah</button>
                        </td>
				</tr>
			</tfoot>
    </table>
	</div>
	</body>
</html>
