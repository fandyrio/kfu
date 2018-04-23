
<div class="content-wrapper">
  <section class="content-header">
      <h1>
       Master - Body
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Body</li>
      </ol>
    </section>

         <!-- Dashboard Counts Section-->
    <section class="content">
    	<div class="box-body">
	    	<div class="row">
	        	<div class="col-md-6">
	          		<div class="box box-primary">
	        			<form method="post">
	            			<div class="box-header with-border">
								<h3 class="box-title">Data</h3>
								<table id="example1" class="table table-bordered table-striped">
									<thead>
						                <tr>
											<th>No.</th>
						                  	<th>Body</th>
						                  	<th>Lokasi Body</th>
						                   	<th width="60px"><center>#</center></th>
						                </tr>
						            </thead>
						            <tbody>
						                <?php
						                $no=1;
						                $getBody= pg_query($dbconn,"Select l.*, b.nama_body  from master_lokasi_body l 
						                	join master_body b on b.id=l.id_body
						                	order by l.id asc");
						              
						                while ($row=pg_fetch_assoc($getBody)) {
						                	echo "
						                	  	<tr>
						                			<td>".$no."</td>
						                			<td>".$row['nama_body']."</td>
						                			<td>".$row['nama_lokasi']."</td>
						                			<td> 
						                				<span class='glyphicon glyphicon-pencil edit' aria-hidden='true' style='width:40%;'>
						                					<p style='display:none;' class='valueId'>$row[id]</p></span> |
						                				<span class='glyphicon glyphicon-trash delete' aria-hidden='true' style='width:40%;'>
						                					<p style='display:none;' class='valueId'>$row[id]</p>
						                				</span>
						                			</td>
						                		</tr>
						                	";
						                	$no++;
						                }

						                ?>
						            </tbody>
						        </table>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6" id="action">
	        		<?php
	        			if(isset($_GET["update"])){
	            			include "update.php";
	        			}
	        			else{
	         			include "tambah.php"; 
	        			}
	         		?>
	      		</div>
			</div>
		</div>
            <!-- /.box-header -->

    </section>
</div>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
$(document).ready(function()
{
	$(".edit").click(function()
	{
		$(".edit").removeClass('activated');
		if($(this).hasClass('activated'))
		{

		}
		else
		{
			$(this).addClass("activated");
			$(".activated").each(function()
			{
				var data=$(".activated > .valueId").text();
				$("#action").load('pages/lokasi_body/update.php?data='+data);

			});
		}
	});

	$(".delete").click(function()
	{
		$(".delete").removeClass('activatedDelete');
		if($(this).hasClass('activatedDelete'))
		{

		}
		else
		{
			$(this).addClass("activatedDelete");
			$(".activatedDelete").each(function()
			{
				var data=$(".activatedDelete > .valueId").text();

				if(confirm("Are you sure?"))
				{
					$.ajax(
					{
						url:"media.php?lokasi_body=lokasi_body&modul=simpan&act=delete",
						data:{id:data},
						type:'POST',
						success:function()
						{
							alert("Data dihapus");
							window.location.reload();
						},
						error:function()
						{
							alert("Gagal Bro !");
						}
					});
				}

			});
		}
	})
})
</script>