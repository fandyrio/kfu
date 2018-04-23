<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/conn.php";

$id_unit=$_SESSION['id_units'];
$getSetting=pg_query("SELECT * from ruang_unit where id_unit='$id_unit'");
$fetchSetting=pg_fetch_assoc($getSetting);

$getPolyPerklinik=pg_query("SELECT * from poly_perklinik ppk 
	join master_poly mp on mp.id=ppk.id_poly 
	left join ruang_unit ru on ru.poly=mp.id and ru.id_unit=ppk.id_klinik
	where ppk.id_klinik='$id_unit'");
?>
<div class="form-group">
	<div class="col-md-2">
		<?php
		if(pg_num_rows($getSetting)==0)
		{
			echo "<div class='btn btn-danger btn-xs'>Ruangan belum di setting</div>";
		}
		?>
	</div>
</div>
<form id="roomSetting">
<?php
	while($fetchPolyPerklinik=pg_fetch_assoc($getPolyPerklinik))
	{
		?>
		
			<div class="form-group">
				<div class="col-md-2">
					<label>Poly <?php echo $fetchPolyPerklinik['name'] ?></label>
					<input type="text" name="codePoly[<?php echo $fetchPolyPerklinik['code'] ?>]" class="form-control edit umum" value="<?php echo $fetchPolyPerklinik['jumlah']; ?>" readonly="readonly">
				</div>
			</div>
		
		<?php
	}
?>
</form>

<button type="button" class="btn btn-sm btn-success editRoom">Edit</button>
<button type="button" class="btn btn-sm btn-success updateRoom" style="display:none;">Update</button>
<button type="button" class="btn btn-sm btn-danger cancelEditRoom">Cancel</button>


<script type="text/javascript">
$(document).ready(function()
{
	$(".editRoom").click(function()
	{
		$(".editRoom").hide();
		$(".updateRoom").show();
		$(".edit").prop("readonly", false);

	});

	$(".updateRoom").click(function()
	{
		var data=$("#roomSetting").serializeArray();
	
		$.ajax(
		{
			url:'content/settings/saveRoom.php',
			data:data,
			type:'GET',
			success:function(result)
			{
				$("#room_setting").load("content/settings/room_setting.php");
			},
			error:function()
			{
				alert("E");
			}
		});
	});
	$(".cancelEditRoom").click(function()
	{
		$("#room_setting").html("");
	});
});

</script>