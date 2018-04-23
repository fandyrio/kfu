              <div class="col-md-12 mb-4 ">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Add Details</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                          <?php 
              $result =pg_query($dbconn, "select inv_inventori.* , inv_nama_brand.nama as \"nama_brand\" , inv_satuan.nama as \"nama_satuan\" FROM inv_inventori 
                INNER JOIN inv_nama_brand on inv_nama_brand.id=inv_inventori.id_brand
                INNER JOIN inv_satuan on inv_satuan.id=inv_inventori.id_satuan");                             
         ?>  

        <button class="btn btn-xs btn-danger" id="cancel_adj_details">Cancel</button>
        <button name="btn" class="btn btn-warning btn-xs" id="simpan_adj_ln" >Simpan</button>
            <form method="POST" enctype="multipart/form-data" id="adj_ln">
            <input type="hidden" name="id_inv" id="inv_adj">
             <input type="hidden" name='id_satuan' id="id_satuan_adj">
             <input type="hidden" name='brand_nama' id="brand_nama_adj">
             
              <div class="form-horizontal">
              <div class="row">
              <div class="col-md-8">

                    
                     <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Nama brand</label>

                            <div class="col-sm-6">
                               
                                <select name="nama_brand_adj" class='form-control' required>
                                
                                <option value=''>Pilih</option>
                                <?php 
                                while ($row =pg_fetch_assoc($result)){
                                  echo "<option value='".$row['id']."_".$row['nama_brand']."_".$row['nama_satuan']."_".$row['id_satuan']."'>".$row['nama_brand']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                          </div>

                      <div class="form-group row">
                            <label  class="col-sm-2 form-control-label">Reason</label>

                            <div class="col-sm-6">
                             <select name="alasan" class='form-control' required>
                                
                                <option value='hadiah'>Hadiah</option>
                                <option value='berhenti'>berhenti</option>                
                                
                                </select>
                               

                            </div>
                          </div>                 
             

                  <div class="form-group row">
                  <label  class="col-sm-2 form-control-label">Jumlah <span class="ingatan">*</span></label>

                  <div class="col-sm-3">                     
                      <input name='jumlah' class='text-right form-control'  onkeyup="javascript:tandaPemisahTitik(this);count_adj();"   id="jumlah_adj"   required >
                      
                  </div>
                    <div class="col-sm-3">                     
                      <input text="text" id="nama_satuan_adj" name="nama_satuan" class='text-right  form-control' readonly>
                            </div>
                    </div>

                    <div class="minus">
                    <div class="form-group row">
                         <label  class="col-sm-2 form-control-label">Unit Cost  <span class="ingatan">*</span></label>
                           <div class="col-sm-3">                     
                          <input name='unit_cost' id="unit_cost_adj"  required class='form-control text-right' onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);count_adj();" class='form-control text-right' />
                           </div>                            
                     </div>

                    <div class="form-group row">
                         <label  class="col-sm-2 form-control-label">Total Cost </label>
                           <div class="col-sm-3">   <input name='total_cost' class='form-control text-right' onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" text-right' readonly>      
                           </div>                            
                     </div>
                     </div>

                   
                  </div>
                   </div>

                  </div>
                  </form>
                  </div>
                
                  </div>
                           
          </div>


       <!--    <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
              
              <div class="modal-dialog" role="document" style="width: 700px">
                  <div class="modal-content">

                   <div class="modal-body" style="text-align:left">

                    </div>
                    <div class="modal-footer">                    
                    <button type="button" class="btn btn-sm btn-warning" id="save_batch_adj" >oke</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">BATAL</button>
                    </div>
                  </div>
              </div>
          </div> --> 

          <div id="mit_pop_up" class="melayang" >
            <div class="melayang-content">
              <span class="close">&times;</span>
               <div class="form-horizontal" >
                <div class="card-block">
              <div class="row resultload">   </div>          
            </div>
            </div>
            <div class="modal-footer">  
              <button type="button" class="btn btn-sm btn-warning" id="save_batch_adj" >oke</button>
              </div>
              </div>
            </div>         

            <script >
              function tandaPemisahTitik(b){
      var _minus = false;
      if (b<0) _minus = true;
      b = b.toString();
      b=b.replace(".","");
      
      c = "";
      panjang = b.length;
      j = 0;
      for (i = panjang; i > 0; i--){
         j = j + 1;
         if (((j % 3) == 1) && (j != 1)){
           c = b.substr(i-1,1) + "." + c;
         } else {
           c = b.substr(i-1,1) + c;
         }
      }
      if (_minus) c = "-" + c ;
      return c;
    }
    function numbersonly(ini, e){
  if (e.keyCode>=49){
    if(e.keyCode<=57){
    a = ini.value.toString().replace(".","");
    b = a.replace(/[^\d]/g,"");
    b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
    ini.value = tandaPemisahTitik(b);
    return false;
    }
    else if(e.keyCode<=105){
      if(e.keyCode>=96){
        //e.keycode = e.keycode - 47;
        a = ini.value.toString().replace(".","");
        b = a.replace(/[^\d]/g,"");
        b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
        ini.value = tandaPemisahTitik(b);
        //alert(e.keycode);
        return false;
        }
      else {return false;}
    }
    else {
      return false; }
  }else if (e.keyCode==48){
    a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
    b = a.replace(/[^\d]/g,"");
    if (parseFloat(b)!=0){
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  }else if (e.keyCode==95){
    a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
    b = a.replace(/[^\d]/g,"");
    if (parseFloat(b)!=0){
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  }else if (e.keyCode==8 || e.keycode==46){
    a = ini.value.replace(".","");
    b = a.replace(/[^\d]/g,"");
    b = b.substr(0,b.length -1);
    if (tandaPemisahTitik(b)!=""){
      ini.value = tandaPemisahTitik(b);
    } else {
      ini.value = "";
    }
    
    return false;
  } else if (e.keyCode==9){
    return true;
  } else if (e.keyCode==17){
    return true;
  } else {
    //alert (e.keyCode);
    return false;
  }

}
            </script>  
