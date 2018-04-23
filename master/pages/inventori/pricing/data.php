  <?php
  	if(isset($_POST['simpan'])){

 	$id_level = $_POST['id_level'];
 	$metode_harga = $_POST['metode_harga'];
    $harga = 'ARRAY['. implode(',', $_POST['harga']). ']';
    $id_layanan = 'ARRAY['. implode(',', $_POST['id_layanan']). ']';

    $sql =pg_query($dbconn, "INSERT INTO inv_kategori_harga(id_generik, id_brand,metode_harga, harga, id_layanan ) 
                         select 1,1 ,'".$metode_harga."' ,*
					from unnest($harga, $id_layanan)");

    /*$edit = "('".implode("','",array_values($_POST['edit']))."')";
    $hapus = "('".implode("','",array_values($_POST['hapus']))."')";
    $lihat = "('".implode("','",array_values($_POST['lihat']))."')";

    $post = 'ARRAY['. implode(',', $_POST['id_modul']). ']';

    $cek = pg_query($dbauth, "SELECT * FROM akses WHERE id_level ='".$id_level."'");
    
    if(pg_num_rows($cek>0))
    {     
    }else{
      $sql =pg_query($dbauth, "INSERT INTO akses(id_level, id_modul) 
                          SELECT $id_level id, x
                          FROM unnest($post) x");
      $result =pg_query($dbauth, "UPDATE akses SET tambah='1' WHERE id_modul in $tambah AND id_level='".$id_level."'");
      $edit =pg_query($dbauth, "UPDATE akses SET edit='1' WHERE id_modul in $edit AND id_level='".$id_level."'");
      $hapus =pg_query($dbauth, "UPDATE akses SET hapus='1' WHERE id_modul in $hapus AND id_level='".$id_level."'");
      $lihat =pg_query($dbauth, "UPDATE akses SET lihat='1' WHERE id_modul in $lihat AND id_level='".$id_level."'");

    }*/
}


  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Inventory
      </h1>
      <ol class="breadcrumb">
        <li><a href="media.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Obat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
			    <div class="row">
			     <div class="col-xs-12">

        <form method="post">
    
                <div class="col-md-6 ">
					<div class="box-body">
	                 <div class="form-group" style="margin-bottom:55px !important;">
	                    <label class="col-sm-3">Metode Harga</label>
						<div class="col-sm-9">
	                      <select name='metode_harga' class='form-control' required>
	                      
	                      <option value='S'>Harga Standar</option>
	                      <option value='M'>Harga Markup</option>
	                      
	                      </select>
						</div>
	                  </div>
					   <div class="form-group" style="margin-bottom:5px !important;">
	                    <label class="col-sm-3">Harga Layanan</label>
						<div class="col-sm-9">

				               <table id="example1" class="table table-bordered table-striped">
				                <thead>
				                </thead>
				                <tbody>
				             <?php
				             //var_dump($sql);
				             //echo $id_layanan;
				             //echo $id_layanan;
				             

				                 $res=pg_query($dbconn,"Select * from inv_kategori_layanan");

				                 while ($row=pg_fetch_assoc($res)) {

				                     ?>
				                       <tr>
				                        <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id'] ?>"  name="id_layanan[]"  /></td>
				                        <td style="vertical-align:middle;"><?php echo $row["nama"] ?></td>
				                        <td>
				                        <input type="text" name="harga[]" placeholder="Rp" disabled /></td>
				                   
				                       
				                        </tr>
				                    
				                 
				                 <?php } ?> 
				                </tbody>

				              </table>
						</div>
	                  </div>
					  
					  </div>

					<div class="box-footer">
		                <input type="submit" name="simpan" class="btn btn-success" value="SIMPAN"></input>
		              </div>
				  </div>

</form>
            </div>
			</div>
			</section>
			</div>