<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Jadwal MCU</li>

</ol>


<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row">   
        <div class="col-md-12 " >
         <div class="card">

        <form method="post">
            
            <div class="card-header">
              <i class="icon-grid"></i> Data
				<span class="pull-right">
                        <button type="button" onclick="location.href='tambah-jadwal-mcu'" class="btn btn-primary btn-xs">Tambah Data</button>  
				</span>
			</div>
            <br>
            <div class="card-body">
              <table id="myTable" class="table ">
                <thead>
                <tr>
                <th width="10px">No.</th>
                  <th width="">Tanggal</th>
				  <th>Penjamin</th>
                  <th width="">Paket</th>
                  <th width="">Unit</th>
                  <th>Status</th>
				  <th>Jumlah Pasien</th>
				  <th>Keterangan</th>
                   <th width="60px">Aksi</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
            if($_SESSION['id_units']>1){
                  $q= "Select p.*, u.harga, unit.nama, unit.id AS id_unit  from billing_paket p 
                      INNER JOIN billing_paket_kategori_harga_unit u ON u.id_billing_paket = p.id
                      LEFT OUTER JOIN master_unit unit ON  unit.id=u.id_unit
                      where unit.id= '$_SESSION[id_units]' AND p.status='7' OR unit.id= '$_SESSION[id_units]' AND p.status='6' ORDER BY p.nama_paket ASC";
               
            }
            else{
                $q= "Select p.*, u.harga, unit.nama, unit.id AS id_unit  from billing_paket p 
                      INNER JOIN billing_paket_kategori_harga_unit u ON u.id_billing_paket = p.id
                      LEFT OUTER JOIN master_unit unit ON  unit.id=u.id_unit
                      WHERE   p.status='7' OR p.status='6' ORDER BY p.nama_paket ASC";
               }
                 $res=pg_query($dbconn,$q);
                 $no=1;

                 while ($row=pg_fetch_assoc($res)) {
					 $d=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_kategori_harga WHERE id='$row[id_perusahaan]'"));
					 $nama_perusahaan=$d['nama'];
					 $result =pg_fetch_array(pg_query($dbconn, "SELECT * FROM master_status_penawaran  where id= '$row[status]' "));
					 $status="<span class='badge badge-$result[warna]'>$result[nama]</span>";
					 
					 $c=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM antrian WHERE id_paket='$row[id]' AND id_unit='$row[id_unit]'"));
					 $tot=$c['tot'];
                     ?>
                       <tr>     
                       <td class="text-left" style="vertical-align:middle;"><?php echo $no++;?></td>                   
                        <td class="text-left" style="vertical-align:middle;"><?php echo DatetoIndo2($row["tgl_awal"])." s/d ".DatetoIndo2($row["tgl_akhir"]);?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $nama_perusahaan;?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama_paket"];?></td>
                        <td class="text-left" style="vertical-align:middle;"><?php echo $row["nama"];?></td>
                       <td><?php echo $status;?></td>
					   <td><?php echo $tot;?></td>
					   <td><?php echo $row['keterangan'];?></td>
                        <td class="text-left" style="vertical-align:middle;">
							<?php
							if($row['status']==7){
							?>
							 <a href="edit-jadwal-mcu-<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat" title="Edit"><i class="fa fa-edit"></i></a>
							<button type="button" id="<?php echo $row['id']?>" class="btn btn-success btn-xs btn-flat btnSelesai"><i class="fa fa-check"></i></button>
							<?php
							}
							?>
                            <a href="media.php?jadwal=mcu&modul=hapus&id=<?php echo $row['id'] ?>" onclick="return confirm('SELURUH UNIT AKAN TERHAPUS YANG TERJADWAL DALAM EVENT INI. ANDA YAKIN?')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                        </td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
               

              </table>
              </div>

          </form>

        <!-- /.col -->
      </div>

     </div>
    </div>
    </div>
    </div>
<script type="text/javascript">
	$('.btnSelesai').click(function()
	{
		var id=$(this).attr('id');
		var dataString2 = 'id='+id;
		$.ajax({
			type: 'POST',
			url: 'selesai-mcu-jadwal',
			data : dataString2,
			success: function(msg){
				$("#form-modal2").html(msg);
				$("#form-modal2").modal('show'); 
			}
		});	
	})
</script>
