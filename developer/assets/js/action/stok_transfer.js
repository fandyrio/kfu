      $("#stok_mutasi_ln").load("media.php?ajax=trf_ln");
      $("#stok_mutasi_batch").load("media.php?ajax=trf_batch_ln");



    $('body').on('click', '#simpan_trf_hdr', function (){
               var data = $("#trf_hdr").serialize();                
                var catatan = $("[name=catatan]").val();

             $.ajax({
               type:'post',
               url :"media.php?ajax=save_trf_hdr&catatan="+catatan,
               data:data,
               success: function(data) {
                alert(data);
                  //alert("berhasil disimpan");
                  window.location.href = 'media.php?inventori=stok_mutasi';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
    })  
/*cancel po hdr*/
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
      $('body').on('click', '#add_trf_ln', function (){

      	var url = "media.php?ajax=add_stok_trf_ln";

      		$(".nav-tabs-custom").hide();
      		$(".trf_batch").load(url);
      		              
       });

      /*cancel tambah*/
      $('body').on('click', '#cancel_trf_batch', function (){

      		$(".nav-tabs-custom").show();
          $(".trf_batch").html("");		
      		              
       });


      /*$('body').on('click', '#id_supplier', function (){

      		alert("woi")
      	
                      
       });*/

      /*Insert add*/
      $('body').on('click', '#trf_load_batch', function (){
         var data = $("#trf_ln").serialize();


              var supp= $('[name=nama_brand_batch]').val();
              if(!supp){
                alert("Pilih Brand");
                return false;
              }
              else{
                $('[name=id_departemen]').attr('readonly','true');
                
             var name_brand = $.trim(supp).split("_"); 
             var nama= name_brand[1].split(' ').join('_');
              var departemen = $('[name=id_departemen]').val();

             //alert("woi");

             $(".modal-body").load("media.php?ajax=load_trf_batch_ln&brand="+nama+"&dept="+departemen);   

              }    
          });

       

      /*save ln batch trf*/
      $('body').on('click', '#save_batch_trf', function (){
         var data = $("#trf_ln").serialize();

              var checkbox1 = [];
                  $("input[name='checkbox[]']").each(function ()
                  {
                     var checked = $(this).val();
                     if ($(this).is(':checked')) {
                      checkbox1.push($(this).val());
                    }

                  });
          
              var total = [];
                  $("input[name='total_cost[]']").each(function ()
                  {
                      total.push($(this).val());
                  });

              var taken1 = [];
                  $("input[name='taken[]']").each(function ()
                  {
                      taken1.push($(this).val());
                  });   
                $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_trf_ln",
                         data:data,
                         success: function(data) {  
                          // alert(taken1);
                                                                
                                  $.ajax({
                                           type:'post',
                                           url :"media.php?ajax=save_trf_batch_ln",
                                           data:{  
                                            check:checkbox1,   
                                            total:total,
                                            taken2:taken1
                                          },
                                           success: function(data) {
                                           
                                            alert(data);
                                             $('body').removeClass('modal-open').css('padding-right','0px');
                                             $(".modal-backdrop").hide(); 
                                             $(".nav-tabs-custom").show();
                                            $(".trf_batch").html("");   
                                             $("#stok_mutasi_ln").load("media.php?ajax=trf_ln"); 
                                             
                            
                                           },
                                           error:function(exception){alert('Exeption:'+exception);}
                                           });

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
              });

      /*set all id di add*/
         $('body').on('change', '[name=nama_brand_batch]', function (){  
              var inventori = $(this).val();
              //alert(inventori);

              var id_satuan = $.trim(inventori).split("_");

              //alert("woi");

              $('#nama_satuan_trf').val(id_satuan[2]);
              $('#inv_trf').val(id_satuan[0]);
              $('#id_satuan_trf').val(id_satuan[3]);
              $('#brand_nama_trf').val(id_satuan[1]);

              
          });


         /*hitunh total cost*/
         $('body').on('change', '.clickable', function (){ 
              var trid = $(this).closest('tr').attr('id_batch');

               var nilai = $.trim(trid).split("_"); // table row ID 
               var tara = $(this).val();

              // alert("woi");
               

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
             next.attr("disabled", !this.checked);
               
            });


             $('body').on('click', '#trf_batch_ln tr', function (){

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
                      url: 'media.php?ajax=trf_batch_ln',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#stok_mutasi_batch').html(data);
                      }
                    
                      });
                  }

               
            });



       /*Edit trf ln temp*/
       $('body').on('click', '.edit_trf_ln', function (){
          var data = $(this).attr('id');
     
         var url = "media.php?ajax=edit_stok_trf_ln&id="+data;

                    $(".nav-tabs-custom").hide();
                    $(".trf_batch").load(url);
       
            });


    /*Insert edit add*/
      $('body').on('click', '#edit_trf_load_batch', function (){
         var data = $("#edit_trf_ln").serialize();

         var jumlah = $("#jumlah_awal").val();
         var jumlah_akh =  $("#jumlah_edit").val();
         var name_brand =  $("#brand_nama_trf").val();

         if(parseInt(jumlah_akh) > parseInt(jumlah)){
          var ambil_edit = parseInt(jumlah_akh) - parseInt(jumlah);

          var obj = {};
                 obj.nama_brand = name_brand;
                 obj.ambil_edit = ambil_edit;
              
                   
                     $.ajax({
                      url: "media.php?ajax=load_edit_trf_batch",
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                           $(".modal-body").html(data);  
                      }
                    
                      });
    
               }
               else{

                $(".modal-backdrop").hide(); 
                $(".nav-tabs-custom").show();
                $(".trf_batch").html("");    
                           
                          
                    $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_edit_stok_trf_ln",
                         data:data,
                         success: function(data) {
                               alert("sukses");

                               $(".nav-tabs-custom").show();
                               $("#stok_mutasi_ln").load("media.php?ajax=trf_ln");
                               $("#stok_mutasi_batch").load("media.php?ajax=trf_batch_ln");
                                          
                         },
                           error:function(exception){alert('Exeption:'+exception);}
                         })
                  
               }  
          });


             /*Edit trf ln temp*/
       $('body').on('click', '#save_edit_batch_trf', function (){

          var data = $("#edit_trf_ln").serialize();

          var id =  $("#id_ln").val();
          var total_cost =  $("#total_cost").val();
          alert(data);

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
                      taken1.push($(this).val());
                  });  

                      $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_edit_stok_trf_ln",
                         data:data,
                         success: function(data) {      
                         //alert("trfln");                                       
                                  $.ajax({
                                           type:'post',
                                           url :"media.php?ajax=save_edit_trf_batch_ln&id="+id+"&total_cost="+total_cost,
                                           data:{  
                                            check:checkbox1,   
                                            total:total,
                                            taken2:taken1
                                          },
                                           success: function(data) {
                                             alert(data);
                                             $(".modal-backdrop").hide(); 
                                             $(".nav-tabs-custom").show();
                                             $(".trf_batch").html("");   
                                             $("#stok_mutasi_ln").load("media.php?ajax=trf_ln"); 
                                             
                            
                                           },
                                           error:function(exception){alert('Exeption:'+exception);}
                                           });

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
       
            });


            /*hapus trf_ln*/
            $('body').on('click', '.hapus_trf_ln', function (){
            var data = $(this).attr('id');   
            $.ajax({
                         type:'post',
                         url :"media.php?ajax=hapus_trf_ln",
                         data:{id:data},
                         success: function(data) {
                              //console.log('success',data);
                              //alert(data);
                              $("#stok_mutasi_ln").load("media.php?ajax=trf_ln"); 

                         },
                         error:function(exception){alert('Exeption:'+exception);}
          })
                 
          });

          /*hapus trf batch ln*/
            $('body').on('click', '.hapus_trf_batch_ln', function (){
            var data = $(this).attr('id');   
            $.ajax({
                         type:'post',
                         url :"media.php?ajax=hapus_trf_batch",
                         data:{id:data},
                         success: function(data) {
                              //console.log('success',data);
                              //alert(data);
                              $("#stok_mutasi_batch").load("media.php?ajax=trf_batch_ln"); 

                         },
                         error:function(exception){alert('Exeption:'+exception);}
          })
                 
          });




