<?php
session_start();

$id_users=$_SESSION['id_users'];

?>
<input type="hidden" name="id" value="<?php echo $id_users;?>" id="id_pasien">
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan;?>" id="id_kunjungan">
<div class="card">
	<div class="card-header">
		<strong>Ganti Password</strong>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-md-12" id="data_peringatan">
				<div class="form-group">
					<label>Password Baru</label>
					<input type="password" name="id" id="password" class="form-control col-md-3">
				</div>
				<div class="form-group">
					<label>Konfirmasi Password Baru</label>
					<input type="password" name="id" id="konfirmasi" class="form-control col-md-3">
				</div>
				<div class="form-group">
					<button class="btn btn-sm btn-primary" id="ubah">Ubah</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	

	$("#ubah").click(function()
	{
		var password=$("#password").val();
		var konfirmasi=$("#konfirmasi").val();
		var id_users="<?php echo $id_users ?>";
		if(password!="" && konfirmasi!="")
		{
			if(password!=konfirmasi)
			{
				alert("Password tidak sama");
			}
			else
			{
				$.ajax(
				{
					url:'eventChangePass.php',
					data:{idUser:id_users,password:password},
					type:'POST',
					success:function(result)
					{
						alert("Password Berhasil diUbah");
						location.reload();
					},
					error:function()
					{
						alert("ERROR");
					}
				});
			}
		}
		else
		{
			alert("Field tidak boleh kosong");
		}
	});
});



</script>