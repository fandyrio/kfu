$("#adj_details").load("media.php?ajax=stok_adj_ln");
$('#adj_batch').load("media.php?ajax=stok_adj_batch");
      

      $('body').on('click', '#cancel_adj_hdr', function (){ 

      //alert("woi");      
            $.ajax({
             type:'post',
             url :"media.php?ajax=cancel_stok_adj_hdr",
             success: function(data) {
                   //alert(data);
                  window.location.href = 'inventori-stok-adjustment';                
             },
               error:function(exception){alert('Exeption:'+exception);}
             })
               
            });        
      /*tambah trf ln*/
      $('body').on('click', '#add_adj_ln', function (){

      	var url = "media.php?ajax=add_stok_adj_ln";

      		$(".angel").hide();
      		$(".adj_details_batch").load(url);

          //alert("woi");
      		              
       });



   

      $('body').on('change', '#jumlah_adj', function (){
          var unit = $(this).val();

          if(parseInt(unit)<0){
            //alert("minus");
            $('.minus').hide();

          }else $('.minus').show();
          //alert("woi");
                        
       });

      /*cancel tambah*/
      $('body').on('click', '#cancel_adj_details', function (){

      		$(".angel").show();
          $(".adj_details_batch").html("");		
      		              
       });


        $('body').on('change', '[name=nama_brand_adj]', function (){  
              var inventori = $(this).val();
              //alert(inventori);

              var id_satuan = $.trim(inventori).split("_");

              //alert("woi");

              $('#nama_satuan_adj').val(id_satuan[2]);
              $('#inv_adj').val(id_satuan[0]);
              $('#id_satuan_adj').val(id_satuan[3]);
              $('#brand_nama_adj').val(id_satuan[1]);

              
          });

        /*simpan adj_ln*/
         $('body').on('click', '#simpan_adj_ln', function (){ 

         var data = $("#adj_ln").serialize(); 
         //alert(data);
         var supp= $('[name=nama_brand_adj]').val();
         var departemen = $('[name=id_departemen]').val();
         var unit = $('#jumlah_adj').val();
         var cost = $('#unit_cost_adj').val();

          if(!supp){
            alert("Pilih Brand");
            return false;
          }  
          if(!unit){
            alert("isi jumlah");
            return false;
          }

          if(parseInt(unit)>0){

             if(!cost){
                alert("isi harga");
                return false;
              }

          }

         //alert(data);
              $.ajax({
                 type:'post',
                 url :"media.php?ajax=save_stok_adj_ln",
                data:data,
                 success: function(data) {

                  //alert("woi");
                 // alert(data);

                 

                      if(parseInt(unit)<0){
                        
                            $('.minus').hide();
                               var name_brand = $.trim(supp).split("_"); 
                               var nama= name_brand[1].split(' ').join('_');
                               //$('#confirm-submit').modal('show');

                               //$(".modal-body").load("media.php?ajax=load_stok_adj_batch_ln&brand="+nama+"&dept="+departemen); 
                               $('#mit_pop_up').css("display", "block");
             
                               $(".resultload").load("media.php?ajax=load_stok_adj_batch_ln&brand="+nama+"&dept="+departemen);   


                             }

                           else{       
                                           $(".angel").hide();
                                           $(".adj_details_batch").html("");                                       
                                           $(".adj_tambah_batch").load("media.php?ajax=add_stok_adj_batch");
                                                      
                                     }
                          },
                           error:function(exception){alert('Exeption:'+exception);}
                         })

            });


         /**/
        

        
      ///
      $('body').on('click', '.close', function (){
        
        $('#mit_pop_up').css("display", "none");
   
      
      });

        /*simpa batch ln*/
         $('body').on('click', '#simpan_adj_batch', function (){ 
         var data = $("#adj_batch_temp").serialize(); 

         var batch = $('#no_batch').val();

          if(!batch){
            alert("Isi no Batch");
            return false;
          }  
        // alert(data);

            $.ajax({
                 type:'post',
                 url :"media.php?ajax=save_stok_adj_batch",
                data:data,
                 success: function(data) {
                           
                                   
                                   $(".adj_tambah_batch").html("");
                                   $(".adj_details_batch").html("");
                                   $(".angel").show();
                                   $("#adj_details").load("media.php?ajax=stok_adj_ln");
                                   $("#adj_batch").load("media.php?ajax=stok_adj_batch");                                    
                         },
                           error:function(exception){alert('Exeption:'+exception);}
                         })

            });

         $('body').on('click', '#save_adj_hdr', function (){ 
         var data = $("#adjustment_hdr").serialize();
         var catatan = $("[name=catatan]").val(); 
         var ln = $("#jlh_ln").val();

         if(parseInt(ln)==0){
                  alert("batch belum ada");
                  return false;
                }

           $.ajax({
               type:'post',
               url :"media.php?ajax=save_stok_adj_hdr&catatan="+catatan,
               data:data,
               success: function(data) {
                //alert(data);
                  //alert("berhasil disimpan");
                  window.location.href = 'media.php?inventori=stok_adjustment';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })

            });

            /*hapus adj trf_ln*/
            $('body').on('click', '.hapus_stok_adj_ln', function (){
            var data = $(this).attr('id');   
            //alert(data);
                $.ajax({
                             type:'post',
                             url :"media.php?ajax=hapus_stok_adj_ln",
                             data:{id:data},
                             success: function(data) {
                                  $(".angel").show();                             
                                  $("#adj_details").load("media.php?ajax=stok_adj_ln"); 

                             },
                             error:function(exception){alert('Exeption:'+exception);}
              })
                 
          });

           $('body').on('click', '#stok_adj tr', function (){

                var id= $(this).attr('id');
                var nama= $(this).attr('nama');
                 var data =  $(this).attr('data').split("_");
                //alert(data);
                var obj = {};
                 obj.id_satuan = data[0];
                  obj.nama_satuan = data[2];
                 obj.nama = nama;
                 obj.id = id;
                if(id){
                   
                     $.ajax({
                      url: 'media.php?ajax=stok_adj_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#adj_batch').html(data);
                      }
                    
                      });
                  }
           
            });

       /*save ln batch trf*/
      $('body').on('click', '#save_batch_adj', function (){
         var data = $("#trf_ln").serialize();

              var checkbox1 = []
                  $("input[name='checkbox[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }
                  });
                     
              var total = []
                  $("input[name='total_cost[]']").each(function ()
                  {
                      total.push($(this).val());
                  });
              var taken1 = []
                  $("input[name='taken[]']").each(function ()
                  {
                       if(!$(this).attr("disabled"))
                       {
                       taken1.push($(this).val());
                      }
                  }); 

                 

                      $.ajax({
                             type:'post',
                             url :"media.php?ajax=save_stok_adj_load_batch",
                             data:{  
                                  check:checkbox1,   
                                      total:total,
                                      taken2:taken1
                                     },
                             success: function(data) {
                                            //alert("oke");
                                   //alert(data);
                                   
                                   $(".angel").show();
                                    $(".adj_tambah_batch").html("");
                                     $(".adj_details_batch").html("");
                                   
                                   $("#adj_details").load("media.php?ajax=stok_adj_ln");
                                   $("#adj_batch").load("media.php?ajax=stok_adj_batch");
                                   //$(".adj_details_batch").show();  

                                },
                            error:function(exception){alert('Exeption:'+exception);}
                                  });                
            
              });


               /*hitung total cost*/
         $('body').on('change', '.clickable', function (){ 
              var trid = $(this).closest('tr').attr('id_batch');

               var nilai = $.trim(trid).split("_"); // table row ID 
               var tara = $(this).val();

              alert("woi");
               

               if(parseInt(tara) > parseInt(nilai[0])){
                  alert("angka melebihi stok");
                  $(this).val("0");
                  $(this).next('input').val("0");
                  return false;
               }
               var total = parseInt(tara) * parseInt(nilai[1]);
               $(this).next('input').val(total);

               //alert(trid); 
              // alert(total);                     
            });


          /*disable checkbox harga inventori*/
            $('body').on('click', '#ceklis', function (){ 
                          
             var next = $(this).closest('tr').find('td input');
             //next.attr("disabled", !this.checked);
              if($(this).is(':checked')){
               next.attr('disabled', false);
               $(this).attr('disabled', false);
             } else {
                 next.attr('disabled', true);
                 $(this).attr('disabled', false);
             }
               
            });

  /* $('body').on('change', '#unit_cost_adj', function (){
          var unit = $(this).val();
          var jumlah = $('[name=jumlah]').val();

          total = parseInt(unit) * parseInt(jumlah);

          $('[name=total_cost]').val(total);
          //alert("woi");
                        
       });*/
             function count_adj() {

              var unit = $('#unit_cost_adj').val();
               var harga = unit.replace('.', "");
              var jumlah = $('[name=jumlah]').val();
               var jlh = jumlah.replace('.', "");

              total = parseInt(harga) * parseInt(jlh);

              $('[name=total_cost]').val(tandaPemisahTitik(total));
          //alert("woi");

             }
   