<?php
session_start();

    $id_unit= $_SESSION['id_units'];
    $res=pg_query($dbconn,"SELECT k.*  from master_kategori_harga k 
    	inner join master_unit_perusahaan p ON p.id_perusahaan = k.id WHERE id_unit = '$id_unit'");
	
?>  
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Perusahaan</li>
	<li class="breadcrumb-menu d-md-down-none">
		
	</li>
</ol>
         <!-- Dashboard Counts Section-->
 	<div class="container-fluid">
    <div class="col-md-6 card ">
    <div class="card-header">
              <i class="icon-grid"></i> Data
      </div>
     <div class="card-block">

            <table id="myTable" class="table table-sm">
							<thead class="table-secondary">
								<tr>
									<th>Nama</th>
									<th >Alamat</th>
									<th >Telepon</th>
								</tr>
							</thead>
							<tbody>
							<?php
							

							while ($row=pg_fetch_assoc($res)) {
								
							?>
								<tr>
									<td><a href="media.php?content=perusahaan&modul=view_detail_perusahaan&id=<?php echo $row[id] ;?>"><?php echo $row["nama"] ?></a></td>
									<td><?php echo $row["alamat"] ?></a></td>
									<td><?php echo $row["telepon"] ?></a></td>
									
								</tr>
							<?php 	
							} 
							?> 
							</tbody>
						</table>
        </div> 
        </div>
        </div>


