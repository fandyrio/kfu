 $("#retur_barang").load("media.php?ajax=retur_ln");
 $("#batch_retur").load("media.php?ajax=retur_batch");

      
        /*ajax fomr grn ln*/
         $('body').on('click', '#add_retur_ln', function (){
				var departemen= $('#id_departemen').val();
        var supp      = $('#supplier_po').val();
				if(!supp){
					alert("PILIH DULU SUPPLIER");
					return;
				}
                var ajax_load = "";
                $("#retur_barang").html(ajax_load).load("media.php?ajax=add_retur_ln&supp="+supp+"&departemen="+departemen);
      
            });

         $('body').on('click', '#cancel_retur_add_ln', function (){      
  			  $("#retur_barang").load("media.php?ajax=retur_ln");
       
		});


 /*simpan retur ln*/
            $('body').on('click', '#simpan_retur_ln', function (){
              
              var supp= $('[name=nama_brand]').val();
              if(!supp){
                alert("Pilih Brand");
                return false;
              }
              else{
             //  alert('woi'); 
             var name_brand = $.trim(supp).split("_"); 
             var nama= name_brand[1].split(' ').join('_');
             var departemen = $('[name=id_departemen]').val();

              $('#mit_pop_up').css("display", "block");
               
                $(".resultload").load("media.php?ajax=load_return_batch&brand="+nama+"&dept="+departemen);     

              } 

            
               
            });
            //close
             $('body').on('click', '.close', function (){        
             $('#mit_pop_up').css("display", "none");      
            });
            /*save ln batch trf*/
      $('body').on('click', '#save_batch_retur', function (){
         var data = $("#retur_ln").serialize();

              var checkbox1 = []
              var taken1 = [];
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
					$("input[name='taken[]']").each(function ()
	                  {
	                  		if(!$(this).attr("disabled")){
	                      	taken1.push($(this).val());
	                  		}
	                     
	                  });
					/*if(taken1.length==0){
						alert("isila bro");
						return;
					}
					else{
							alert(taken1.length);
						return;
					}*/
                
                   
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
                                            
                                           $('#mit_pop_up').css("display", "none");
                                            $(".angel").show();
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
                alert(nama);
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

   /*hapus retur */
   $('body').on('click', '.hapus_retur_ln', function (){
  var data = $(this).attr('id');   
  $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_retur_ln",
               data:{id:data},
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#retur_barang").load("media.php?ajax=retur_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
})
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

$('body').on('change', '[name=nama_brand]', function (){  
              var inventori = $(this).val();
              var id_satuan = $.trim(inventori).split("_");

              $('#nama_satuan').val(id_satuan[2]);
              $('#inv').val(id_satuan[0]);
              $('#id_satuan').val(id_satuan[3]);
              $('#brand_nama').val(id_satuan[1]);

              
 }); 
/*hitung total cost*/
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


 /*cancel po hdr*/
      $('body').on('click', '#cancel_retur_hdr', function (){ 
      //alert("woi");      
            $.ajax({
             type:'post',
             url :"media.php?ajax=cancel_retur_hdr",
             success: function(data) {
                   //alert(data);
                  window.location.href = 'inventori-kembali';                
             },
               error:function(exception){alert('Exeption:'+exception);}
             })
               
            });  