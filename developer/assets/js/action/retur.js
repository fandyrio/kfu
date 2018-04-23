 $("#retur_barang").load("media.php?ajax=retur_ln");
 $("#batch_retur").load("media.php?ajax=retur_batch");

      
        /*ajax fomr grn ln*/
         $('body').on('click', '#add_retur_ln', function (){
				var supp= $('#supplier_po').val();
				if(!supp){
					alert("PILIH DULU SUPPLIER");
					return;
				}
                var ajax_load = "";
                $("#retur_barang").html(ajax_load).load("media.php?ajax=add_retur_ln");
      
            });

 /*simpan retur ln*/
            $('body').on('click', '#simpan_retur_ln', function (){
                var data = $("#retur_ln").serialize();


              var supp= $('[name=nama_brand]').val();
              if(!supp){
                alert("Pilih Brand");
                return false;
              }
              else{
             //  alert('woi'); 
             var name_brand = $.trim(supp).split("_"); 
             var nama= name_brand[1].split(' ').join('_');

             //$(".modal-body").load("media.php?ajax=load_return_batch&brand="+nama);   

              } 
               $(".modal-body").load("media.php?ajax=load_return_batch&brand="+nama);   
            
               
            });
            /*save ln batch trf*/
      $('body').on('click', '#save_batch_retur', function (){
         var data = $("#retur_ln").serialize();

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
                         url :"media.php?ajax=save_retur_ln",
                         data:data,
                         success: function(data) {  
                         alert(data);                                           
                                  $.ajax({
                                           type:'post',
                                           url :"media.php?ajax=save_retur_ln_batch",
                                           data:{  
                                            check:checkbox1,   
                                            total:total,
                                            taken2:taken1
                                          },
                                           success: function(data) {
                                            alert(data);
                                            $("body").removeClass('modal-open');
                                             $(".modal-backdrop").hide(); 
                                             $(".nav-tabs-custom").show();
                                             $(".trf_batch").html("");   
                                             $("#retur_barang").load("media.php?ajax=retur_ln"); 
                                             
                            
                                           },
                                           error:function(exception){alert('Exeption:'+exception);}
                                           });

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
});
 $('body').on('click', '#retur_ln_loader tr', function (){
                var id= $(this).attr('id');
                var nama= $(this).attr('nama');
                 var data =  $(this).attr('data').split("_");
                alert(data);
                var obj = {};
                 obj.id_satuan = data[0];
                  obj.nama_satuan = data[2];
                 obj.nama = nama;
                 obj.id = id;
                if(id){
                   
                     $.ajax({
                      url: 'media.php?ajax=retur_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#batch_retur').html(data);
                      }
                    
                      });
                  }

               
                 //$("#batch_").show();
            });


 /*simpan terima barang header*/
            $('body').on('click', '#simpan_retur_hdr', function (){
               var data = $("#retur_hdr").serialize();
              
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_retur_hdr",
               data:data,
               success: function(data) {
                  alert(data);
                 // alert("berhasil disimpan");
                 window.location.href = 'media.php?inventori=retur';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });
  
