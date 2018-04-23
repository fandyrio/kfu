<?php
include "../../../config/conn.php";


$nama_rs=$_POST['rs'];
$getDokter=pg_query("SELECT * from master_cabang_rujukan where nama iLIKE '%$nama_rs%' LIMIT 10");
$jumlah=pg_num_rows($getDokter);

if($jumlah==0)
{
	echo "Tidak ada data <br />";
	echo "<button class='btn btn-sm btn-default' id='tbhRS'>Tambah Rumah Sakit</button>";
}
else
{
	while($fetchDokter=pg_fetch_assoc($getDokter))
	{
		echo"
		<ul>
			<li style='cursor:pointer;'><div id='$fetchDokter[id]' class='getDokter'>$fetchDokter[nama]</div></li>
		</ul>
		";
	}	
}



?>

<div class="popUP" style="z-index:999999;background-color:white; position: absolute;;display:none;width:300px;height:300px;margin-left:500px;top:0;">
	<div class="header" style="width:100%;background-color:green;color:white;text-align:center;padding:10px;">
		Tambah Rumah Sakit
	</div>
	<form id="tambahRS">
	<div class="bodyContent" style="width:100%;padding:10px;">
		<div class="form-group" id="rs">
			<label>Nama Rumah Sakit</label>
			<input type='text' class="form-control" name="nama_rs" id="nama_rs">
			
						
		</div>
		<div class="form-group" id="rs">
			<label>Alamat</label>
			<input type='text' class="form-control" name="alamat" id="alamat">
			
						
		</div>
		<div class="form-group" id="rs">
			<label>No. Telp</label>
			<input type='text' class="form-control" name="no_tlp" id="no_tlp">
		
						
		</div>
		<div class="form-group" id="rs">
			<button class="btn btn-primary btn-sm" id="simpan">Simpan</button>
			<button class="btn btn-danger btn-sm" id="batal">Batal</button>
						
		</div>
	</div>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	$("#tbhRS").click(function(e)
	{
		e.preventDefault();
		$(".popUP").show(); 
	});
	$(".getDokter").click(function()
	{
		var idDokter=$(this).attr('id');
		var namaDokter=$("#"+idDokter).text();
		
		$("#rujukan_id").val(idDokter);
		$("#rujukan_nama").val(namaDokter);
		$("#rs_rujukan").hide();
	});

	$("#batal").click(function(e)
	{
		e.preventDefault();
		$(".popUP").hide(); 
	});

	$("#simpan").click(function(e)
	{
		e.preventDefault();
		var data=$("#tambahRS").serialize();
		$.ajax(
		{
			url:'content/pasien/tindak_lanjut/simpanRS.php',
			data:data,
			type:'POST',
			success:function(result)
			{
				var data=JSON.parse(result);
				var id=data.id;
				var nama = data.nama;
				$("#rujukan_nama").val(nama);
				$("#rujukan_id").val(id);
				$("#rs_rujukan").hide();
				$(".header").html("Rumah sakit ditambahkan"); 
				$("#tambahRS").hide();
				setTimeout(function(){ $(".popUP").hide(); }, 3000);
			}
		});
	});

});

</script>