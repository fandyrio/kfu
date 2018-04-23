<?php 
session_start();
error_reporting(0);
if (empty($_SESSION['login_user'])){
	header('location:keluar');
}

	include "../../../config/conn.php";
	include "../../../config/library.php";
	include "../../../config/fungsi_tanggal.php";
	$tampil=pg_fetch_array(pg_query($dbconn,"SELECT * FROM pasien_form WHERE id='$_POST[id]'  ORDER BY id DESC"));

	$id_pasien=$_POST['id_pasien'];
	$id_kunjungan=$_POST['id_kunjungan'];
	?>
	<form id="tambah_pasien" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id_pasien" value="<?php echo $id_pasien;?>" id="id_pasien">
		<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
		<input type="hidden" name="no_rm" value="<?php echo $_POST[no_rm];?>" id="no_rm">
		<div class="card-header">
			<strong>View Form</strong>
		</div>
		<div id="formpasien">
		<div class="card-block" >
			<div class="row">
				
					
			<?php include "../../../data/dokumen/".$tampil['nama_path']; ?>	
					
					
		</div>
		</div>
		</div>
		
		<div class="card-footer">
			<button onclick='printDiv();' type="button" class="btn btn-primary btn-sm ">Print</button>
			<button type="button" class="btn btn-danger btn-sm btnBatal">Batal</button>
		</div>
	</form>
		<script type="text/javascript">
		
	//$("#formpasien input[type='checkbox']").attr('disabled',true);
	$("#formpasien input[type='checkbox']").css('background',' #fcfff4 !important');
		
		$(function () {

			$(".btnBatal").click(function(){
				var rm=$("#no_rm").val();
			alert(rm);
			var dataString2 = 'id='+rm;
				$.ajax({
					type: 'POST',
					url: 'form-pemeriksaan',
					data: dataString2,
					success: function(msg){
						$("#data_form").html(msg);
					}
				});
			});
		});



	function printDiv() 
		{

		  var divToPrint=document.getElementById('formpasien');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Laporan Pemeriksaan</title>');
		  newWin.document.write(' <link href="assets/css/style.css" rel="stylesheet"></head><body style="background-image: none !important;"  onload="window.print()">');
		  newWin.document.write('<DIV class="logo"><img src="images/logo_laporan_lab.png" style="position: auto;left: 15px;top: 0px;margin-bottom:-10px;"></DIV>	<div style="text-align:center"><h3>Laporan Pemeriksaan</h3></div><div class="" style="font-size: 8px !important;color:#fff;">');
		  newWin.document.write(divToPrint.innerHTML);
		  newWin.document.write('</div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		}
		</script>