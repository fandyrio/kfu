<?php
	$idJenisPasien=$_GET['id_pasien'];	
?>


<table id="lookup" class="table table-bordered table-striped">  
		<thead align="center">
		    <tr>
		        <th>Kode </th>
		        <th>Nama </th>
		        <th class="text-center"> N </th> 
                <th class="text-center"> R </th> 
		  
		    </tr>
		</thead>
		<tbody>
		</tbody>
</table>

<script>	
	$(document).ready(function() {
		 	var idJenisPasien="<?php echo $idJenisPasien ?>";
                var dataTable = $('#lookup').DataTable( {
                  "language": {
                    "search": "Cari:",
                    "sLengthMenu": "Tampilkan _MENU_ records"

                        },
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                        url :"content/pasien/catatresep/ajax-grid-data-resep.php", // json datasource
                        data:{idJenisPasien:idJenisPasien},
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".lookup-error").html("");
                            $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#lookup_processing").css("display","none");
                            
                        }
                    }
                });

            });
</script>