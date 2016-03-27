<?php
	include "../koneksi.php";
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
	if(isset($_POST['username']) && isset($_POST['tujuan'])){
		$username=$_POST['username'];
		$tujuan=$_POST['tujuan'];
		$idUser=$username;
		$idPartner=$tujuan;
		$sql=mysql_query("select nama, foto, user_level from user where id_user='$username'") or die(mysql_error());
		$isi=mysql_fetch_array($sql);
		if($isi){
			$namaUser=$isi['nama'];
			$fotoUser=$isi['foto'];
			$levelUser=$isi['user_level'];
			if($levelUser==1)
				$idUser='';
		}
		$sql=mysql_query("select nama, foto, user_level from user where id_user='$tujuan'") or die(mysql_error());
		$isi=mysql_fetch_array($sql);
		if($isi){
			$namaPartner=$isi['nama'];
			$fotoPartner=$isi['foto'];
			$levelPartner=$isi['user_level'];
			if($levelPartner==1)
				$idPartner='';
		}
		$sql1=mysql_query("select id_pengirim, id_penerima, id_pesan, isi_pesan, waktu_kirim from pesan where (id_pengirim = '$idUser' AND id_penerima='$idPartner') OR (id_pengirim='$idPartner' AND id_penerima='$idUser') ORDER BY waktu_kirim");
		if(!mysql_num_rows($sql1)){
			echo "<div class=\"alert alert-danger text-center\"><p>Chat Kosong!</p></div>";
		}
		else{
			$sql2=mysql_query("update pesan set status=1 where id_pengirim = '$idPartner' AND id_penerima='$idUser'") or die(mysql_error());
			while($isi1=mysql_fetch_array($sql1)){
			$idPesan=$isi1['id_pesan'];
			$isi_pesan=$isi1['isi_pesan'];
			$pengirim=$isi1['id_pengirim'];
			$penerima=$isi1['id_penerima'];
			$waktu_kirim=$isi1['waktu_kirim'];
?>

<ul class="chat" id="chat">
	<?php 
		if($pengirim!=$idUser){
	?>
	
	<li class="left clearfix"><span class="chat-img pull-left">
		<img src="<?php echo "../images/profil/".$fotoPartner; ?>" alt="User Avatar" class="img-circle" width="50px" height="50px"/>
	</span>
		<div class="chat-body clearfix">
			<div class="header">
				<strong class="primary-font"><?php echo $namaPartner; ?></strong> <small class="pull-right text-muted">
					<span class="glyphicon glyphicon-time"></span>
					<?php
						echo time_elapsed_string($waktu_kirim);
					?>
					</small>
			</div>
			
				<?php echo $isi_pesan?>
			
		</div>
	</li>
	<?php 
		}
		else{
	?>
	<li class="right clearfix"><span class="chat-img pull-right">
		<img src="<?php echo "../images/profil/".$fotoUser; ?>" alt="User Avatar" class="img-circle" width="50px" height="50px"/>
	</span>
		<div class="chat-body clearfix">
			<div class="header">
				<small class="text-muted">
					<span class="glyphicon glyphicon-time"></span>
					<?php
						echo time_elapsed_string($waktu_kirim);
					?>
				</small>
				<strong class="pull-right primary-font text-primary"><?php echo $namaUser; ?></strong> 
			</div>
			<div class="pull-right">
				<?php echo $isi_pesan;?>
			</div>
		</div>
	</li>
	<?php
		}
	?>
</ul>

<?php
			}
		}
	}
	
?>