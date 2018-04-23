<?php
  include "../../../config/conn.php";

?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">    
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            <div class="box-body">
              <form role="form" class="form-horizontal">

                <div class="form-group row">
                  <label class="col-sm-2 text-label">Body</label>
                   <div class="col-sm-8">
                    <select name="body" id="body">
                      <?php

                        $listBody=pg_query($dbconn, "SELECT * from master_body");
                        while ($row=pg_fetch_assoc($listBody)) 
                        {
                            echo "<option value=$row[id] >$row[nama_body]</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 text-label">Body Location</label>
                   <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control" id="nama"  required autofocus>
                  </div>
                </div>

                <!-- /.box-body -->
                <div class=" col-md-12">
                  <button type="submit" name="simpan" class="btn btn-primary btn-flat btn-sm" id="simpan">SIMPAN</button>
                </div>
              </form>
            </div>   
        </div>
    </div>
</div>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#simpan").click(function(e)
        {
          e.preventDefault();
          //alert(0);
            var lokasi=$("#nama").val();
            var body=$("#body").val();
            $.ajax(
            {
                type:"POST",
                url:"media.php?lokasi_body=lokasi_body&modul=simpan&act=baru",
                data:{body:body, lokasi:lokasi},
                success:function(data)
                {

                  //alert(data);
                  window.location.reload();
                },
                error:function(data)
                {
                  //console.log(data);
                  alert('error');
                }
            });
        });
    });
</script>
        

    
