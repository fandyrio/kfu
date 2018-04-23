<?php
include "koneksi.php";

$aksi="module/pegawai/pegawai_aksi.php";


switch($_GET[aksi]){
default:
?>
<!--MENAMPILKAN DATA MASTER pegawai-->			


	<div class="box box-solid box-info">
		<div class="box-header">
		<h3 class="btn btn-sm disabled box-title">
		<i class="fa fa-user-md"></i>
		Data Pegawai </h3>
		<a class="btn btn-sm btn-default pull-right" href="?module=pegawai&aksi=tambah">
		<i class="fa  fa-plus"></i> Tambah Data pegawai</a>	
		</div>		
	<div class="box-body">
	<table id="example1" class="table table-bordered table-striped">
<thead>
	<tr class="text-green">
		<th>NIP</th>
		<th>Nama pegawai</th>
		<th>JK</th> 
		<th>Tempat/Tgl. Lahir</th> 
		<th>No. HP</th> 
		<th>Email</th>
		<th>Tgl. Masuk</th>
		<th>Aksi</th>
	</tr>
</thead>

<tbody>
<?php 
// Tampilkan data dari Database
$sql = "SELECT * FROM pegawai";
$tampil = pg_query($dbconn,$sql);
$no=1;
while ($data = pg_fetch_array($tampil)) { 
$Kode = $data['nip'];?>

	<tr>
	<td><a href="?module=pegawai&aksi=detail_pegawai&nip=<?php echo $data['nip'];?>"><?php echo $data['nip']; ?></a></td>
	<td><?php echo $data['nm_pegawai']; ?></td>
	<td><?php echo $data['jk']; ?></td>
	<td><?php echo $data['tpt_lhr'] .", ". IndonesiaTgl($data['tgl_lhr']); ?></td>
	<td><?php echo $data['no_hp']; ?></td>
	<td><?php echo $data['email']; ?></td>	
	<td><?php echo IndonesiaTgl($data['tgl_msk']); ?></td>
	<td align="center">
	<a class="btn btn-xs btn-info"   data-toggle="tooltip" title="Edit Data <?php echo $data['nip'];?>" href="?module=pegawai&aksi=edit&nip=<?php echo $data['nip'];?>"><i class="glyphicon glyphicon-edit"></i></a>
	<a class="btn btn-xs btn-warning"   data-toggle="tooltip" title="Hapus Semua Data Pegawai" href="<?php echo $aksi ?>?module=pegawai&aksi=hapus&nip=<?php echo $data['nip'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
	</td>
	<?php
	}
	?>
	</tr>
			</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<?php 
break;


case "tambah": 
?>
      <form class="form-horizontal" action="<?php echo $aksi?>?module=pegawai&aksi=tambah" role="form" method="post">             

      <div class="box box-solid box-info">
          <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-user-md"></i> Informasi Pegawai </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i></a>
          		</div>	
          	<div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 control-label">NIP</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" required="required" name="nip" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Nama Pegawai</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" required="required" name="nm_pegawai" placeholder="Nama pegawai">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Tempat & Tgl. Lahir</label>
              <div><div class="col-sm-2">
                <input type="text" class="form-control" required="required" name="tpt_lhr" placeholder="Tempat Lahir">
          	</div>
          	<div class="col-sm-3">
          	  <div class="input-group">
          	<div class="input-group-addon">
                 <i class="fa fa-calendar"> </i>
              </div>
                <input type="date" class="form-control" required="required" data-toggle="tooltip" title="Format: yyyy/dd/mm" name="tgl_lhr">
          	</div><!-- /.input group -->
          	</div></div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Jenis Kelamin</label>
              <div class="col-sm-5">
          	  <input name="jk" class="minimal" type="radio" value="Laki-laki" checked> Laki-laki &nbsp;&nbsp;
          	  <input name="jk" class="minimal" type="radio" value="Perempuan"> Perempuan
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Agama</label>
              <div class="col-sm-5">	
              <select name="agama" class="form-control"><option> Pilih Agama</option>
          	<option name="agama" value="Islam"> Islam </option><option name="agama" value="Kristen Protestan"> Kristen Protestan </option>
          	<option name="agama" value="Kristen Katolik"> Kristen Katolik </option><option name="agama" value="Hindu"> Hindu </option>
          	<option name="agama" value="Budha"> Budha </option>
          	</select>
              </div>
            </div>
          <div class="form-group">
              <label class="col-sm-4 control-label">Alamat</label>
              <div class="col-sm-5">
                <textarea rowspan="2" class="form-control" name="alamat"></textarea>
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Nomor HP</label>
              <div class="col-sm-5">
                <input type="number" class="form-control"  name="no_hp" placeholder="08xx xxx xxxx">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Email</label>
              <div class="col-sm-5">
                <input type="email" class="form-control"  name="email" placeholder="">
              </div>
            </div></div>
        </div> 

      <div class="box box-solid box-info">
        <div class="box-header">
        <h3 class="btn btn disabled box-title">
        <i class="glyphicon glyphicon-briefcase"></i> Informasi Pekerjaan Pegawai </h3>
        	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
        	<i class="fa fa-minus"></i></a>
        		</div>
        <?php
          $hasil = pg_query("SELECT max(no_sk) as terakhir from sk_krj"); $data = pg_fetch_array($hasil);
          $lastID = $data['terakhir']; $lastNoUrut = substr($lastID,13, 20); $nextNoUrut = $lastNoUrut + 1;
          $nextID = "SK/ZT/".date('m/y')."/".sprintf("%05s",$nextNoUrut);
        ?>
        	<div class="box-body">
        <div class="form-group">
            <label class="col-sm-4 control-label">Tgl. Masuk</label>
            <div>
        	<div class="col-sm-5">
        	  <div class="input-group">
        	<div class="input-group-addon">
                    <i class="fa fa-calendar"> </i>
            </div>
              <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required="required" name="tgl_msk">
        	</div></div></div></div>
        	<div class="form-group">
            <label class="col-sm-4 control-label">Nomor SK Pegawai</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" data-toggle="tooltip" title="Nomor SK Baru" value="<?php echo $nextID; ?>"required="required" name="no_sk">
            </div></div>
            <div class="form-group">
            <label class="col-sm-4 control-label">Unit Kerja</label>
            <div class="col-sm-5">
        <select name="unit_krj" class="form-control">
        <option value=" "> -- Pilih Unit Kerja -- </option>
        <?php $q = pg_query ("select * from unit_krj");
        while ($k = pg_fetch_array($q)){ ?>
        <option value="<?php echo $k['id_unit_krj']; ?>" 
        <?php (@$h['unit_krj']==$k['unit_krj'])?print(" "):print(""); ?>	> <?php echo $k['id_unit_krj']; echo " / ".$k['nm_unit_krj']; ?>
        </option> <?php	} ?>
        </select>
          </div></div>  
          <div class="form-group">
            <label class="col-sm-4 control-label">Jabatan</label>
            <div class="col-sm-5">	
        <select name="jabatan" class="form-control">
        <option value=" "> -- Pilih Jabatan -- </option>
        <?php $q = pg_query ("select * from jabatan");
        while ($k = pg_fetch_array($q)){ ?>
        <option value="<?php echo $k['id_jabatan']; ?>" 
        <?php (@$h['jabatan']==$k['jabatan'])?print(" "):print(""); ?>	> <?php echo $k['id_jabatan']; echo " / ".$k['nm_jabatan']; ?>
        </option> <?php	} ?>
        </select>
            </div></div>  
          <div class="form-group">
            <label class="col-sm-4 control-label">Pangkat</label>
            <div class="col-sm-5">
            <select name="pangkat" class="form-control">
                  <option value=" "> -- Pilih pangkat -- </option>
                  <?php $q = pg_query ("select * from pangkat");
                  while ($k = pg_fetch_array($q)){ ?>
                  <option value="<?php echo $k['id_pangkat']; ?>" 
                  <?php (@$h['pangkat']==$k['pangkat'])?print(" "):print(""); ?>	> <?php echo $k['id_pangkat']; echo " / ".$k['nm_pangkat']; ?>
                  </option>
                   <?php	} ?>
            </select>
          </div></div>  

          <div class="form-group">
            <label class="col-sm-4 control-label">Lokasi</label>
            <div class="col-sm-5">
              <select name="lokasi" class="form-control">
                <option value=" "> -- Pilih lokasi -- </option>
                <?php $q = pg_query ("select * from lokasi_krj");
                while ($k = pg_fetch_array($q)){ ?>
                  <option value="<?php echo $k['id_lokasi']; ?>" 
                  <?php (@$h['lokasi']==$k['lokasi'])?print(" "):print(""); ?>	> <?php echo $k['id_lokasi']; echo " / ".$k['nm_lokasi']; ?>
                  </option> 
                  <?php	} ?>
              </select>
            </div></div>  

        <div class="form-group">
            <label class="col-sm-4 control-label">Status Pegawai</label>
            <div class="col-sm-5">
        	  <input name="status" class="minimal" type="radio" value="aktif" checked> Aktif &nbsp;&nbsp;
        	  <input name="status" class="minimal" type="radio" value="nonakti"> Nonaktif
            </div></div>		
        </div>
      </div>	

      <div class="box box-solid box-info">
        <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-mortar-board "></i> Informasi Pendidikan </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i>
          	</a></div>	
          	<div class="box-body">
          	<?php
          for ($i= 1; $i <= 3; $i++) { ?>
          <div class="form-group">
              <label class="col-sm-3 control-label">Jenjang/Nama Sekolah </label>
              <div><div class="col-sm-2">
              <select name="jjg[]" class="form-control">
                	<option value=""> Pilih Jenjang</option>	
                <?php $q = pg_query ("select * from jjg");
                while ($k = pg_fetch_array($q)){ ?>
                    <option value="<?php echo $k['nm_jjg']; ?>" 
                    <?php (@$h['jjg']==$k['jjg'])?print(" "):print(""); ?>	> <?php echo $k['nm_jjg']; ?>
                    </option>
                 <?php	} ?>
          	</select>
          	</div><div class="col-sm-3">
          	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Sekolah" placeholder="Nama Sekolah"   name="nm_jjg[]">
          	</div><div class="col-sm-3">
          	  <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>
                <input type="text" class="form-control"   data-toggle="tooltip" maxlength="9" title="Format: 2000-2006" placeholder="Tahun"   name="thn_jjg[]">
          	</div><!-- /.input group -->
          	</div></div></div>
          <?php } ?>	
          <div class="form-group">
          <div id="main">
              <div class="my-form">
                      <center>
          			<p class="text-box">
                          <a class="add-box btn btn-primary"" href="#"> <i class="fa fa-plus"> </i> Tambah</a>
                      </p></center>
              </div>
          </div>
          <script type="text/javascript">
          jQuery(document).ready(function($){
              $('.my-form .add-box').click(function(){
                  var n = $('.text-box').length + 1;
                  if( 5 < n ) {
                      alert('Stop it!');
                      return false;
                  }
                  var box_html = $('<div class="form-group"><label class="col-sm-3 control-label">Jenjang/Nama Sekolah </label><div><div class="col-sm-2"> <select name="jjg[]" class="form-control"><option value=""> Pilih Jenjang</option>	<?php $q = mysql_query ("select * from jjg");while ($k = pg_fetch_assoc($q)){ ?><option value="<?php echo $k['nm_jjg']; ?>" <?php (@$h['jjg']==$k['jjg'])?print(" "):print(""); ?>	> <?php echo $k['nm_jjg']; ?></option> <?php	} ?>	</select></div><div class="col-sm-3">	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Sekolah" placeholder="Nama Sekolah" name="nm_jjg[]"> </div><div class="col-sm-3"> <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>  <input type="text" class="form-control"   data-toggle="tooltip" title="Format: 2000-2006" maxlength="9" placeholder="Tahun"   name="thn_jjg[]"></div></div></div>  <a href="#" class="remove-box btn btn-danger btn-sm "><i class="fa fa-remove"> </i></a></div>');
                  box_html.hide();
                  $('.my-form p.text-box:last').after(box_html);
                  box_html.fadeIn('slow');
                  return false;
              });
              $('.my-form').on('click', '.remove-box', function(){
                  $(this).parent().css( 'background-color', '#' );
                  $(this).parent().fadeOut("slow", function() {
                      $(this).remove();
                      $('.box-number').each(function(index){
                          $(this).text( index + 1 );
                      });
                  });
                  return false;
              });
          });
          </script>
          </div>
          </div>
      </div>	


      <div class="box box-solid box-info">
          <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-puzzle-piece"></i> Pengalaman Pekerjaan </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i>
          	</a>
           
          		</div>	
          	<div class="box-body">
          <div class="form-group">
              <label class="col-sm-1 control-label"></label>
              <div>
            <div class="col-sm-4">
                    <input type="text" class="form-control"  data-toggle="tooltip" title="Pekerjaan" placeholder="Pekerjaan" name="pekerjaan[]">
          	</div>
            <div class="col-sm-3">
          	   <input type="text" class="form-control"  data-toggle="tooltip" title="Nama Perusahaan" placeholder="Nama Perusahaan" name="nm_pt[]">
          	</div>
            <div class="col-sm-3">
            	  <div class="input-group">
            	   <div class="input-group-addon">
                   <i class="fa fa-calendar"> </i>
                </div>
                  <input type="text" class="form-control"   data-toggle="tooltip" maxlength="9"title="Format: 2000-2006" placeholder="Tahun" name="thn_krj[]">
            	 </div><!-- /.input group -->
          	</div>
            </div>
          </div>
          <div class="form-group">
          <div id="main">
              <div class="form-ku">
                      <center>
          			<p class="text-itan">
                          <a class="ad-box btn btn-sm btn-primary"" href="#"> <i class="fa fa-plus"> </i> Tambah</a>
                      </p></center>
              </div>
          </div>
          <script type="text/javascript">
              jQuery(document).ready(function($){
                  $('.form-ku .ad-box').click(function(){
                      var n = $('.text-itan').length + 1;
                      if( 5 < n ) {
                          alert('Stop it!');
                          return false;
                      }
                      var box_html = $('<div class="form-group"> <label class="col-sm-1 control-label"></label>    <div><div class="col-sm-4">    <input type="text" class="form-control"  data-toggle="tooltip" title="Pekerjaan" placeholder="Pekerjaan" name="pekerjaan[]">	</div><div class="col-sm-3">	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Perusahaan" placeholder="Nama Perusahaan" name="nm_pt[]">	</div><div class="col-sm-3">	  <div class="input-group">	<div class="input-group-addon">       <i class="fa fa-calendar"> </i>    </div>      <input type="text" class="form-control"   data-toggle="tooltip" maxlength="9"title="Format: 2000-2006" placeholder="Tahun" name="thn_krj[]">	</div> 	</div></div>  <a href="#" class="hapus-box btn btn-danger btn-sm "><i class="fa fa-remove"> </i></a></div>');
                      box_html.hide();
                      $('.form-ku p.text-itan:last').after(box_html);
                      box_html.fadeIn('slow');
                      return false;
                  });
                  $('.form-ku').on('click', '.hapus-box', function(){
                      $(this).parent().css( 'background-color', '#' );
                      $(this).parent().fadeOut("slow", function() {
                          $(this).remove();
                          $('.box-number').each(function(index){
                              $(this).text( index + 1 );
                          });
                      });
                      return false;
                  });
              });
          </script>

          </div>  
          </div>
      </div>
      	
        <div class="form-group">
          <label class="col-sm-4"></label>
          <div class="col-sm-5">
            	<hr/>
            <button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> <i>Reset</i></button>
            <a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>			 
          </div>
        </div> 
      </form>


<?php
break;
case "edit":
$data=pg_query($dbconn,"select * from pegawai p, sk_krj s where p.nip=s.nip and p.nip='$_GET[nip]'");
$edit=pg_fetch_array($data);
?>

<form class="form-horizontal" action="<?php echo $aksi?>?module=pegawai&aksi=edit" role="form" method="post">             

      <div class="box box-solid box-info">
        <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-user-md"></i> Edit Informasi Pegawai </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i></a>
          		</div>	
          	<div class="box-body">  
            <div class="form-group">
              <label class="col-sm-4 control-label">NIP</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" readonly value="<?php echo $edit['nip']; ?>" name="nip" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Nama Pegawai</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" value="<?php echo $edit['nm_pegawai']; ?>" name="nm_pegawai" placeholder="Nama pegawai">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Tempat & Tgl. Lahir</label>
              <div><div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $edit['tpt_lhr']; ?>" name="tpt_lhr" placeholder="Tempat Lahir">
          	</div>
          	<div class="col-sm-3">
          	  <div class="input-group">
          	<div class="input-group-addon">
                 <i class="fa fa-calendar"> </i>
              </div>
                <input type="date" class="form-control" value="<?php echo $edit['tgl_lhr']; ?>" data-toggle="tooltip" title="Format: yyyy/dd/mm" name="tgl_lhr">
          	</div><!-- /.input group -->
          	</div></div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Jenis Kelamin</label>
              <div class="col-sm-5">
          	  <input  class="minimal" name="jk" type="radio" value="Laki-laki" <?php if(($edit['jk'])== "Laki-laki")
          				{echo "checked=\"checked\"";};?>/> Laki-laki &nbsp;&nbsp;
          	  <input class="minimal" name="jk" type="radio" value="Perempuan" <?php if(($edit['jk'])== "Perempuan")
          				{echo "checked=\"checked\"";};?>/> Perempuan
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Agama</label>
              <div class="col-sm-5">	
              <select name="agama" class="form-control"><option> Pilih Agama</option>
          	<option name="agama" value="Islam" <?php if(($edit['agama'])== "Islam")
          				{echo "selected=\"selected\"";};?>> Islam </option>
          			<option name="agama" value="Kristen Protestan" <?php if(($edit['agama'])== "Kristen Protestan")
          				{echo "selected=\"selected\"";};?>> Kristen Protestan </option>
          	<option name="agama" value="Kristen Katolik" <?php if(($edit['agama'])== "Kristen Katolik")
          				{echo "selected=\"selected\"";};?>> Kristen Katolik </option>
          			<option name="agama" value="Hindu" <?php if(($edit['agama'])== "Hindu")
          				{echo "selected=\"selected\"";};?>> Hindu </option>
          	<option name="agama" value="Budha" <?php if(($edit['agama'])== "Budha")
          				{echo "selected=\"selected\"";};?>> Budha </option>
          	</select>
              </div>
            </div>
          <div class="form-group">
              <label class="col-sm-4 control-label">Alamat</label>
              <div class="col-sm-5">
                <input rowspan="2" class="form-control" value="<?php echo $edit['alamat']; ?>" name="alamat">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Nomor HP</label>
              <div class="col-sm-5">
                <input type="number" class="form-control"  name="no_hp" value="<?php echo $edit['no_hp']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label">Email</label>
              <div class="col-sm-5">
                <input type="email" class="form-control"  name="email" value="<?php echo $edit['email']; ?>">
              </div>
            </div></div>
      </div>

      <div class="box box-solid box-info">
          <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="glyphicon glyphicon-briefcase"></i> Informasi Pekerjaan Pegawai </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i></a>
          		</div>	
          	<div class="box-body">
          <div class="form-group">
              <label class="col-sm-4 control-label">Tgl. Masuk</label>
              <div>
          	<div class="col-sm-5">
          	  <div class="input-group">
          	<div class="input-group-addon">
                      <i class="fa fa-calendar"> </i>
              </div>
                <input type="date" class="form-control" value="<?php echo $edit['tgl_msk'];?>" name="tgl_msk">
          	</div></div></div></div>
          <?php $sql = "SELECT * FROM sk_krj where nip='$_GET[nip]' and status_sk='aktif'";
          $tampil = pg_query($sql);
          while ($data = pg_fetch_array($tampil)) { 	?>
          	<div class="form-group">
              <label class="col-sm-4 control-label">Nomor SK Pegawai</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" readonly  value="<?php echo $data['no_sk'];?>" name="no_sk">
              </div></div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Unit Kerja</label>
              <div class="col-sm-5">
          <select name="unit_krj" class="form-control">
          <option value=" "> -- Pilih Unit Kerja -- </option>
          <?php $q = pg_query ("select * from unit_krj");
          while ($k = pg_fetch_array($q)){ ?>
          <option value="<?php echo $k['id_unit_krj']; ?>" <?php if(($k['id_unit_krj'])== ($data['id_unit_krj']))
          				{echo "selected=\"selected\"";};?>
          <?php (@$h['unit_krj']==$k['unit_krj'])?print(" "):print(""); ?>	> <?php echo $k['id_unit_krj']; echo " / ".$k['nm_unit_krj']; ?>
          </option> <?php	} ?>
          </select>
            </div></div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Jabatan</label>
              <div class="col-sm-5">	
          <select name="jabatan" class="form-control">
          <option value=" "> -- Pilih Jabatan -- </option>
          <?php $q = pg_query ("select * from jabatan");
          while ($k = pg_fetch_array($q)){ ?>
          <option value="<?php echo $k['id_jabatan']; ?>" <?php if(($k['id_jabatan'])== ($data['id_jabatan']))
          				{echo "selected=\"selected\"";};?>
          <?php (@$h['jabatan']==$k['jabatan'])?print(" "):print(""); ?>	> <?php echo $k['id_jabatan']; echo " / ".$k['nm_jabatan']; ?>
          </option> <?php	} ?>
          </select>
              </div></div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Pangkat</label>
              <div class="col-sm-5">
          <select name="pangkat" class="form-control">
          <option value=" "> -- Pilih pangkat -- </option>
          <?php $q = pg_query ("select * from pangkat");
          while ($k = pg_fetch_array($q)){ ?>
          <option value="<?php echo $k['id_pangkat']; ?>" <?php if(($k['id_pangkat'])== ($data['id_pangkat']))
          				{echo "selected=\"selected\"";};?>
          <?php (@$h['pangkat']==$k['pangkat'])?print(" "):print(""); ?>	> <?php echo $k['id_pangkat']; echo " / ".$k['nm_pangkat']; ?>
          </option> <?php	} ?>
          </select>
            </div></div>  
            <div class="form-group">
              <label class="col-sm-4 control-label">Lokasi</label>
              <div class="col-sm-5">
          <select name="lokasi" class="form-control">
          <option value=" "> -- Pilih lokasi -- </option>
          <?php $q = pg_query ("select * from lokasi_krj");
          while ($k = pg_fetch_array($q)){ ?>
          <option value="<?php echo $k['id_lokasi']; ?>" <?php if(($k['id_lokasi'])== ($data['id_lokasi']))
          				{echo "selected=\"selected\"";};?>
          <?php (@$h['lokasi']==$k['lokasi'])?print(" "):print(""); ?>	> <?php echo $k['id_lokasi']; echo " / ".$k['nm_lokasi']; ?>
          </option> <?php	} ?>
          </select>
              </div></div>  		
          </div>
      </div>

<?php } ?>
      <div class="box box-solid box-info">
          <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-mortar-board "></i> Informasi Pendidikan </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i>
          	</a></div>	
          	<div class="box-body">

          <?php 
          // Tampilkan data dari Database
          $a = pg_query("SELECT * FROM pendidikan where nip='$_GET[nip]'");
          while ($data = pg_fetch_array($a)) { ?>

          <div class="form-group">
              <label class="col-sm-3 control-label">Jenjang/Nama Sekolah </label>
              <div><div class="col-sm-2">
              <select name="jjg[]" class="form-control">
          	<option value=""> Pilih Jenjang</option>
          	<?php $q = pg_query ("select * from jjg");
              while ($k = pg_fetch_array($q)){ ?>
              <option value="<?php echo $k['nm_jjg']; ?>" <?php if(($k['nm_jjg'])== ($data['jenjang']))
              				{echo "selected=\"selected\"";};?>
              <?php (@$h['jjg']==$k['jjg'])?print(" "):print(""); ?>	> <?php echo $k['nm_jjg']; ?>
              </option> <?php	} ?>

              	</select>
          	</div><div class="col-sm-3">
          	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Sekolah" value="<?php echo $data['nm_pendidikan'];?>"   name="nm_jjg[]">
          	<input type="hidden" class="form-control"  value="<?php echo $data['id_pend'];?>"   name="id_pend[]">
          	</div><div class="col-sm-3">
          	  <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>
                <input type="text" class="form-control"   data-toggle="tooltip" title="Format: 2000-2006" maxlength="9"value="<?php echo $data['thn_pend'];?>"   name="thn_jjg[]">
          	</div><!-- /.input group -->
          	</div></div>
          	<a class="hapus-box btn btn-danger btn-sm"   data-toggle="tooltip" title="Hapus Data" href="<?php echo $aksi ?>?module=pegawai&aksi=hapus_pend&id_pend=<?php echo $data['id_pend'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a>
          	</div>

          <?php } ?>
          	
          <div class="form-group">
          <div id="main">
              <div class="my-form">
                      <center>
          			<p class="text-box">
                          <a class="add-box btn btn-primary"" href="#"> <i class="fa fa-plus"> </i> Add More</a>
                      </p></center>
              </div>
          </div>
          <script type="text/javascript">
          jQuery(document).ready(function($){
              $('.my-form .add-box').click(function(){
                  var n = $('.text-box').length + 1;
                  if( 5 < n ) {
                      alert('Stop it!');
                      return false;
                  }
                  var box_html = $('<div class="form-group"><label class="col-sm-3 control-label">Jenjang/Nama Sekolah </label><div><div class="col-sm-2"> <select name="add_jjg[]" class="form-control"><option> Pilih Jenjang</option>	<?php $q = mysql_query ("select * from jjg");while ($k =pg_fetch_array($q)){ ?><option value="<?php echo $k['nm_jjg']; ?>" <?php (@$h['jjg']==$k['jjg'])?print(" "):print(""); ?>	> <?php echo $k['nm_jjg']; ?></option> <?php	} ?>	</select></div><div class="col-sm-3">	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Sekolah" Placeholder="Nama Sekolah" name="add_nm_jjg[]"> </div><div class="col-sm-3"> <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>  <input type="text" class="form-control"   data-toggle="tooltip" title="Format: 2000-2006" maxlength="9"placeholder="Tahun"   name="add_thn_jjg[]"></div></div></div>  <a href="#" class="remove-box btn btn-danger btn-sm "><i class="fa fa-remove"> </i></a></div>');
                  box_html.hide();
                  $('.my-form p.text-box:last').after(box_html);
                  box_html.fadeIn('slow');
                  return false;
              });
              $('.my-form').on('click', '.remove-box', function(){
                  $(this).parent().css( 'background-color', '#' );
                  $(this).parent().fadeOut("slow", function() {
                      $(this).remove();
                      $('.box-number').each(function(index){
                          $(this).text( index + 1 );
                      });
                  });
                  return false;
              });
          });
          </script>
          </div>
          </div>
        </div>	

      <div class="box box-solid box-info">
          <div class="box-header">
          <h3 class="btn btn disabled box-title">
          <i class="fa fa-puzzle-piece"></i> Pengalaman Pekerjaan </h3>
          	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
          	<i class="fa fa-minus"></i>
          	</a>
           
          		</div>	
          	<div class="box-body">
          <?php 
          // Tampilkan data dari Database
          $a = pg_query("SELECT * FROM pengalaman_krj where nip='$_GET[nip]'");
          while ($data = pg_fetch_array($a)) { ?>

          <div class="form-group">
              <label class="col-sm-1 control-label"></label>
              <div><div class="col-sm-4">
          	<input type="text" class="form-control"  data-toggle="tooltip" value="<?php echo $data['nm_krj'];?>"   name="pekerjaan[]">
          	<input type="hidden" class="form-control"  value="<?php echo $data['id_peng_krj'];?>"   name="ids[]">
          	</div>
          	<div class="col-sm-3">
          	<input type="text" class="form-control"  data-toggle="tooltip" value="<?php echo $data['nm_pt'];?>"   name="nm_pt[]">
          	</div>
          	<div class="col-sm-3">
          	  <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>
                <input type="text" class="form-control"   data-toggle="tooltip" maxlength="9"title="Format: 2000-2006" value="<?php echo $data['thn_krj'];?>"   name="thn_krj[]">
          	</div><!-- /.input group -->
          	</div></div>
          	<a class="hapus-box btn btn-danger btn-sm"   data-toggle="tooltip" title="Hapus Data" href="<?php echo $aksi ?>?module=pegawai&aksi=hapus_peng_krj&id_peng_krj=<?php echo $data['id_peng_krj'];?>"  alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA <?php echo $Kode; ?>	?')"> <i class="glyphicon glyphicon-trash"></i></a></div>	

          <?php } ?>
          	<div class="form-group">
          <div id="main">
              <div class="form-ku">
                      <center>
          			<p class="text-itan">
                          <a class="ad-box btn btn-primary"" href="#"> <i class="fa fa-plus"> </i> Add More</a>
                      </p></center>
              </div>
          </div>

          <script type="text/javascript">
              jQuery(document).ready(function($){
                  $('.form-ku .ad-box').click(function(){
                      var n = $('.text-itan').length + 1;
                      if( 5 < n ) {
                          alert('Stop it!');
                          return false;
                      }
                      var box_html = $('<div class="form-group"> <label class="col-sm-1 control-label"></label>    <div><div class="col-sm-4">    <input type="text" class="form-control"  data-toggle="tooltip" title="Pekerjaan" placeholder="Pekerjaan" name="add_pekerjaan[]">	</div><div class="col-sm-3">	<input type="text" class="form-control"  data-toggle="tooltip" title="Nama Perusahaan" placeholder="Nama Perusahaan" name="add_nm_pt[]">	</div><div class="col-sm-3">	  <div class="input-group">	<div class="input-group-addon">       <i class="fa fa-calendar"> </i>    </div>      <input type="text" class="form-control"   data-toggle="tooltip" title="Format: 2000-2006"maxlength="9" placeholder="Tahun" name="add_thn_krj[]">	</div> 	</div></div>  <a href="#" class="hapus-box btn btn-danger btn-sm "><i class="fa fa-remove"> </i></a></div>');
                      box_html.hide();
                      $('.form-ku p.text-itan:last').after(box_html);
                      box_html.fadeIn('slow');
                      return false;
                  });
                  $('.form-ku').on('click', '.hapus-box', function(){
                      $(this).parent().css( 'background-color', '#' );
                      $(this).parent().fadeOut("slow", function() {
                          $(this).remove();
                          $('.box-number').each(function(index){
                              $(this).text( index + 1 );
                          });
                      });
                      return false;
                  });
              });
          </script>

          </div>  
          	</div>
      </div> 
	
  <div class="form-group">
    <label class="col-sm-4"></label>
    <div class="col-sm-5">
	<hr/>
<button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
<button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> <i>Reset</i></button>
<a href="javascript:history.back()" class="btn btn-info pull-right"><i class="fa fa-backward"></i> Kembali</a>			 
    </div>
  </div>
</form>
 
 
<?php
break;

case "detail_pegawai":
    ?>

    <form class="form-horizontal" action="<?php echo $aksi?>?module=pegawai&aksi=edit" role="form" method="post">             
    <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
    	<li class="active"><a class="text-black" href="#data" data-toggle="tab">Info Pegawai</a></li>
    	<li><a class="text-black" href="#data1" data-toggle="tab">Info Pekerjaan</a></li>
    	<li><a class="text-black" href="#data2" data-toggle="tab">Info Pendidikan</a></li>
    	<li><a class="text-black" href="#data3" data-toggle="tab">Pengalaman Kerja</a></li>
    </ul>
     
      <li><a href="javascript:history.back()" class="btn btn-sm bg-navy btn-primary pull-right"><i class="fa fa-backward"></i> Kembali</a>	 </li> 
      <br>
    <div class="tab-content">
    <div class="tab-pane active" id="data">
        <section id="new">
        <div class="box box-solid box-info">
        <div class="box-header">
        <h3 class="btn btn disabled box-title">
        <i class="fa fa-user-md"></i> Informasi Pegawai </h3>
        <div class="pull-right">
        	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
        	<i class="fa fa-minus"></i>
        	</a></div>	</div>	
        	<div class="box-body">
        <?php 
        $data=pg_query("select * from pegawai where nip='$_GET[nip]'");
        $edit=pg_fetch_array($data);
        ?>	
          <div class="form-group">
            <label class="col-sm-4 control-label">NIP </label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled name="nip" value="<?php echo $edit['nip']; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Nama pegawai</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled name="nama" value="<?php echo $edit['nm_pegawai']; ?>">
            </div>
          </div>
        	<div class="form-group">
            <label class="col-sm-4 control-label">Jenis kelamin</label>
            <div class="col-sm-5">
        	  <input type="text" class="form-control" disabled  value="<?php echo $edit['jk'];  ?>">
            </div>
          </div>
          
        <div class="form-group">
            <label class="col-sm-4 control-label">Tempat/Tgl. Lahir</label>
            <div><div class="col-sm-5">
              <input type="text" class="form-control" disabled name="tpt_lhr" value="<?php echo $edit['tpt_lhr']; echo ", ".Indonesia2Tgl ($edit['tgl_lhr']); ?>">
        	</div>
        	</div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-5">
              <textarea rowspan="2" disabled class="form-control" name="alamat"><?php echo $edit['alamat']; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Nomor HP</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $edit['no_hp']; ?>">
            </div></div> 
        <div class="form-group">
            <label class="col-sm-4 control-label">Email</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $edit['email']; ?>">
            </div></div> </div></div></section>
      </div>


    <div class="tab-pane" id="data1">
        <section id="new1">
        <div class="box box-solid box-info">
        <div class="box-header">
        <h3 class="btn btn disabled box-title">
        <i class="glyphicon glyphicon-briefcase"></i> Informasi Pekerjaan Pegawai </h3>
        	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
        	<i class="fa fa-minus"></i>
        	</a></div>	
        	<div class="box-body">
        <?php $d=pg_query("select * from sk_krj s, unit_krj u, lokasi_krj l, pangkat x, jabatan j where s.id_jabatan=j.id_jabatan and s.id_lokasi=l.id_lokasi and s.id_pangkat=x.id_pangkat and s.id_unit_krj=u.id_unit_krj and nip='$_GET[nip]' and s.status_sk='aktif'");
        $e=pg_fetch_array($d);
        ?>	
        <div class="form-group">
            <label class="col-sm-4 control-label">Tanggal Masuk</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo Indonesia2Tgl($edit['tgl_msk']); ?>">
            </div></div> 	
        <div class="form-group">
            <label class="col-sm-4 control-label">Nomor SK</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $e['no_sk']; ?>">
            </div></div> 	
        <div class="form-group">
            <label class="col-sm-4 control-label">Unit Kerja</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $e['nm_unit_krj']; ?>">
            </div></div> 
        <div class="form-group">
            <label class="col-sm-4 control-label">Jabatan / Pangkat</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $e['nm_jabatan']."/".$e['nm_pangkat']; ?>">
            </div></div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Lokasi Kerja</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" disabled value="<?php echo $e['nm_lokasi']." (".$e['alamat_lokasi'].")"; ?>">
            </div></div> </div></div></section>
    </div>

    <div class="tab-pane" id="data2">
      <section id="new2">	
      <div class="box box-solid box-info">
      <div class="box-header">
      <h3 class="btn btn disabled box-title">
      <i class="fa fa-mortar-board "></i> Informasi Pendidikan </h3>
      <div class="pull-right">
      	<a class="btn btn-default btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
      	<i class="fa fa-minus"></i>
      	</a></div></div>	
      	<div class="box-body">
      	<?php 
      // Tampilkan data dari Database
      $sqll = "SELECT * FROM pendidikan where nip='$_GET[nip]'";
      $tampill = pg_query($sqll);
      $no=1;
      while ($dat = pg_fetch_array($tampill)) { ?>
      <div class="form-group">
          <label class="col-sm-3 control-label">Jenjang/Nama Sekolah </label>
          <div><div class="col-sm-2">
      	<input type="text" class="form-control" disabled value="<?php echo $dat['jenjang']; ?>" >
      	</div><div class="col-sm-4">
      	<input type="text" class="form-control" disabled value="<?php echo $dat['nm_pendidikan']; ?>" >
      	</div><div class="col-sm-3">
      	  <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>
            <input type="text" class="form-control"  disabled value="<?php echo $dat['thn_pend']; ?>" >
      	</div><!-- /.input group -->
      	</div></div></div>
      <?php } ?>

      	</div></div></section>
    </div>

    <div class="tab-pane" id="data3">
      <section id="new">	
      <div class="box box-solid box-info">
      <div class="box-header">
      <h3 class="btn btn disabled box-title">
      <i class="fa fa-puzzle-piece"></i> Pengalaman Kerja </h3>
      <div class="pull-right">	
      	<a class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
      	<i class="fa fa-minus"></i>
      	</a></div></div>
      	<div class="box-body"> 
      <?php 
      // Tampilkan data dari Database
      $sq = "SELECT * FROM pengalaman_krj where nip='$_GET[nip]'";
      $tampi = pg_query($sq);
      while ($da = pg_fetch_array($tampi)) { 

      ?>
      <div class="form-group">
      <label class="col-sm-1 control-label"></label>
          <div><div class="col-sm-4">
      	<input type="text" class="form-control" disabled value="<?php echo $da['nm_krj']; ?>" >
      	</div><div class="col-sm-3">
      	<input type="text" class="form-control" disabled value="<?php echo $da['nm_pt']; ?>" >
      	</div><div class="col-sm-3">
      	  <div class="input-group">	<div class="input-group-addon">  <i class="fa fa-calendar"> </i>    </div>
            <input type="text" class="form-control"  disabled value="<?php echo $da['thn_krj']; ?>" >
      	</div><!-- /.input group -->
      	</div></div></div>
      <?php } ?>	
      	</div></div></section>
      </div>   
    </form>

    <?php
break;
} 
?>

</div></div>