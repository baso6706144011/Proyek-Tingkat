<html>
	<head>
		<title>Daftar</title>
		<script type="text/javascript" src="jquery-1.2.6.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
			<SCRIPT type="text/javascript">
				
				/*----------------------------- UNTUK MEMVALIDASI INPUTAN USER ----------------------------------*/
				var cek = false;
				function validasi_input(form){
					
					if(!cek){
						$("#berhasil").html('<font color="red">Periksa kesalahan data terlebih dahulu!</font>');
						return (false);
					}
					return (true);
				}
				
				
				<!--
				pic1 = new Image(16, 16);
				pic1.src = "images/loader.gif";

				$(document).ready(function(){
				
				/*----------------------------- UNTUK MENGECEK KETERSEDIAAN USERNAME ----------------------------------*/
				
				$("#username").change(function() { 

				var usr = $("#username").val().trim();
				
				if(usr.length >= 6)
				{
				$("#status").html('<img src="images/loader.gif" align="absmiddle">&nbsp;Checking availability...');
					var cek = false;
					var isi = usr;
					isi = isi.trim();
					var illegalChars = /\W/;
					if(illegalChars.test(isi)){
						cek = false;
					}
					if(!cek){
						$("#status").html('<font color="red">username tidak boleh mengandung spasi <strong>6</strong> karakter.</font>');
					}
					else{
						$.ajax({  
						type: "POST",  
						url: "validation/checkusername.php",  
						data: "username="+ usr,  
						success: function(msg){  
					   
					   $("#status").ajaxComplete(function(event, request, settings){ 

						if(msg == 'OK')
						{ 
							$("#username").removeClass('object_error'); // if necessary
							$("#username").addClass("object_ok");
							$(this).html('&nbsp;<img src="images/tick.gif" align="absmiddle">');
						} 
							
						else  
						{  
							$("#username").removeClass('object_ok'); // if necessary
							$("#username").addClass("object_error");
							$(this).html(msg);
						}  
					   
						});
						} 
					   
					  }); 
					}
				}
				else
					{
					
					$("#status").html('<font color="red">username minimal <strong>6</strong> karakter.</font>');
					$("#username").removeClass('object_ok'); // if necessary
					$("#username").addClass("object_error");
					}

				});
				/*----------------------------- UNTUK MENGECEK VALIDASI NIS ----------------------------------*/
				$("#nis").change(function() {
					var nis = $("#nis").val().trim();
					if(nis.length>=8){
					$("#s").html('<img src="images/loader.gif" align="absmiddle">&nbsp;Checking availability...');
					
					$.ajax({  
						type: "POST",  
						url: "validation/checknis.php",  
						data: "nis="+ nis,  
						success: function(msg){  
					   
					   $("#status").ajaxComplete(function(event, request, settings){ 

						if(msg == 'OK')
						{ 
							$("#username").removeClass('object_error'); // if necessary
							$("#username").addClass("object_ok");
							$(this).html('&nbsp;<img src="images/tick.gif" align="absmiddle">');
							cek=true;
						} 
							
						else  
						{  
							$("#username").removeClass('object_ok'); // if necessary
							$("#username").addClass("object_error");
							$(this).html(msg);
							cek=false;
						}  
					   
						});
						} 
					   
					  });
					}
					else{
						$("#status").html('<font color="red">nomor induk minimal <strong>8</strong> digit angka.</font>');
						$("#username").removeClass('object_ok'); // if necessary
						$("#username").addClass("object_error");
						cek=false;
					}
					document.getElementById('username').value=nis;
					document.getElementById('password').value=nis;
				});
				
				$("#nis").keydown(function (e) {
					// Allow: backspace, delete, tab, escape, enter and .
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
						 // Allow: Ctrl+A, Command+A
						(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
						 // Allow: home, end, left, right, down, up
						(e.keyCode >= 35 && e.keyCode <= 40)) {
							 // let it happen, don't do anything
							 return;
					}
					// Ensure that it is a number and stop the keypress
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
					}
				});
				
				
				//--------------------------------------
				
				$("#bulan").change(function() { 

				var bln = $("#bulan").val();
				var nTgl;
				if(bln=="2")
				{
					nTgl=29;
				}
				else if(bln=="1" || bln=="3" || bln=="5" || bln=="7" || bln=="8" || bln=="10" || bln == "12"){
					nTgl=31;
				}
				else{
					nTgl=30;
				}
					var i =1;
					$('#tanggal')
						.find('option')
						.remove()
						.end()
					;
					for(var i = 1;  i <= nTgl; i++){
						$('#tanggal').append("<option value="+i+">"+i+"</option>")
					}
				});
				
				//--------------------------------------
				$(window).bind("pageshow", function() {
					var form = $('form'); 
					// let the browser natively reset defaults
					form[0].reset();
				});
				});

				//-->
			</SCRIPT>
			<noscript>
				 <div style="position: fixed; top: 0px; left: 0px; z-index: 3000; 
							height: 100%; width: 100%; background-color: #FFFFFF">
					<p style="margin-left: 10px">JavaScript is not enabled.</p>
				</div>
			</noscript>
		<link rel="icon" type="image/png" href="" />
    </head>

	<body>
    	<div id="regist-page">
        	<div id="regist-header">
            	<div id="regist-logo">
                	<img src="images/logo.png" height="65" width="130">
                </div>
            	<div id="regist-menu">
                	<ul>
                    	<li>Daftar</li>
                    	<a href="index.php"><li class="selected">Masuk</li></a>
                    </ul>
                </div>
            </div>
            
            <div id="regist-main">
            	<div id="regist-form">
					<form action="cekregistrasi.php" onsubmit="return validasi_input(this)" method="POST">
					 <fieldset>
						<legend>Form Pendaftaran</legend>
						<div><input id="username" name="username" type="text" placeholder="Username" required readonly></div>
						<div id="status"></div></td>
						<div><input id="nama" name="nama" type="text" placeholder="Nama Pengguna" required></div>
						<div><input id="nis" name="nis" type="text" placeholder="Nomor Induk" required></div>
						<div><input id="password" name="password" type="password" placeholder="Password" required readonly></div>
						<div><input id="email" name="email" type="email" placeholder="Email" required></div>
						<div>Tanggal Lahir : </div>
						<div>
							<select id = "tanggal" name="tanggal">
							<?php
								$maks=31;
								for($i = 1; $i <= $maks; $i++)
									echo "<option value=".$i.">$i</option>";
							?>
							</select>
							<select id = "bulan" name="bulan">
							<option value ="1">Januari</option>
							<option value ="2">Februari</option>
							<option value ="3">Maret</option>
							<option value ="4">April</option>
							<option value ="5">Mei</option>
							<option value ="6">Juni</option>
							<option value ="7">Juli</option>
							<option value ="8">Agustus</option>
							<option value ="9">September</option>
							<option value ="10">Oktober</option>
							<option value ="11">November</option>
							<option value ="12">Desember</option>
							</select>
							<select id="tahun" name="tahun">
							<?php
								$maks=2000;
								for($i = 1955; $i <= $maks; $i++)
									echo "<option value = ".$i.">$i</option>";
							?>
							</select>
						</div>
						<div>Daftar sebagai : </div>
						<div class="check">
							<input name="tipe_user" type="radio" value="2">Guru
							<input name="tipe_user" type="radio" value="3" checked>Siswa
						</div>
						<input name="submit-registrasi" type="submit" value="Daftar">
					</fieldset>
					</form>
					
                </div>
				<div id = "berhasil"></div>
            </div>
            
            <div id="regist-footer">
            
            </div>
        </div>
	</body>
</html>
