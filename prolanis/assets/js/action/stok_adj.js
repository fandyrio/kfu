$("#adj_details").load("media.php?ajax=stok_adj_ln");
$('#adj_batch').load("media.php?ajax=view_batch_stok_adj");
      

      $('body').on('click', '#cancel_trf_hdr', function (){ 
      //alert("woi");      
            $.ajax({
             type:'post',
             url :"media.php?ajax=cancel_trf_hdr",
             success: function(data) {
                   //alert(data);
                  window.location.href = 'media.php?inventori=stok_mutasi';                
             },
               error:function(exception){alert('Exeption:'+exception);}
             })
               
            });        
      /*tambah trf ln*/
      $('body').on('click', '#add_adj_ln', function (){

      	var url = "media.php?ajax=add_stok_adj_ln";

      		$(".nav-tabs-custom").hide();
      		$(".adj_details_batch").load(url);

          //alert("woi");
      		              
       });



      $('body').on('change', '#unit_cost_adj', function (){
          var unit = $(this).val();
          var jumlah = $('[name=jumlah]').val();

          total = parseInt(unit) * parseInt(jumlah);

          $('[name=total_cost]').val(total);
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

      		$(".nav-tabs-custom").show();
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
         alert(data);
         var supp= $('[name=nama_brand_adj]').val();
         var departemen = $('[name=id_departemen]').val();
          if(!supp){
            alert("Pilih Brand");
            return false;
          }       
         //alert(data);
              $.ajax({
                 type:'post',
                 url :"media.php?ajax=save_stok_adj_ln",
                data:data,
                 success: function(data) {

                  //alert("woi");
                  //alert(data);

                   var unit = $('#jumlah_adj').val();

                      if(parseInt(unit)<0){
                        
                            $('.minus').hide();
                               var name_brand = $.trim(supp).split("_"); 
                               var nama= name_brand[1].split(' ').join('_');
                               $('#confirm-submit').modal('show');

                               $(".modal-body").load("media.php?ajax=load_stok_adj_batch_ln&brand="+nama+"&dept="+departemen); 

                             }

                           else{       
                                           $(".nav-tabs-custom").hide();
                                           $(".adj_details_batch").html("");                                       
                                           $(".adj_tambah_batch").load("media.php?ajax=add_stok_adj_batch");
                                                      
                                     }
                          },
                           error:function(exception){alert('Exeption:'+exception);}
                         })

            });

        /*simpa batch ln*/
         $('body').on('click', '#simpan_adj_batch', function (){ 
         var data = $("#adj_batch_temp").serialize(); 
        // alert(data);

            $.ajax({
                 type:'post',
                 url :"media.php?ajax=save_stok_adj_batch",
                data:data,
                 success: function(data) {
                           // alert(data);
                               $(".nav-tabs-custom").show();
                               $(".adj_details_batch").hide();                    
                               $(".adj_tambah_batch").hide();
                               $("#adj_details").load("media.php?ajax=stok_adj_ln");

                                          
                         },
                           error:function(exception){alert('Exeption:'+exception);}
                         })

            });

         $('body').on('click', '#save_adj_hdr', function (){ 
         var data = $("#adjustment_hdr").serialize();
         var catatan = $("[name=catatan]").val(); 
        // alert(catatan);

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
                                  $(".nav-tabs-custom").show();                             
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
                      url: 'media.php?ajax=view_batch_stok_adj',
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
                 // alert(checkbox1);          
              var total = []
                  $("input[name='total_cost[]']").each(function ()
                  {
                      total.push($(this).val());
                  });
              var taken1 = []
                  $("input[name='taken[]']").each(function ()
                  {
                      taken1.push($(this).val());
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
                                   $('body').removeClass('modal-open').css('padding-right','0px');
                                   $(".modal-backdrop").hide(); 
                                   $(".nav-tabs-custom").show();
                                   $(".adj_details_batch").hide();                    
                                   $(".adj_tambah_batch").hide();
                                   $("#adj_details").load("media.php?ajax=stok_adj_ln");
                                   $("#adj_batch").load("media.php?ajax=view_batch_stok_adj");
                                   //$(".adj_details_batch").show();  

                                },
                            error:function(exception){alert('Exeption:'+exception);}
                                  });               
             
              });
   