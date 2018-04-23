<?php
session_start();

    $id_unit= $_SESSION['id_unit'];
    $res=pg_query($dbconn,"SELECT k.*  from master_kategori_harga k 
    	inner join master_unit_perusahaan p ON p.id_perusahaan = k.id WHERE id_unit = '$id_unit'");
   // $data = pg_fetch_array($result);
	
?>  
<header class="page-header">
        <div class="container-fluid">
          <h2 class="no-margin-bottom">Perusahaan</h2>
		  <ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
			<li class="breadcrumb-item active">Perusahaan</li>
		</ul>
        </div>
        </header>
         <!-- Dashboard Counts Section-->
        <section class="dashboard-counts no-padding-bottom">
 <div class="container-fluid">
 <div class="card">
			<div class="card-header">

	
<div class="card-body">
	<div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel">
            <table class="table table-sm">
							<thead class="table-secondary">
								<tr>
									
									<th>Nama</th>
									<th >#</th>
								</tr>
							</thead>
							<tbody>
							<?php
							

							while ($row=pg_fetch_assoc($res)) {
								
							?>
								<tr>
									<td><a href="media.php?content=perusahaan&modul=view_detail_perusahaan&id=<?php echo $row[id] ;?>"><?php echo $row["nama"] ?></a></td>
									
								</tr>
							<?php 	
							} 
							?> 
							</tbody>
						</table>
        </div> 
	</div>
</div>


</div>
</div>
</div>
 </section>