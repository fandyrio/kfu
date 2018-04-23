<?php
unset($_SESSION['id_grn_hdr']);
unset($_SESSION['id_grn_ln']);
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="">Terima Barang</a></li>
  <li class="breadcrumb-item active">Tambah Terima Barang</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
     
              <?php include "content/terimabarang/head.php"; ?>
              
            
       
        <!--  <input type="text" id="angka_tunai" name="angka_tunai" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required> -->

          <!-- Custom Tabs -->
            		  <div class="ghost_batch"></div>
                  <div class="col-md-12 mb-4 angel">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home"> Tambah Detail</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bar" role="tab" aria-controls="bar">Batch</a>
                                </li>
                        
                        
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                  <div id="terima_barang">
                                  </div>
                                </div>
                                <div class="tab-pane" id="bar" role="tabpanel">
                                   <div id="batch_grn">
      
                                </div>
                                </div>
                
                            </div>
                           
                   </div>
          
		
        
      
      <!-- /.row -->
       <div class="box-footer text-right">
        </div>


</div>
  </div>
  </div>
  </div>

<script src="assets/js/action/grn.js"></script>
<script>
// Get the modal
var modal = document.getElementById('mit_pop_up');
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

// When the user clicks anywhere outside of the modal, close it
/*window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}*/
</script>