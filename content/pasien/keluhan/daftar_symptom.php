<style>
	.symptomName:hover
	{
		background-color:#CCE5FF;
	}
</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";

$namaSymptom=$_GET['namaSymptom'];
$lokasi=$_GET['lokasi'];
$body=$_GET['body'];

$getDataSymptom=pg_query("SELECT * from master_sympton_indo where id_body='$body' and id_lokasi='$lokasi' and nama_sympton ILIKE '%$namaSymptom%' LIMIT 5");

while($fetchDataSymptom=pg_fetch_assoc($getDataSymptom))
{
	echo "<div id='$fetchDataSymptom[id]' class='form-control symptomName' style='border:0.5px solid black;cursor:pointer;margin-top:1px;padding:5px;'>".$fetchDataSymptom['nama_sympton']."</div>";
}

?>
<script>
	$(document).ready(function()
	{
		var jumlah=parseInt($("#jumlahSympton").val());
		var nextJumlah=jumlah+1;
		var button=$('<input type="button" class="btn col-sm-2 btn-xs btn-danger hapusData" style="float:left;" id="'+nextJumlah+'" value="hapus" /> ');
		$(".symptomName").click(function()
		{
			$("#jumlahSympton").val(nextJumlah);
			var id=this.id;
			var value=$("#"+id).text();
			
			$("#hasilSymptom").hide();
				$('<input>').attr({
			    type: 'text',
			    readonly:'readonly',
			    id: 'namaSymptom'+nextJumlah,
			    name: 'sympton'+nextJumlah,
			    class :'form-control col-sm-8 namaSymptom',
			    value:value,
			    style:'float:left;margin-top:1px;'
			}).appendTo('#selectedSymptom');

			$("#hasilSymptom").hide();

				$('<input>').attr({
			    type: 'hidden',
			    id: 'idSymptom'+nextJumlah,
			    name: 'idSymptom'+nextJumlah,
			    class :'form-control col-sm-2',
			    value:id,
			    style:'float:left;'
			}).appendTo('#selectedSymptom');
			$("#selectedSymptom").append(button);
			
			$("#listId").append(nextJumlah+",");

			$("#selectedSymptom").append(button);

			//$("#selectedSymptom").append("<input type='button' class='btn btn-xs btn-danger hapusData' id='"+nextJumlah+"' value='hapus' />");


			$("#namaSymptom").val("");
			$("#listSymptom").hide();
		});
		button.on('click',function()
		{
			var id=this.id;
			var jumlah=parseInt($("#jumlahSympton").val());
			var decrease=jumlah-1; // kurangi field jumlah
			$("#jumlahSympton").val(decrease);

			var listId=$("#listId").text();//get list symptom
			var split=listId.split(",");
			var longList=split.length-1;
			var lastId='';
			var seperate='';
			for(var x=0;x <= longList;x++)
			{

				if(id==split[x])
				{
					split[x]="";
				}
			
				if(longList==1)
				{
					lastId="";
				}
				else
				{
					if(split[x]!='')
					{
						lastId+=split[x]+','; // 1,3,	
					}

				}
			}			
			
			$("#listId").html(lastId);

			$("#idSymptom"+id).remove();
			$("#"+id).remove();
			$("#namaSymptom"+id).remove();
		});
		
	
	});
</script>