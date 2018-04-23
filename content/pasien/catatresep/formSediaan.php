<?php
$id=$_GET['id'];

?>

<input type="text" class="from-control sediaanDetail" id='sediaanDetail<?php echo $id; ?>' name="sediaanDetailTyped" style="width:170px;">
<div id="hasil_sediaanDetail<?php echo $id; ?>" style="position:absolute;background:white;border:0px solid black;cursor:pointer;width:200px;padding:3px;display:none;z-index:1000;"></div>

<script type="text/javascript">
	$(".sediaanDetail").keyup(function()
		{
			var id=this.id;
			var sediaan=$("#"+id).val();
			var idResep=<?php echo $id ?>;
			$.ajax(
			{
				url:'content/pasien/catatresep/getSediaanDetail.php',
				type:'POST',
				data:{sediaan:sediaan, idResep:idResep},
				success:function(result)
				{
					$("#hasil_"+id).html(result).show();
				}
			});
		});
</script>