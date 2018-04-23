  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item active">Buka Stok</li>

</ol>

  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="icon-grid"></i> Data
            </div>


            <div class="box-header">
                <div class="row">
                  <div class="col-md-6 text-left">
                    
                  </div>
                  <div class="col-md-6 text-right">
                         <button type="button" onclick="location.href='media.php?inventori=stok_buka&modul=new'" class="btn btn-primary btn-xs"><span class="fa fa-clone"></span> Tambah Data</button>    
                  </div>
                </div>
            </div>
            <div class="card-block">


              <table  class="table">
                <thead>
                <tr>
                
                   <th>Departemen</th>
                   <th>No Buka</th>
				            <th>Tanggal</th>
                   <th >Nama Brand</th>
                   <th >Qty</th>
                   <th >Owned By</th>                  
                </tr>
                </thead>
                <tbody>
             <?php
                 $res=pg_query($dbconn,"select h.doc_no,h.createddate,l.qty, d.nama as \"nama_departemen\" , 
              u.username as \"username\", l.nama_brand as \"nama_brand\" 
                from stok_buka_hdr as h
                LEFT OUTER JOIN stok_buka_qty as l on l.id_buka_stok_hdr = h.id
                LEFT OUTER JOIN stok_buka_batch as b on b.id_stok_buka_hdr = h.id
                LEFT OUTER JOIN inv_departemen as d on d.id = h.id_departemen
               
                LEFT OUTER JOIN auth_users as u on u.id_users = h.id_users");

                 while ($row=pg_fetch_assoc($res)) {
                     ?>
                       <tr>
                       
                        <td ><?php echo $row['nama_departemen'] ?></td>
                        <td ><?php echo $row['doc_no'] ?></td>
                        <td ><?php echo $row['createddate'] ?></td>
                        <td ><?php echo $row['nama_brand'] ?></td>
                        <td ><?php echo $row['qty'] ?></td>
                        <td ><?php echo $row['username'] ?></td>
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>
              

              </table>
             
            </div>
            </div>
          </div>
          </div>
          </div>
          </div>
        