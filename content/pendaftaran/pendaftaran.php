<style>
.form-control
{
  text-transform: uppercase;
}
</style>
<?php
switch($_GET['act']){

default:
$no_rm=strtoupper($_GET['no_rekam_medik']);
$no_handphone=$_GET['no_handphone'];
$nama=strtoupper($_GET['nama']);
if($_GET['tanggal_lahir']!=''){
	$tanggal_lahir=DateToEng($_GET['tanggal_lahir']);
}
else{
	$tanggal_lahir="";
}
$id_lainnya=$_GET['id_lainnya'];
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<?php //var_dump($_SESSION['id_units']) ?>
	<li class="breadcrumb-item active">Pendaftaran</li>
	<?php
	session_start();
	//var_dump($_SESSION['id_units']);
	?>
	
	<li class="breadcrumb-menu d-md-down-none">
		<div class="btn-group" role="group" aria-label="Button group">
			
		<a class="btn btnCheckHarga" href="#"><i class="icon-tag"></i> Cek harga</a>

			<a class="btn" href="pendaftaran?act=tambahpasien&nama=<?php echo $nama;?>&tanggal_lahir=<?php echo $_GET['tanggal_lahir'];?>&id_lainnya=<?php echo $id_lainnya;?>&idReservasi=0"><i class="icon-plus"></i> Daftar Pasien Baru</a>
		</div>
	</li>
</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-6 col-lg-6" style="height:100px;">
				<div class="card">
					<form class="form-horizontal" id="form_pencarian">
					<div class="card-header">
						<i class="icon-user"></i> Pencarian Pasien
					</div>
					<div class="card-block">
						<div class="searchByData">
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_rekam_medik">No. RM</label>
							<div class="col-md-8">
								<input type="text" id="no_rekam_medik" name="no_rekam_medik" class="form-control" placeholder="No. Rekam Medis" autofocus value="<?php echo $_GET['no_rekam_medik'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_handphone">No. Handphone</label>
							<div class="col-md-8">
								<input type="text" id="no_handphone" name="no_handphone" class="form-control" placeholder="No. Handphone" value="<?php echo $_GET['no_handphone'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="nama">Nama</label>
							<div class="col-md-8">
								<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?php echo $_GET['nama'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
							<div class="col-md-8">
								<input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control date" placeholder="dd/mm/yyyy" value="<?php echo $_GET['tanggal_lahir'];?>">
							</div>
						</div>
					</div>
					
						
						<!-- <div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_lainnya">ID Lainnya</label>
							<div class="col-md-8">
								<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $_GET['id_lainnya'];?>">
							</div>
						</div> -->
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-9">
								<button class="btn btn-sm btn-primary" id='searchPasien' value="cari_pendaftaran"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								<button type="reset" class="btn btn-sm btn-danger" id="resets"><i class="fa fa-ban"></i> Reset</button>
							</div>
							
							<!--<div class="col-md-6">
								<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
							</div>-->
						</div>
					</div>
					</form>
				</div>
			</div>




			<div class="col-sm-6 col-lg-6" style="height:300px;">
				<div class="card" style="height:286px;">
					<div class="card-header">
						<i class="icon-user"></i> Reservasi Pasien
					</div>
					<div class="card-block">
						
					<div class="searchByApi" >
						<div class="form-group row">
							
							<label class="col-md-4 form-control-label" for="tanggal_lahir">ID Pasien</label>
							<div class="col-md-6">
								<input type="text" name="id_pasien" class="form-control" id="id_pasien">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="tanggal_lahir">QR Code</label>
							<div class="col-md-6">
								<input type="text" name="qr_no" class="form-control" id="qr_no">
							</div>
						</div>
					
						<div class="form-group row">
							<div class="col-md-8">
								
							</div>
						</div>



					</div>
						
						<!-- <div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_lainnya">ID Lainnya</label>
							<div class="col-md-8">
								<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $_GET['id_lainnya'];?>">
							</div>
						</div> -->
					
					
				</div>
				<div class="card-footer">
						<div class="row">
							<div class="col-md-9">
								<button id="searchQR" class="btn btn-sm btn-primary"><i class="icon-plus"> Daftar</i></button>
							</div>
							
							<!--<div class="col-md-6">
								<a href="pendaftaran?act=sidik" class="btn btn-success btn-sm pull-right"><i class="fa fa-500px"></i> Sidik Jari</a>
							</div>-->
						</div>
					</div>
			</div>
			</div>




		</div>	

		<script>
		$(document).ready(function()
		{
			$("#searchPasien").click(function(event)
			{
				event.preventDefault();
				var data=$("#form_pencarian").serialize();
				$.ajax({
					beforeSend:function() { 
						$("#load").html("<img src='images/load.gif' id='loading-excel' width='100px'/>");
					},
					url:'content/pendaftaran/hasilCari.php',
					data:data,
					type:'POST',
					success:function(result)
					{
						$("#hasil_cari").html(result);
					},
					error:function()
					{
						
					}
				});
			});
		});
		</script>


<div class="row">
		
				<div class="col-sm-12 col-lg-12" id="hasil_cari">
					<div class="col-sm-12 col-lg-12" id="load" style="height:100px;margin">
					</div>
			</div>
	
	<!--/.row-->
	</div>
	</div>
</div>
<script>

$("#reservasi").click(function(event)
{
	event.preventDefault();
	$(".searchByApi").show();
	$(".searchByData").hide();
	$("#reservasi").hide();
});

$("#reset").click(function(event)
{
	event.preventDefault();
	$(".searchByApi").hide();
	$(".searchByData").show();
	$("#reservasi").show();
});
$("#searchQR").click(function(event)
	{
		event.preventDefault();
		var idReservasi=$("#qr_no").val();
		var clearReservasi=idReservasi.split(":");
		var newIdReservasi=clearReservasi[1];
		var noRM=$("#id_pasien").val();
		//alert(pasienId);
		if(idReservasi!="")
		{
			$.ajax(
			{
				//belum melakukan filter pasien berdasarkan id klinik, karena id klinik belum sama
				url:'data/api_reservasi.php',
				data:{idReservasi:idReservasi},
				type:'GET',
				success:function(result)
				{
					alert(result);
					if(result=="")
					{
						alert("Data Reservasi Tidak ditemukan");
						
					}
					else
					{
						var data= JSON.parse(result);
						var startTime=data.startTime;
						var explodeStartTime=startTime.split("T");
						var dateStart=new Date(explodeStartTime[0]);

						var ddStart=dateStart.getDate();
						var mmStart=dateStart.getMonth()+1;
						var yyyyStart=dateStart.getFullYear();

						var tglIndoStart=ddStart+'-'+mmStart+'-'+yyyyStart;

						var toDay=new Date();
						var dd=toDay.getDate();
						var mm=toDay.getMonth()+1;
						var yyyy=toDay.getFullYear();

						if(dd<10)
						{
							dd='0'+dd;
						}

						if(mm<10)
						{
							mm='0'+mm;
						}

						toDay=yyyy+'-'+mm+'-'+dd;

						if((new Date(dateStart).getTime() > new Date(toDay).getTime()))
						{
							alert("Reservasi anda bukan untuk hari ini, melainkan tanggal " + tglIndoStart);
						}
						else
						{
							if(data.status=='CANCELLED')
							{
								alert("Tidak bisa reservasi, kemungkinan waktu anda sudah habis");
							}
							else if(data.status=='PENDING')
							{
								var nama=data.patient.name;
								var mobile=data.patient.phone;
								var address=data.patient.address;
								var jenkel=data.patient.gender;

								var born=new Date(data.patient.dateOfBirth);
								var tgl=born.getDate();
								var month=born.getMonth();
								var year=born.getFullYear();

								if(tgl<10)
								{
									tgl='0'+tgl;
								}
								/*if(month==0)
								{
									month='01';
								}*/
								var month = month+1;
								if(month<10){month='0'+month;}
								var tgl_lahir=tgl+'/'+month+'/'+year;	
								//alert(tgl_lahir);
							if(noRM!="")
							{
								$.ajax(
								{
									url:'data/checkExistedPasien.php',
									data:{noRM:noRM},
									type:'GET',
									success:function(result)
									{
										if(result==1)
										{
											location.href="antrian?no_rm="+noRM+'&idDokter='+data.doctorId+'&idReservasi='+newIdReservasi;
										}
										else
										{
											alert("NO RM tidak dikenali");
										}
									},
									error:function()
									{
										alert("ERROR");
									}
								});
							}	
							else
							{
								$.ajax(
								{
									url:'data/syncDocter.php',
									data:{idDokter:data.doctorId,idReservasi:idReservasi},
									type:"GET",
									success:function(result)
													{
														
														location.href="pendaftaran?act=tambahpasien&nama="+nama+"&no_handphone="+mobile+"&address="+address+"&idReservasi="+$("#qr_no").val()+"&idDokter="+data.doctorId+"&tanggal_lahir="+tgl_lahir+"&no_antrian="+result+'&jenkel='+jenkel;			
														
													},
													error:function()
													{
														alert("Error");
													}

												});
							}
								
							}
						

						}
						
					/*	if(data.status=="CONFIRMED")
						{
							alert("Anda sudah melakukan konfirmasi");
						}
						else
						{*/
							//belum melakukan compare tanggal dengan tanggal hari ini

							//cek idpasien
							
						/*}							*/
					}
					
				},
				error:function()
				{
					alert("Error");
				}
			});
		}
		else
		{
			$.ajax(
					{
						url:'data/checkDataPasien.php',
								type:'POST',
								data:{idPasien:pasienId},
								success:function(result)
								{
									//alert(result);
									var res=result.split('-');
									var jumlah=res[0];
									var rm=res[1];
								
										$.ajax(
										{
											url:'data/syncDocter.php',
											data:{idDokter:0},
											type:"GET",
											success:function(result)
											{
												if(jumlah==1)
												{
													location.href="antrian?no_rm="+rm+'&idDokter=0'
												}
												else
												{
													alert("Data tidak ditemukan");
												}
												//alert(result);
												
											},
											error:function()
											{
												alert("Error");
											}

										});
									
								}
							});
		}
	});



$('.btnCheckHarga').click(function()
	{
		$.ajax({
			type: 'POST',
			url: 'content/pendaftaran/pendaftaran.php?act=harga',
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});
		
	});
</script>
<!-- /.conainer-fluid -->
<?php
break;


case "tambahpasien":

if($_GET['idReservasi']=="0")
{
	$statusPendaftaran='tidak';
}
else
{
	$statusPendaftaran="reservasi";
}

$unit=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_unit WHERE id='$_SESSION[id_units]'"));

$kode=$unit['kode'];
$noFaskes=$unit['kode_faskes'];
$idOutlet=$unit['id_outlet'];
$disabled=" ";
if($noFaskes=="")
{
	$disabled="disabled";
}

$d=pg_fetch_array(pg_query($dbconn,"SELECT MAX(no_rm) AS no_rm FROM master_pasien WHERE id_unit='$_SESSION[id_units]'"));

$no_rm=$d['no_rm'];

$kode_now="KF".$kode;

$jenkel=$_GET['jenkel'];
if($jenkel=='MALE')
{
	$idJenkel=1;
}
else
{
	$idJenkel=2;
}


$kode_before = substr($no_rm,0,8);
if($kode_before==$kode_now){
	$no_urut = (int) substr($no_rm,8,5);
	$no_urut++;
	$no_rm_new = $kode_now.sprintf("%05s",$no_urut);
}
else{	
	$no_rm_new = $kode_now.sprintf("%05s",1);	
}
$reservasi=explode(":", $_GET['idReservasi']);
$idReservasi=$reservasi[1];
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="pendaftaran">Pendaftaran</a></li>
	<li class="breadcrumb-item active">Daftar Pasien Baru</li>

</ol>


<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form class="form-horizontal" id="simpanPasien" method="POST" action="aksi-tambah-pasien-baru" enctype="multipart/form-data">
						<div class="card-header">
							<i class="icon-plus"></i> Daftar Pasien Baru</b>
						</div>
						<!--<input type="hidden" value="<?php echo $id_jenis_pasien;?>" name="id_jenis_pasien">-->
						<div class="card-block">
							<ul class="nav nav-tabs" role="tablist" id="myTab">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1">Pasien</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3">Saudara Biologis</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5">Penjamin Keluarga</a>
								</li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane active" id="tab1" role="tabpanel">
									<div class="row">
										<div class="col-md-5">
											<fieldset>
												<legend>Pasien</legend>
												<div class="form-group row">
													<?php
													if(isset($_GET['idReservasi']))
													{
														?>
														<label class="col-md-3 form-control-label" for="no_rm">Member ID</span></label>
														<div class="col-md-9">
															<input type="text" id="customerID" name="customerID" class="form-control" placeholder="Customer ID" autofocus value="<?php echo $customerID;?>" <?php echo $required; ?>>
														</div>
													<?php
													}
													?>
												</div>
												<div class="form-group row" style="display:none;">
													<label class="col-md-3 form-control-label" for="no_rm">ID Reservasi</span></label>
													<div class="col-md-9">
														<input type="text" id="IDReservasi" name="IDReservasi" class="form-control" placeholder="Customer ID" autofocus value="<?php echo $idReservasi;?>">
													</div>
												</div>
												
												<div class="form-group row" style="display:none;">
													<label class="col-md-3 form-control-label" for="no_rm">ID Dokter</span></label>
													<div class="col-md-9">
														<input type="text" id="idDokter" name="idDokter" class="form-control" placeholder="Dokter ID" autofocus value="<?php echo $_GET['idDokter'];?>">
														<input type="text" id="idAntrian" name="idAntrian" class="form-control" placeholder="Dokter ID" autofocus value="<?php echo $_GET['no_antrian'];?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="no_handphone">Jenis Pasien <span class="red">*</span></label>
													<div class="col-md-9">
														<select name="id_jenis_pasien" class="form-control" id="id_jenis_pasien">
															<option value="0">Umum</option>
															<?php
														
															$tampil =pg_query($dbconn, "SELECT * FROM master_kategori_harga
															
															where id_outlet='$idOutlet'");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[kode_penjamin]'>$r[nama]</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group row" id="bpjs">
													<label class="col-md-3 form-control-label" for="no_bpjs">No. BPJS</label>
													<div class="col-md-6">
														<input type="text" id="bpjsNumber" name="no_bpjs" class="form-control bpjs" placeholder="No. Kartu BPJS" autofocus readonly>
													</div>
													<div class="col-md-3" >
														<button class="btn btn-sm btn-success" id="check_bpjs" style="display:none;" <?php echo ""; ?>>Check</button>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="no_bpjs">Kode/Nama Faskes</label>
													<div class="col-md-9">
														<input type="text" id="faskes" class="form-control bpjs" >
														<input type="hidden" name="kode_faskes" id="kode_faskes" class="form-control" >
													</div>

												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="no_rm">No. RM <span class="red">*</span></label>
													<div class="col-md-9">
														<input type="text" id="no_rm" name="no_rm" class="form-control" placeholder="No. Rekam Medis" autofocus required value="<?php echo $no_rm_new;?>" readonly>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="nik">NIK</label>
													<div class="col-md-9">
														<input type="text" id="nik" name="nik" class="form-control bpjs" placeholder="NIK">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_lainnya">ID Lainnya</label>
													<div class="col-md-9">
														<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $_GET['id_lainnya'];?>">
													</div>
													
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="nik">Nama <span class="red">*</span></label>
													<div class="col-md-9">
														<input type="text" id="nama" name="nama" class="form-control bpjs" placeholder="Nama Lengkap" required value="<?php echo $_GET['nama'];?>">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="tanggal_lahir">Tempat Lahir <span class="red">*</span></label>
													<div class="col-md-9">
														<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="tanggal_lahir">Tanggal Lahir <span class="red">*</span></label>
													<div class="col-md-4">
														<input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control date bpjs" placeholder="dd/mm/yyyy" required value="<?php echo $_GET['tanggal_lahir'];?>">
													</div>
													<div class="col-md-4" id="hitung_usia">
														
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_title">Panggilan</label>
													<div class="col-md-4">
														<select name="id_title" class="form-control" id="id_title">
															<option value="0"></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_panggilan");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[id]'>$r[nama]</option>";
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_jenis_kelamin">Jenis Kelamin <span class="red">*</span></label>
													<div class="col-md-4">
														<input type="text" class="form-control" id="jenis_kelaminDummy" style="display:none;"/>
														<select name="jenkel" id="jenis_kelamin" class="form-control bpjs" required>
															<option value=""></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_jenkel");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[id]'";
																if($r['id']==$idJenkel)
																{
																	echo "selected";
																}
																echo">$r[nama]</option>";
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_kategori_pasien">Kategori Pasien</label>
													<div class="col-md-9">
														<select name="id_kategori_pasien" class="form-control">
															<option value=""></option>
															<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_kategori_pasien");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[id]'>$r[nama]</option>";
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_pekerjaan">Pekerjaan</label>
													<div class="col-md-9">
														<select name="id_pekerjaan" class="form-control">
															<option value=""></option>
														<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[id]'>$r[nama]</option>";
															}
														?>
														</select>
													</div>
												</div>
											</fieldset>
											
											<fieldset>
												<legend>Alamat</legend>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_provinsi">Provinsi<span class="red">*</span></label>
													<div class="col-md-9">
														<select name="id_provinsi" id="id_provinsi" class="form-control" required>
														<option value="">Pilih</option>
														<?php 
															$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
															while($r=pg_fetch_array($tampil)){
																echo"<option value='$r[id]'>$r[nama]</option>";
															}
														?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_kabupaten">Kab/Kota<span class="red">*</span></label>
													<div class="col-md-9">
														<select name="id_kabupaten" id="id_kabupaten" class="form-control" required>
														
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_kecamatan">Kecamatan<span class="red">*</span></label>
													<div class="col-md-9">
														<select name="id_kecamatan" id="id_kecamatan" class="form-control" required>
														
														</select>
													</div>
												</div>
												
												<!-- <div class="form-group row">
													<label class="col-md-3 form-control-label" for="id_kelurahan">Kelurahan</label>
													<div class="col-md-9">
														<select name="id_kelurahan" id="id_kelurahan" class="form-control">
														
														</select>
													</div>
												</div> -->
												
												<div class="form-group row">
													<label class="col-md-3 form-control-label" for="alamat">Alamat <span class="red">*</span></label>
													<div class="col-md-9">
														<textarea name="alamat" class="form-control" placeholder="Alamat" required><?php echo $_GET['address'] ?></textarea>
													</div>
												</div>
											</fieldset>
										</div>
										
										<div class="col-7">
											<div class="form-group row">
												<div class="col-md-8">
													<fieldset>
														<legend>Detail Lainnya</legend>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_goldar">G. Darah</label>
															<div class="col-md-9">
																<select name="id_goldar" class="form-control" placeholder="Golongan Darah">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_goldar");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_kebangsaan">W. Negara</label>
															<div class="col-md-9">
																<select name="id_warga_negara" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_warga_negara");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_bahasa">Bahasa</label>
															<div class="col-md-9">
																<select name="id_bahasa" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_bahasa");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_suku">Suku</label>
															<div class="col-md-9">
																<select name="id_suku" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_suku");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_agama">Agama </label>
															<div class="col-md-9">
																<select name="id_agama" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_agama");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="id_status_kawin">S. Kawin <span class="red">*</span></label>
															<div class="col-md-9">
																<select name="id_status_kawin" class="form-control">
																	<option value="0"></option>
																	<?php
																	$tampil=pg_query($dbconn,"SELECT * FROM master_status_kawin");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																	?>
																</select>
															</div>
														</div>
													</fieldset>
													
													<fieldset>
														<legend>Telepon</legend>
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_telepon">Rumah</label>
															<div class="col-md-9">
																<input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="Rumah"

																>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_handphone">Mobile
															<span class="red">*</span></label>
															<div class="col-md-9">
																<input type="text" id="no_handphone" name="no_handphone" class="form-control" placeholder="Mobile" required=""
																value="<?php echo $_GET['no_handphone']?>">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="no_telepon_kerja">Kantor</label>
															<div class="col-md-9">
																<input type="text" id="no_telepon_kerja" name="no_telepon_kerja" class="form-control" placeholder="Kantor">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-3 form-control-label" for="nik">Email</label>
															<div class="col-md-9">
																<input type="email" id="email" name="email" class="form-control" placeholder="Email">
															</div>
														</div>
													</fieldset>
												</div>
												
														<div class="col-md-4" id="ambil_foto">
													<fieldset>
														<legend>Foto</legend>
														<?php
														$getDataImage=pg_query("SELECT * from pasien_gambar where id_pasien='$no_rm_new'");
														$jumlah=pg_num_rows($getDataImage);
														$fetch=pg_fetch_assoc($getDataImage);
														if($jumlah==0)
														{
															$pesan="Ambil Gambar";
															?>
																<img id="preview_gambar" src="images/icon/default.png"  alt="" class="img-fluid"/>	
															<?php
														}
														else
														{
															$pesan="Ubah Gambar";
															?>
																<img id="preview_gambar" src="images/pasien/gambar/<?php echo $fetch[gambar] ?>"  alt="" class="img-fluid"/>	
															<?php
														}
														
														?>
														
														<br>
														<label class="fileContainer text-center">
															<?php echo $pesan; ?>
															<!--<input type="" name="fupload" id="fupload" onChange="readURL(this);" accept="image/*"/>-->
														</label>
													</fieldset>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane" id="tab3" role="tabpanel">
									<div class="row">
										<div class="col-md-12">
											
										</div>
										<div class="col-md-5">
											<fieldset>
												<legend>Data</legend>
												<div id="data_keluarga_pasien">
													<table class="table ">
														<thead>
															<tr>
																<th width="50px">No.</th>
																<th>Hubungan</th>
																<th>Nama</th>
																<th width="80px">#</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_keluarga WHERE id_session='$_SESSION[id_session]'");
															$no=1;
															while($r=pg_fetch_array($tampil)){
																$d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_hubungan_keluarga WHERE id='$r[id_hubungan_keluarga]'"));
																?>
																<tr>
																	<td><?php echo $no;?></td>
																	<td><?php echo $d['nama'];?></td>
																	<td><?php echo $r['nama'];?></td>
																	<td class="text-center">
																		<button type="button" class="btn btn-warning btn-xs btnEditKeluarga" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
																		
																		<!--<a 	href="aksi-hapus-pasien-keluarga-<?php echo $r['id'];?>"onclick="return confirm('Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs"><i class="icon-trash"></i></a>-->
																		
																		<button type="button" class="btn btn-danger btn-xs btnHapusKeluarga"  id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
																		
																	</td>
																</tr>
																<?php
																$no++;
															}
															?>
														</tbody>
													</table>
												</div>
											</fieldset>
										</div>
										<div class="col-md-7" id="form_keluarga_pasien">
											<fieldset>
												<legend>Tambah</legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_hubungan_keluarga">Hubungan</label>
															<div class="col-md-8">
																<select name="id_hubungan_keluarga" id="id_hubungan_keluarga" class="form-control">
																	<option value=""></option>
																	<?php 
																		$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
																		while($r=pg_fetch_array($tampil)){
																			echo"<option value='$r[id]'>$r[nama]</option>";
																		}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nama">Nama</label>
															<div class="col-md-8">
																<input type="text" id="nama2" name="nama2" class="form-control" placeholder="Nama">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_pekerjaan2">Pekerjaan</label>
															<div class="col-md-8">
																<select name="id_pekerjaan2" id="id_pekerjaan2" class="form-control" required>
																	<option value="0"></option>
																<?php 
																	$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_telepon2">Telepon</label>
															<div class="col-md-8">
																<input type="text" id="no_telepon2" name="no_telepon2" class="form-control" placeholder="Telepon">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_handphone2">No. HP</label>
															<div class="col-md-8">
																<input type="text" id="no_handphone2" name="no_handphone2" class="form-control" placeholder="No. Handphone">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_telepon_kerja2">Telp. Kantor</label>
															<div class="col-md-8">
																<input type="text" id="no_telepon_kerja2" name="no_telepon_kerja2" class="form-control" placeholder="Telepon Kantor">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="email2">Email</label>
															<div class="col-md-8">
																<input type="email" id="email2" name="email2" class="form-control" placeholder="Email">
															</div>
														</div>
													</div>
													
													<div class="col-md-6">
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Provinsi</label>
															<div class="col-md-8">
																<select name="id_provinsi2" id="id_provinsi2" class="form-control">
																<option value="">Pilih</option>
																<?php 
																	$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Kab/Kota</label>
															<div class="col-md-8">
																<select name="id_kabupaten2" id="id_kabupaten2" class="form-control">
															
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Kecamatan</label>
															<div class="col-md-8">
																<select name="id_kecamatan2" id="id_kecamatan2" class="form-control">
														
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Kelurahan</label>
															<div class="col-md-8">
																<select name="id_kelurahan2" id="id_kelurahan2" class="form-control">
														
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Alamat</label>
															<div class="col-md-8">
																<textarea name="alamat2" id="alamat2" class="form-control"></textarea>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<hr>
														<button type="button" class="btn btn-success btn-sm" id="btnSimpanKeluarga">Simpan</button>
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								
								<!--tab4-->
								<div class="tab-pane" id="tab4" role="tabpanel">
									<div class="row">
										<div class="col-md-12">
											<fieldset>
												<legend>Data</legend>
												<table class="table ">
													<thead>
														<tr>
															<th width="50px">No.</th>
															<th>Nama</th>
															<th>Telepon</th>
														</tr>
													</thead>
												</table>
											</fieldset>
										</div>
										<div class="col-md-12">
											<fieldset>
												<legend>#</legend>
												<ul class="nav nav-tabs" role="tablist" id="myTab2">
													<li class="nav-item">
														<a class="nav-link active" data-toggle="tab" href="#tab4a" role="tab" aria-controls="tab1">Detail</a>
													</li>
													<!--<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#tab4b" role="tab" aria-controls="tab4b">Un-cover items</a>
													</li>-->
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#tab4c" role="tab" aria-controls="tab4c">Instruksi Biling</a>
													</li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane active" id="tab4a" role="tabpanel">
														
														<!--
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="nama_subperusahaan">Perusahaan</label>
															<div class="col-md-6">
																<select name="id_perusahaan">
																
																</select>
															</div>
														</div>
														-->
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="pekerjaan_perusahaan">Pekerjaan</label>
															<div class="col-md-6">
																<input type="text" id="pekerjaan_perusahaan" name="pekerjaan_perusahaan" class="form-control">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="nama_subperusahaan">Perusahaan</label>
															<div class="col-md-6">
																<input type="text" id="nama_subperusahaan" name="nama_subperusahaan" class="form-control">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="no_staff_perusahaan">No. Staff</label>
															<div class="col-md-2">
																<input type="text" id="no_staff_perusahaan" name="no_staff_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="id_departemen_perusahaan">Departemen</label>
															<div class="col-md-2">
																<select name="id_departemen_perusahaan" id="id_departemen_perusahaan" class="form-control">
																
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="valid_from_perusahaan">Valid From</label>
															<div class="col-md-2">
																<input type="text" id="valid_from_perusahaan" name="valid_from_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="valid_too_perusahaan">Valid Too</label>
															<div class="col-md-2">
																<input type="text" id="valid_too_perusahaan" name="valid_too_perusahaan" class="form-control" placeholder="">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="visit_limit_perusahaan">Visit Limit</label>
															<div class="col-md-2">
																<input type="number" id="visit_limit_perusahaan" name="visit_limit_perusahaan" class="form-control" placeholder="" value="0">
															</div>
															<div class="col-md-1"></div>
															<label class="col-md-1 form-control-label" for="co_payment_perusahaan">Co-payment</label>
															<div class="col-md-2">
																<input type="number" id="co_payment_perusahaan" name="co_payment_perusahaan" class="form-control" placeholder="" value="0">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-2 form-control-label" for="no_telepon_perusahaan">Telepon</label>
															<div class="col-md-2">
																<input type="text" id="no_telepon_perusahaan" name="no_telepon_perusahaan" class="form-control" placeholder="">
															</div>
															<div class="col-md-1"></div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab4b" role="tabpanel">
														<table class="table ">
															<thead>
																<tr>
																	<th>Charge Items</th>
																	<th>Harga</th>
																	<th>Jenis</th>
																</tr>
															</thead>
														</table>
													</div>
													
													<div class="tab-pane" id="tab4c" role="tabpanel">
														
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
								
								<!--tab5-->
								<div class="tab-pane" id="tab5" role="tabpanel">
								   <div class="row">
										<div class="col-md-5">
											<fieldset>
												<legend>Data</legend>
												<div id="data_penjamin_pasien">
													<table class="table ">
														<thead>
															<tr>
																<th width="50px">No.</th>
																<th>Nama</th>
																<th>Telepon</th>
																<th width="80px">#</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien_penjamin WHERE id_session='$_SESSION[id_session]'");
															$no=1;
															while($r=pg_fetch_array($tampil)){
																?>
																<tr>
																	<td><?php echo $no;?></td>
																	<td><?php echo $r['nama'];?></td>
																	<td><?php echo $r['no_telepon'];?></td>
																	<td class="text-center">
																		<button  type="button" class="btn btn-warning btn-xs btnEditPenjamin" id="<?php echo $r['id'];?>"><i class="icon-note"></i></button>
																		
																		<button type="button" class="btn btn-danger btn-xs btnHapusPenjamin" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
																		
																	</td>
																</tr>
																<?php
																$no++;
															}
															?>
														</tbody>
													</table>
												</div>
											</fieldset>
										</div>
										<div class="col-md-7" id="form_penjamin_pasien">
											<fieldset>
												<legend>Tambah</legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Panel</label>
															<div class="col-md-8">
																<select name="id_perusahaan_penjamin" id="id_perusahaan_penjamin" class="form-control">
																	<option value=""></option>
																	<?php 
																		$tampil=pg_query($dbconn,"SELECT * FROM master_perusahaan");
																		while($r=pg_fetch_array($tampil)){
																			echo"<option value='$r[id]'>$r[nama]</option>";
																		}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nik">Hubungan</label>
															<div class="col-md-8">
																<select name="id_hubungan_penjamin" id="id_hubungan_penjamin" class="form-control">
																	<option value=""></option>
																	<?php 
																		$tampil=pg_query($dbconn,"SELECT * FROM master_hubungan_keluarga");
																		while($r=pg_fetch_array($tampil)){
																			echo"<option value='$r[id]'>$r[nama]</option>";
																		}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="nama_penjamin">Nama</label>
															<div class="col-md-8">
																<input type="text" id="nama_penjamin" name="nama_penjamin" class="form-control" placeholder="Nama">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_pekerjaan_penjamin">Pekerjaan</label>
															<div class="col-md-8">
																<select name="id_pekerjaan_penjamin" id="id_pekerjaan_penjamin" class="form-control">
																	<option value=""></option>
																	<?php 
																		$tampil=pg_query($dbconn,"SELECT * FROM master_pekerjaan");
																		while($r=pg_fetch_array($tampil)){
																			echo"<option value='$r[id]'>$r[nama]</option>";
																		}
																	?>	
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_telepon_penjamin">Telepon</label>
															<div class="col-md-8">
																<input type="text" id="no_telepon_penjamin" name="no_telepon_penjamin" class="form-control" placeholder="Telepon">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_handphone_penjamin">No. HP</label>
															<div class="col-md-8">
																<input type="text" id="no_handphone_penjamin" name="no_handphone_penjamin" class="form-control" placeholder="No. Handphone">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="email_penjamin">Email</label>
															<div class="col-md-8">
																<input type="email" id="email_penjamin" name="email_penjamin" class="form-control" placeholder="Email">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="no_telepon_kerja_penjamin">Telp. Kantor</label>
															<div class="col-md-8">
																<input type="text" id="no_telepon_kerja_penjamin" name="no_telepon_kerja_penjamin" class="form-control" placeholder="Telepon Kantor">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="visit_limit_penjamin">Visit Limit</label>
															<div class="col-md-8">
																<input type="number" id="visit_limit_penjamin" name="visit_limit_penjamin" class="form-control" placeholder="Visit Limit">
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="co_payment_penjamin">Co-payment</label>
															<div class="col-md-8">
																<input type="number" id="co_payment_penjamin" name="co_payment_penjamin" class="form-control" placeholder="Co-payment">
															</div>
														</div>
														
													</div>
													
													<div class="col-md-6">
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_provinsi3">Provinsi</label>
															<div class="col-md-8">
																<select name="id_provinsi3" id="id_provinsi3" class="form-control">
																<option value="">Pilih</option>
																<?php 
																	$tampil=pg_query($dbconn,"SELECT * FROM master_provinsi");
																	while($r=pg_fetch_array($tampil)){
																		echo"<option value='$r[id]'>$r[nama]</option>";
																	}
																?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_kabupaten3">Kab/Kota</label>
															<div class="col-md-8">
																<select name="id_kabupaten3" id="id_kabupaten3" class="form-control">
															
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_kecamatan3">Kecamatan</label>
															<div class="col-md-8">
																<select name="id_kecamatan3" id="id_kecamatan3" class="form-control">
														
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="id_kelurahan3">Kelurahan</label>
															<div class="col-md-8">
																<select name="id_kelurahan3" id="id_kelurahan3" class="form-control">
														
																</select>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="alamat_penjamin">Alamat</label>
															<div class="col-md-8">
																<textarea name="alamat_penjamin"  id="alamat_penjamin" class="form-control"></textarea>
															</div>
														</div>
														
														<div class="form-group row">
															<label class="col-md-4 form-control-label" for="catatan_penjamin">Catatan</label>
															<div class="col-md-8">
																<textarea name="catatan_penjamin" id="catatan_penjamin" class="form-control"></textarea>
															</div>
														</div>
													</div>
													
													<div class="col-md-12">
														<hr>
														<button type="button" class="btn btn-success btn-sm" id="btnSimpanPenjamin">Simpan</button>
													</div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-sm btn-primary" id="btnSimpanPasien"><i class="fa fa-dot-circle-o"></i> Simpan</button>
							<a href="pendaftaran" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>		<!--/.row-->
	</div>
</div>

<script src="assets/js/ajax/pendaftaran_keluarga.js" type="text/javascript"></script>
<script src="assets/js/ajax/pendaftaran_penjamin.js" type="text/javascript"></script>

<script type="text/javascript">
$(function () {

	
	$("#tanggal_lahir").on('change', function postinput(){
		var tanggal_lahir = $("#tanggal_lahir").val();
		$.ajax({
			type: 'POST',
			url: 'hitung-usia',
			data: { 
				'tanggal_lahir': tanggal_lahir
			},
			success: function(msg){
				$("#hitung_usia").html(msg);
			}
		});
	});
});

$(document).ready(function()
{
	$("#btnSimpanPasien").click(function(event)
	{
		
		var customerId=$("#customerID").val();
		var status="<?php echo $statusPendaftaran; ?>";
		
		if(status=="reservasi" && customerID=="")
		{
			alert("Customer id harus ada");
			return false;
		}
	});

	$("#id_title").change(function()
	{
		var id_title=$("#id_title").val();
		if(id_title==1)
		{
			$("#jenis_kelamin").val("1");
		}
		else
		{
			$("#jenis_kelamin").val("2");	
		}
	});

	$("#id_jenis_pasien").change(function(){
		var id_jenis_pasien=$(this).val();
		
	//	alert($("#id_jenis_pasien").val());
	//package perubahan jenis pasien
		$(".bpjs").val("");
		$(".bpjs").prop("readonly", false);
		$("#jenis_kelamin").show();
		$("#jenis_kelaminDummy").hide();

	//==========================================
		if(id_jenis_pasien=="005001000"){
			$("#bpjsNumber").prop("readonly", false);
			$("#check_bpjs").show();
			$("#no_bpjs").focus();
		}
		else{
			$("#bpjsNumber").prop("readonly", true);
			$("#check_bpjs").hide();
		}
	});

$("#ambil_foto").click(function()
	{
		$("#form-modal2").load('content/pasien/gambar/ambil_gambar.php?no_rm=<?php echo $no_rm_new; ?>').modal('show'); 
	});

	$("#check_bpjs").click(function()
	{
		var noBPJS=$("#bpjsNumber").val();
		if(noBPJS=="")
		{
			alert("No BPJS tidak ada"); 
		}
		else
		{
			$.ajax(
			{
				url:'content/pendaftaran/checkJumlah.php',
				data:{noBPJS:noBPJS},
				type:'GET',
				success:function(result)
				{
					
					var data=JSON.parse(result);
					var no_rm=data.no_rm;
					var jumlah=data.jumlah;
					var jumlahPasien=data.jumlahPasien;
					var jumlahExisted=data.jumlahExisted;
					
					if(jumlahExisted==0)
					{
						$.ajax(
						{
						url:'data/api.php',
						data:{noBPJS:noBPJS},
						dataType:'json',
						type:'GET',
						success:function(result, data)
						{
							if(result.error=="")
							{
								if(result.data.metadata_code=="200")
								{
									$("#nik").val(result.data.nik).prop('readonly', true);
									$("#nama").val(result.data.nama).prop('readonly', true);
									
									var tanggal_lahir=result.data.tglLahir;
									$("#tanggal_lahir").val(tanggal_lahir).prop('readonly', true);
									if(result.data.sex=="L")
									{
										jk=1;
										_jk="Laki-Laki";
									}
									else
									{
										jk=2;
										_jk="Perempuan";
									}
									$("#jenis_kelamin").val(jk).hide();
									$("#jenis_kelaminDummy").val(_jk).prop('readonly', true).show();
									$("#faskes").val(result.data.kdProvider+' -  '+result.data.nmProvider).prop('readonly',true);
									$("#kode_faskes").val(result.data.kdProvider);
								}
								else
								{
									alert(result.data.metadata_message);
								}
							}
							else
							{

								alert(result.message);
							}
							
						},
						error:function(result, xhr)
						{
							alert("ERROR");
							//package perubahan jenis pasien
							$(".bpjs").val("");
							$(".bpjs").prop("readonly", false);
							$("#jenis_kelamin").show();
							$("#jenis_kelaminDummy").hide();
						//==========================================
						}
						});
					}
					else
					{
						window.location="antrian?no_rm="+no_rm;
					}
					
				},
				error:function()
				{

				}
			});
		}

		//alert(noBPJS);
		
		
	});
});
</script>
<?php
break;

case "ambilpasienkeluarga":
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="pendaftaran">Pendaftaran</a></li>
	<li class="breadcrumb-item"><a href="pendaftaran?act=tambahpasien&kategori=umum#tab3">Daftar Pasien Barus</a></li>
	<li class="breadcrumb-item active">Ambil Data Pasien</li>
</ol>

<?php

?>
<div class="container-fluid">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="card">
					<form class="form-horizontal">
					<div class="card-header">
						<i class="icon-user"></i> Pencarian
					</div>
					<div class="card-block">
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_rekam_medik">No. Rekam Medis</label>
							<div class="col-md-8">
								<input type="text" id="no_rekam_medik" name="no_rekam_medik" class="form-control" placeholder="No. Rekam Medik" autofocus value="<?php echo $_GET['no_rekam_medik'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="no_bpjs">No. Handphone</label>
							<div class="col-md-8">
								<input type="text" id="no_bpjs" name="no_handphone" class="form-control" placeholder="No. Kartu BPJS" value="<?php echo $_GET['no_handphone'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="nama">Nama</label>
							<div class="col-md-8">
								<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="<?php echo $_GET['nama'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
							<div class="col-md-8">
								<input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control date" placeholder="yyyy-mm-dd" value="<?php echo $_GET['tanggal_lahir'];?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 form-control-label" for="id_lainnya">ID Lainnya</label>
							<div class="col-md-8">
								<input type="text" id="id_lainnya" name="id_lainnya" class="form-control" placeholder="ID Lainnya" value="<?php echo $_GET['id_lainnya'];?>">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-6">
								<button type="submit" class="btn btn-sm btn-primary" value="cari_pendaftaran"><i class="fa fa-dot-circle-o"></i> Tampilkan</button>
								<a href="#" onclick="history.go(-1)" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Kembali</a>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
			
			<?php
			if(isset($_GET['no_rekam_medik'])){
				?>
					<div class="col-sm-8 col-lg-8">
					<div class="card">
						<div class="card-header">
							<i class="icon-layers"></i> Hasil Pencarian
						</div>
						<div class="card-block">
							<table class="table  table-striped" id="myTable">
								<thead>
									<tr>
										<th width="50px">No.</th>
										<th>No. Rekam Medis</th>
										<th>No. Kartu BPJS</th>
										<th>Nama</th>
										<th>Tanggal Lahir</th>
										<th>ID Lainnya</th>
										<th width="50px">#</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no_rm=$_GET['no_rekam_medik'];
									$no_handphone=$_GET['no_handphone'];
									$nama=$_GET['nama'];
									if($_GET['tanggal_lahir']!=''){
										$tanggal_lahir=DateToEng($_GET['tanggal_lahir']);
									}
									else{
										$tanggal_lahir="";
									}
									
									$id_lainnya=$_GET['id_lainnya'];
									
									if($no_rm=='' AND $no_handphone=='' AND $nama=='' AND $tanggal_lahir=='' AND $id_lainnya==''){
									
									}
									else{
										if($no_rm!=''){
											if($no_handphone!=''){
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND no_handphone='$no_handphone'");
														}
													}
												}
											}
											else{
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
														}
													}
												}
											}
										}
										else{
											if($no_handphone!=''){
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_handphone='$no_handphone'");
														}
													}
												}
											}
											else{
												if($nama!=''){
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE nama LIKE '%$nama%'");
														}
													}
												}
												else{
													if($tanggal_lahir!=''){
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir' AND id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE tanggal_lahir='$tanggal_lahir'");
														}
													}
													else{
														if($id_lainnya!=''){
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE id_lainnya='$id_lainnya'");
														}
														else{
															$tampil=pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$no_rm'");
														}
													}
												}
											}
										}
										$no=1;
										while($r=pg_fetch_array($tampil)){
											$tanggal_lahir=DateToIndo3($r['tanggal_lahir']);
											echo"
											<tr>
												<td>$no</td>
												<td>$r[no_rm]</td>
												<td>$r[no_handphone]</td>
												<td>$r[nama]</td>
												<td>$tanggal_lahir</td>
												<td>$r[id_lainnya]</td>
												<td>";
													if($r['status_kunjungan']!='Y'){
														echo"<a href='pendaftaran-antrian-$r[no_rm]'><button type='button' class='btn btn-xs btn-success'><i class='icon-login'></i></button></a>";
													}
												echo"</td>
											</tr>
											";
											$no++;
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>		<!--/.row-->
	</div>
</div>
<?php
break;
case "harga":
?>
		<div class="modal-dialog modal-lg modal-info">
				<div class="modal-content">
			
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Cek Harga</h6>
					</div>
					<div class="modal-body" id="form-data">

					<form class="form-horizontal">
						<div class="form-group row">
							<label class="col-md-2 form-control-label">Perusahaan</label>
							<div class="col-md-5">
								<select id="id_kategori" class="form-control btnkategori">
									<?php 
										include "../../config/conn.php";
										$sql= pg_query($dbconn, "SELECT * FROM master_kategori_harga");
										
										while ($row=pg_fetch_assoc($sql)) {

											echo "<option value='$row[id]'>$row[nama] </option>";
							
										}
									 ?>
								</select>

							
							</div>
						</div>
						<div id="cek_harga_p">

						</div>
						
						

					</form>
						
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					
				</div>
				
			</div>
		</div>
<script>

	$('.btnkategori').change(function()
	{
		
		var id= $('#id_kategori').val();
		
		$("#cek_harga_p").load("data/harga.php?id="+id); 
		
	});
</script>
		<?php

break;


case "mintaNoPasien":
?>
		<div class="modal-dialog modal-lg modal-info">
				<div class="modal-content">
			
					<div class="modal-header">
						<h6 class="modal-title" id="title-form">Cek Harga</h6>
					</div>
					<div class="modal-body" id="form-data">

					<form class="form-horizontal">
						<div class="form-group row">
							<label class="col-md-2 form-control-label">Perusahaan</label>
							<div class="col-md-5">
								<select id="id_kategori" class="form-control btnkategori">
									<?php 
										include "../../config/conn.php";
										$sql= pg_query($dbconn, "SELECT * FROM master_kategori_harga");
										
										while ($row=pg_fetch_assoc($sql)) {

											echo "<option value='$row[id]'>$row[nama] </option>";
							
										}
									 ?>
								</select>

							
							</div>s
						</div>
						<div id="cek_harga_p">

						</div>
						
						

					</form>
						
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
					
				</div>
				
			</div>
		</div>
<script>

	$('.btnkategori').change(function()
	{
		
		var id= $('#id_kategori').val();
		
		$("#cek_harga_p").load("data/harga.php?id="+id); 
		
	});
</script>
		<?php

break;

}
?>