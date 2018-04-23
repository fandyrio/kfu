
      <div class="row" style="padding-top:5px ">
     
   
        <div class="col-lg-6">
        

              <table id="myTable21"  class="table table-sm">
                <thead class="table-secondary">
                <tr>
              
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Harga (Rp)</th>
                  <th>#</th>
                  
                </tr>
                </thead>
                <tbody>
             <?php
             //var_dump($_GET);
                 $id_unit= $_SESSION['id_units'];
                 $res=pg_query($dbconn,"Select id, id_lab_analysis, harga from lab_analysis_kategori_harga_unit where id_unit='$id_unit' and id_kategori_harga='$_SESSION[id_perusahaan]' order by id asc");
                                 
                 while ($row=pg_fetch_assoc($res)) {
                    $view=pg_fetch_assoc(pg_query($dbconn,"Select * from lab_analysis WHERE id='$row[id_lab_analysis]'"));

                     ?>
                       <tr>
                        <td><?php echo $view["kode"] ?></td>
                        <td><?php echo $view["nama"] ?></td>
                        <td><?php echo number_format($row["harga"],'0','','.'); ?></td>
                        <td class="text-center">
                        <a id="<?php echo $row['id']?>" class="btn btn-warning btn-xs btn-flat btnEditLab"><i class="fa fa-edit"></i></a>
                         <a id="<?php echo $row['id_lab_analysis']?>" class="btn btn-success btn-xs btn-flat btnViewLab"><i class="fa fa-eye"></i></a>
                        <a id="<?php echo $row['id']?>" class="btn btn-danger btn-xs btn-flat btnHapusLab">
                        <i class="fa fa-trash"></i></a>                           
                          
                        </td>
                
                       
                        </tr>
                    
                 
                 <?php } ?> 
                </tbody>


              </table>
              
              </div>
              
      



      <div class="col-lg-6">
      <div class="card">

           <?php
        if(isset($_GET["view"])){
            include "view_lab.php";

        }
        elseif(isset($_GET["edit"])){
            include "edit_lab.php";
        }
        else{
         include "tambah_lab.php"; 
        }
         ?>
      </div>
      </div>
      </div>

      


      <script>
        $('#btnTambahlab').click(function()
        {
          var checkbox1 = []
                  $("input[name='id_lab[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }
                  });

            var total = []
                  $("input[name='harga[]']").each(function ()
                  {
                       if(!$(this).attr("disabled")){
                          total.push($(this).val());
                      }  
                  });

            
            $.ajax({
              type: "POST",
              url: "media.php?perusahaan=simpan_lab&act=baru",
              data:{  
                      check:checkbox1,   
                      total:total
               },
              success: function(data){
               
                $("#single").load("media.php?perusahaan=data_lab");
              }
            });

            return false;
        });

        $('.btnViewLab').click(function(){
          var data = $(this).attr('id');
         
           $("#single").load("media.php?perusahaan=data_lab&view&id="+data);
       
        });

        $('.btnEditLab').click(function(){
          var data = $(this).attr('id'); 

           $("#single").load("media.php?perusahaan=data_lab&edit&id="+data);

        
        });

        $('.btnHapusLab').click(function(){

           if (confirm('Apakah Anda Ingin Menghapus?')) {
            var data = $(this).attr('id'); 
           
            $.ajax({  
                type: "POST",
                url: 'media.php?content=perusahaan&modul=simpan_lab&act=delete',
                data: {id:data},
                success: function () {
                    $("#single").load("media.php?perusahaan=data_lab");
                }
            });
         }
        
        });



        $('#btnSimpanEdit').click(function(){

            var data = $("#form_edit_lab").serialize(); 
            $.ajax({  
                type: "POST",
                url: 'media.php?content=perusahaan&modul=simpan_lab&act=edit',
                data: data,
                success: function () {
                    $("#single").load("media.php?perusahaan=data_lab");
                }
            });

        });

         $('#kembali_lab').click(function(){

           $("#single").load("media.php?perusahaan=data_lab");

        
        });

         $(document).ready(function(){
          $('#myTable9').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
          $('#myTable21').DataTable({
            "oLanguage": {
              "sSearch": "Cari : ",
              "sLengthMenu": "Tampilkan _MENU_ records",
            }});
        });

    </script>

