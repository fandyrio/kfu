<style>
 /* The Modal (background) */
.melayang {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.melayang-content {
    background-color: #fefefe;
    margin: 15%  auto; /* 15% from the top and centered */
    padding: 30px;
    border: 1px solid #888;
    width: 60%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
} 
</style>                <!-- <button  id="grn_load" class="btn-xs btn-warning">Load</button> -->
                <!--button name="btn" class=" btn-warning btn-xs" id="grn_load" data-backdrop="true" data-toggle="modal" data-target="#confirm-submit">Load</button -->
                <?php 
                if(!$_SESSION['id_grn_hdr']){ ?>
                  <button  class="btn btn-xs btn-warning" id="Load">Load</button>
                <?php }?>
                <button  id="add_grn" class="btn btn-xs btn-primary">Tambah</button>
                  <table id="grn_ln_loader" class="table table-bordered table-striped">
                      <thead>
                      <tr >
                      <th width="10px" style="text-align: center;">No</th>
                        <th width="" style="text-align: center;">Nama Brand</th>
                        <th width="" style="text-align: center;">Qty</th>
                        <th width="" style="text-align: center;">Satuan</th>
                        <th width="" style="text-align: center;">Gross</th>
                        <th width="" style="text-align: center;">Diskon</th>
                        <th width="" style="text-align: center;">Pajak</th>
                        <th width="" style="text-align: center;">Nett</th>
                         <th></th>
                        
                      </tr>
                      </thead>
                      <tbody>
                   <?php
                       $no = 0;
                       $totalgross = 0;
                       if($_SESSION['id_grn_hdr']){
                          $res=pg_query($dbconn,"Select grn_ln.*, inv_satuan.nama  as  \"nama_satuan\" from grn_ln
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan WHERE  grn_ln.id_hdr='".$_SESSION['id_grn_hdr']."' ") ;
                       }
                       else{
                       $res=pg_query($dbconn,"Select grn_ln.*, inv_satuan.nama  as  \"nama_satuan\" from grn_ln
                       INNER JOIN inv_satuan on inv_satuan.id=grn_ln.id_satuan WHERE grn_ln.id_users='".$_SESSION['id_users']."'");
                     }
                      $jlh = pg_num_rows($res);
                    

                       while ($row=pg_fetch_assoc($res)) {
                        $no++;
						 //$jum +=;
						        $totalgross += $row["nett_total"];
                           ?>
                             <tr id="<?php echo $row['id']; ?>" data="<?php echo $row['id_satuan']."_".$row['nama_satuan']; ?>" nama="<?php echo $row['nama_brand']; ?>" style="td {color: blue; background: white !important; }">
                              <td style="text-align: left;"><?php echo $no ?></td>
                              <td style="text-align: left;"><?php echo $row["nama_brand"] ?></td>
                              <td style="text-align: right;"><?php echo $row["qty"] ?></td>
                              <td style="text-align: left;"><?php echo $row["nama_satuan"] ?></td>
                              <td style="text-align: right;"><?php echo number_format($row["gross_total"] ,0,",",".");?></td>
                              <td style="text-align: right;">
              							  <?php 
              							  if($row["diskon_persen"] ){
              								  echo $row["diskon_persen"];
              							  }
              							  else echo $row["diskon_amount"];
              								  ?>
              							  </td>
                                            <td style="text-align: right;">
              							  <?php 
              							  if($row["pajak_persen"] ){
              								  echo $row["pajak_persen"];
              							  }
              							  else echo $row["pajak_amount"];
              								  ?>
              							  </td>
                            <td style="text-align: right;"><?php  echo  number_format($row["nett_total"],0,",",".");?></td>
              							<td class="text-center" style="vertical-align:middle;">
                                          <a id="<?php echo $row['id'] ?>" class="btn btn-warning btn-xs edit_grn_ln"><i class="icon-note" aria-hidden="true"></i></a>
                                          <a id="<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger btn-xs hapus_grn_ln"><i class="icon-trash" aria-hidden="true"></i></a>
              							</td>
                             
                              </tr>
                          
                       
                       <?php } ?> 

                      </tbody>
                       <input type="hidden" id="jlh_ln" value="<?php echo $jlh ?>">
					  
                    </table>

                
                  <div class="row">
                      <div class="col-md-7"> </div>
                    <div class="col-md-5">                   
              	
                        <div class="form-horizontal "> 

                           	<div class="form-group row " >
                              <label for="jm" class="col-sm-3 form-control-label">Gross Total</label>
                               <div class="col-sm-5">
                                  <input id="gross_total"  type="text" name="gross_total" value="<?php echo number_format($totalgross,0, ',', '.'); ?>" placeholder="0" class="form-control text-right" readonly>
                              </div>
                            </div>
                            <div class="form-group row" >
                              <label for="jm" class="col-sm-3 form-control-label ">Diskon %</label>
                               <div class="col-sm-7 row">
                                  	<input id="check_diskon" class="col-md-1" type="checkbox" checked name='check_diskon' >
                                  	<div class="col-sm-4 row">
                  									<input id="persen_diskon"  class=" form-control"  type="text" name='disc_persen' onchange="hitung_net_cost()" >
                  									</div>
									                 <div class="col-sm-4 row">
		                              <input id="diskon_amount" name='disc_amount'  disabled  onchange="hitung_net_cost()" class="form-control">
		                            </div>
											
                              </div>
                           
                            </div>

                             <div class="form-group row" >
                              <label for="jm" class="col-sm-3 form-control-label">Pajak %</label>
                               <div class="col-sm-7 row">
                                  	<input id="check_pajak" class="col-md-1" type="checkbox" checked name='check_pajak'>
                                  	<div class="col-sm-4 row">
                  									<input id="persen_pajak" type="text" name='persen_pajak' class=" form-control"   onchange="hitung_net_cost()">
                  									</div>
									                 <div class="col-sm-4 row">
		                               <input id="pajak_amount" name='pajak_amount'   disabled  onchange="hitung_net_cost()" class="form-control"> 
		                                </div>
											
                              </div>
                           
                            </div>

                             <div class="form-group row" >
                              <label for="jm" class="col-sm-3 form-control-label">Net Cost</label>
                                <div class="col-sm-5">
                                  	<input type="hidden" id="net_total" name="net_total"  class="form-control text-right" readonly value="<?php echo $totalgross; ?>">	
                                    <input type="text" id="net_total_show" name="net_total_show"  class="form-control text-right" readonly value="<?php echo number_format($totalgross,0,',','.'); ?>">
                              </div>
                           
                            </div>

 


                            </div>
					 
					   </div>
					  </div>


          <!-- The Modal -->
          <div id="mit_pop_up" class="melayang">

            <!-- Modal content -->
            <div class="melayang-content">
              <span class="close">&times;</span>
               <div class="form-horizontal" >
                <div class="card-block" style="margin-left: 100px !important;">
              <div class="row resultload">   </div>
            </div>
            </div>
              
              

          
              <button  id="add_load_grn" class=" btn btn-xs btn-primary">Simpan</button>
            </div>

          </div>
<script>
  $('body').on('click', '#Load', function (){
        var supp= $('#supplier_po').val();
        var departemen= $('#id_departemen').val();
        if(!supp){
          alert("PILIH DULU SUPPLIER");
          return;
        }
        if(!departemen){
          alert("Pilih Dulu Departemen");
          return;
        }
        $('#mit_pop_up').css("display", "block");
         $(".resultload").load("media.php?ajax=loader_po_to_grn&supp="+supp+"&departemen="+departemen);
   
      
});
$('body').on('click', '.close', function (){
        
        $('#mit_pop_up').css("display", "none");
   
      
});
$('body').on('click', '#add_load_grn', function (){
 
  var batch           =   $('#no_batch_po').val(); 
  var load_id_po      =   $('#load_id_po').val(); 
  var res = load_id_po.split("_");

  var po_qty          =   $('#po_qty').val(); 
  var tgl_manufacture =   $('#tgl_manufacture').val(); 
  var tgl_expired     =   $('#tgl_expired').val(); 
  var data = "load_id_po="+res[0]+"&nama_brand="+res[1]+"&po_qty="+po_qty+"&tgl_manufacture="+tgl_manufacture+"&tgl_expired="+tgl_expired+"&no_batch="+batch+"&satuan="+res[2];
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_po_to_grn",
               data:data,
               success: function(data) {
               alert(data);
                $('#mit_pop_up').css("display", "none");
                $("#terima_barang").load("media.php?ajax=grn_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
    })
       
});
/// Get the modal
/*var modal = document.getElementById('mit_pop_up');
var id_departemen = document.getElementById('id_departemen').value;
var id_supplier = document.getElementById('supplier_po').value;

// Get the button that opens the modal
var btn = document.getElementById("Load");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
    alert(id_departemen);
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
*/
// When the user clicks anywhere outside of the modal, close it
/*window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}*/
</script>

			
			