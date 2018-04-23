<?php
error_reporting(0);
include "../../../config/conn.php";
include "../../../config/fungsi_tanggal.php";
include "../../../config/library.php";

$d=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_pasien WHERE no_rm='$_POST[id]'"));
if($d['jenkel']==1){
	$jenkel="<i class='icon-symbol-male'></i>";
}
else{
	$jenkel="<i class='icon-symbol-female'></i>";
}

if($d['foto']!=''){
	$foto="images/pasien/upload_$d[foto]";
}
else{
	$foto="images/default.png";
}

$id_pasien=$d['id'];

$tanggal_hari_ini=DateToIndo2($tgl_sekarang);
?>
<input type="hidden" name="id" value="<?php echo $id_pasien;?>" id="id_pasien">
<div class="card">
	<div class="card-header">
		<strong>Gambar</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12">
				<fieldset>
					<legend>Data</legend>
					<button type="button" class="btn btn-success btn-xs" id="btnTampilkanGambar">TAMPILKAN MULTI VIEW</button>
					<br><br>
					<div id="data_gambar">
					<table class="table">
						<thead>
							<tr>
								<th width="20px"></th>
								<th width="130px">Tanggal</th>
								<th>Judul</th>
								<th>Catatan</th>
								<th width="80px">#</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$tampil=pg_query($dbconn,"SELECT * FROM pasien_gambar WHERE id_pasien='$id_pasien' AND status_hapus='N' ORDER BY waktu_gambar DESC");
								while($r=pg_fetch_array($tampil)){
									$tanggal=DateToIndo2($r['waktu_gambar']);
									$a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_gambar_kategori WHERE id='$r[id_kategori]'"));
									$nama_kategori=$a['nama'];
									
									?>
									<tr>
										<td><input type="checkbox" name="id_gambar[]" value="<?php echo $r['id'];?>"></td>
										<td><?php echo $tanggal;?></td>
										<td><?php echo $r['judul'];?></td>
										<td><?php echo $r['catatan'];?></td>
										<td>
											
											<button class="btn btn-danger btn-xs btnHapusGambar" id="<?php echo $r['id'];?>"><i class="icon-trash"></i></button>
										</td>
									</tr>
									<?php
								}
							?>
						</tbody>
					</table>
					</div>
				</fieldset>
				<br>
				<div id="tampilan_gambar"></div>
			</div>

		</div>
	</div>
</div>
<?php
	pg_close($dbconn);
?>

<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function (e) {
    $('#tambah_pasien_gambar').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
		var id_pasien=$("#id_pasien").val();
		
		var dataString2 = 'id_pasien='+id_pasien;
		
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                //console.log("success");
                //console.log(data);
				$("#data_gambar").html(data);
            },
            error: function(data){
                //console.log("error");
                //console.log(data);
            }
        });
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-gambar',
			data: dataString2,
			cache: false,
			success: function(msg){
				$("#form_gambar").html(msg);
			}
		});
    }));
});


$(function () {
	$("#btnTampilkanGambar").click(function(){
		var checked = [];
        $("input[name='id_gambar[]']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });
	
		if(checked==''){
			alert("Pilih Gambar");
		}
		else{
			$.ajax({
				type: 'POST',
				url: 'aksi-tampilkan-gambar',
				data: { 
					'checked': checked
				},
				success: function(msg){
					$("#tampilan_gambar").html(msg);
				}
			});
		}
	});
	
	$(".btnEditGambar").click(function(){
		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-gambar',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form_gambar").html(msg);
			}
		});
		
	});
	
	$(".btnHapusGambar").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus gambar ini?")){
			var id = this.id;
			var id_pasien=$("#id_pasien").val();
			var dataString2 = 'id_pasien='+id_pasien;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-gambar',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_gambar").html(msg);
					$("#tampilan_gambar").load();
				}
			});
			

			
		}
		else{
			return false;
		}
	});
});


$(document).ready(function(){
	$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});



</script>

