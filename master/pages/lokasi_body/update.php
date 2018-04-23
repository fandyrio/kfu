<?php
include "../../../config/conn.php";
$id_lokasi=$_GET['data'];
$data=pg_query($dbconn, "SELECT * from master_lokasi_body where id='$id_lokasi'");
$rowData=pg_fetch_assoc($data);
$nama=$rowData['nama_lokasi'];
$id=$rowData['id_body'];

?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">    
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
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
                            echo "<option value='$row[id]'";
                              if($id==$row['id'])
                              {
                                echo "selected";
                              }
                              echo "
                              >
                                $row[nama_body]
                              </option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 text-label">Nama</label>
                   <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control" id="nama" value="<?php echo $nama ?>"  required autofocus>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class=" col-md-12">
                  <button type="submit" name="simpan" class="btn btn-primary btn-flat btn-sm" id="simpan">UPDATE</button>
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
            var data=$("#nama").val();
            var idBody=$("#body").val();
            var idLokasi="<?php echo $id_lokasi ?>";
            /*alert(idBody); //1
            alert(idLokasi); //8*/*/
            $.ajax(
            {
                type:"POST",
                url:"media.php?lokasi_body=lokasi_body&modul=simpan&act=edit",
                data:{nama:data, idLokasi:idLokasi, idBody:idBody},

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
        

    
