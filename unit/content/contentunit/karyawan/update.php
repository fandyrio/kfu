<?php
  $id=$_GET['id'];
  $result=pg_query($dbconn,"SELECT * FROM master_karyawan WHERE id='".$id."' ");
  $data = pg_fetch_array($result);
  
  $j=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_karyawan_jabatan WHERE id='$data[id_jabatan]'"));
  
  $tanggal_lahir=DateToIndo($data['tanggal_lahir']);
  $mulai_kerja=DateToIndo($data['mulai_kerja']);
  
  $a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_jenkel WHERE id='$data[id_jenkel]'"));
  $nama_jenkel=$a['nama'];
  
  $a=pg_fetch_array(pg_query($dbconn,"SELECT nama FROM master_departemen WHERE id='$data[id_departemen]'"));
  $nama_departemen=$a['nama'];
?>    
<div class="card-header d-flex align-items-center">
  <h3 class="h4">Detail</h3>
</div>
<div class="card-body">
  <table class="table table-sm">
    <tr>
      <td width="180px">Nama</td><td width="20px">:</td><td><?php echo $data['nama'];?></td>
    </tr>
    <tr>
      <td>Tempat/Tanggal Lahir</td><td width="20px">:</td><td><?php echo "$data[tempat_lahir] / $tanggal_lahir";?></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td><td width="20px">:</td><td><?php echo "$nama_jenkel";?></td>
    </tr>
    <tr>
      <td>Telepon</td><td width="20px">:</td><td><?php echo $data['telepon'];?></td>
    </tr>
    <tr>
      <td>Email</td><td width="20px">:</td><td><?php echo $data['email'];?></td>
    </tr>
    <tr>
      <td>Mulai Kerja</td><td width="20px">:</td><td><?php echo $mulai_kerja;?></td>
    </tr>
    <tr>
      <td>Jabatan</td><td width="20px">:</td><td><?php echo $j['nama'];?></td>
    </tr>
    <tr>
      <td>Departemen</td><td width="20px">:</td><td><?php echo $nama_departemen;?></td>
    </tr>
    <tr>
      <td>Foto</td><td width="20px">:</td><td>
      <img src="../images/pegawai/<?php echo $data['foto']?>" width="120px" class="img-fluid">
      </td>
    </tr>
  </table>
</div>
<div class="card-footer">
   <button type="button" value="batal" class="btn btn-sm btn-primary " onClick="window.location='media.php?content=karyawan';" >Kembali</button>
</div>