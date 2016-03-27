<?php
	include ('../koneksi.php');
	
	$arrayPartner=array();
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
	if(empty($_POST['username']) || !isset($_POST['username'])){
		echo "<div class=\"alert alert-danger text-center\"><p>Chat Kosong!</p></div>";
	}
	else{
		//$sql=mysql_query("select id_pengirim, id_pesan as id, nama as pengirim, foto, isi_pesan as isi, waktu_kirim as waktu, status from pesan as q, user where waktu_kirim=(select max(waktu_kirim) from pesan where id_pengirim=q.id_pengirim) and id_penerima='' and q.id_pengirim=id_user GROUP by id_pengirim ORDER BY waktu_kirim DESC;") or die(mysql_error());
		$sql=mysql_query("select * from pesan as q where waktu_kirim=(select max(waktu_kirim) from pesan where (id_pengirim=q.id_pengirim and id_penerima='')) OR waktu_kirim=(select max(waktu_kirim) from pesan where (id_penerima=q.id_penerima and id_pengirim='')) ORDER BY waktu_kirim DESC;") or die(mysql_error());
		while($isi=mysql_fetch_array($sql)){
			$id_pesan=$isi['id_pesan'];
			$pengirim=$isi['id_pengirim'];
			$penerima=$isi['id_penerima'];
			$isichat=$isi['isi_pesan'];
			$waktu_kirim=$isi['waktu_kirim'];
			if($pengirim==""){
				$partner=$penerima;
			}
			else{
				$partner=$pengirim;
			}
			if(!in_array($partner, $arrayPartner)){
				array_push($arrayPartner, $partner);
				$sql1=mysql_query("select nama, foto from user where id_user='$partner'");
				$isi1=mysql_fetch_array($sql1);
				$namauser=$isi1['nama'];
				$foto="../images/profil/".$isi1['foto'];
?>

<li class="left clearfix" onclick="clickMe(this.id)" id="<?php echo $partner;?>"><span class="chat-img pull-left">
	<img src="<?php echo $foto; ?>" alt="User Avatar" class="img-circle" width="50px" height="50px" />
</span>
	<div class="chat-body clearfix">
		<div class="header">
			<strong class="primary-font">
				<?php 
					echo $namauser;echo "&nbsp;&nbsp;";
					$sql2=mysql_query("select count(*) as jumlah from pesan where id_pengirim='$partner' and status=0");
					$isi2=mysql_fetch_array($sql2);
					if($isi2['jumlah']!=0) {
						echo "<span class=\"badge\" style=\"background-color:#269abc\">";
						echo $isi2['jumlah'];
						echo "</span>";
					}
				?>
				
			</strong> <small class="pull-right text-muted">
				<span class="glyphicon glyphicon-time">
				</span>
					<?php echo time_elapsed_string($waktu_kirim);?>
				</small>
		</div>
		<p>
			<?php 
			if(strlen($isichat)<=100)
				echo $isichat ;
			else{
				echo substr($isichat,0,100)."... <strong><font color=\"blue\">[Selengkapnya]</font></strong>";
			} 
			?>
		</p>
	</div>
</li>
<?php
			}
		}
		$list = " (".count($arrayPartner).")";
		echo $list;
	}
?>