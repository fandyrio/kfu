<?php
session_start();

    $id_unit= $_SESSION['id_units'];
    $res=pg_query($dbconn,"SELECT k.*, p.nama, mp.name, p.poly_id from master_karyawan_unit k 
    	inner join master_karyawan p ON p.id = k.id_karyawan
    	INNER JOIN master_poly mp on mp.id=p.poly_id WHERE k.id_unit = '$id_unit'
    	AND p.id_jabatan='1'
    ");
?>  
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Dokter</li>
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
									<th >Poli</th>
								</tr>
							</thead>
							<tbody>
							<?php
							while ($row=pg_fetch_assoc($res)) {
								
							?>
								<tr>
									<td><a href="media.php?content=dokter&modul=view_detail_dokter&id=<?php echo $row[id_karyawan];?>&poly_id=<?php echo $row[poly_id]?>"><?php echo $row["nama"] ?></a></td>
									<td><?php echo $row["name"] ?></a></td>
									
								</tr>
							<?php 	
							} 
							?> 
							</tbody>
						</table>
        </div> 
        </div>
        </div>


