<?php
	
	//include('../koneksi.php');
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


<html>
	<head>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<script src="js/time.js"></script>

		<!-- (Optional) Latest compiled and minified JavaScript translation files -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="container">
    <div class="row">
		<div class="col-lg-5 col-md-5 col-sm-5">
                <div class="panel panel-primary" >
					<div class="panel-heading text-center">
					<div class="pull-left">
						<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
					</div>
					<span class="panel-title" id="countChat">
                        List Chat (0)
                    </span>
					<div class="pull-right">
					<span class="panel-title btn-group">
                        <button type="button" onclick="refreshList()" class="btn btn-default btn-sm" onclick="window.location.reload()">
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
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
                        <button type="button" onclick="refreshChat()" class="btn btn-default btn-sm">
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
	<script src="js/jquery.js"></script>
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
			$("#isichat").html('<div class="text-center"><img src="../images/loader.gif" align="absmiddle">&nbsp;Loading</div>');
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