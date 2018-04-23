 $("#stok_penyesuaian_ln").load("media.php?ajax=stok_penyesuaian_ln");
 $("#stok_penyesuaian_batch").load("media.php?ajax=stok_penyesuaian_batch");


 $('body').on('change', '.qty_baru', function (){
          		var qty_baru = $(this).val();
          		var qty_lama = $(this).closest('td').prev().find('input').val();
          		var beda	 = $(this).closest('td').next().find('input');
              var diff=0;
              diff = qty_baru-qty_lama;
              beda.val(diff);
          		 var c= $(this).parent().nextAll().has(":checkbox").first().find(":checkbox");
            	c.attr('checked','');
            	//alert(qty_lama);
            	//alert(qty_baru);



            	var nama_brand = $(this).closest('tr').attr('id');
            	var id_satuan = $(this).closest('tr').attr('satuan');
            	var nama_satuan = $(this).closest('tr').attr('nama_satuan');
              var data_id_inv = $(this).closest('tr').attr('data_id_inv');
              alert(data_id_inv);

               /*for penyesuain ln*/
              var id_inv=data_id_inv;
              var beda_qty=diff;
              var balance_qty=qty_lama;
              var total_harga=0;             
              var harga_unit=0;
              //var qty_baru =0;
              //////////////////////////////////////
              var departemen = $('[name=id_departemen]').val();
              if(!departemen){
                alert("Pilih Departemen");
                return false;
              }
            	var obj = {};
              obj.nama_brand = nama_brand;
              obj.id_satuan = id_satuan;
              obj.nama_satuan = nama_satuan;
              obj.departemen = departemen;
               obj.id_inv = id_inv;
               obj.beda_qty = beda_qty;
               obj.total_harga = total_harga;
               obj.id_satuan = id_satuan;
               obj.qty_baru = qty_baru;
               obj.balance_qty = balance_qty;


               //alert(obj);
            	//var url="media.php?ajax=add_penyesuaian_batch&nama_brand="+nama_brand+"&id_satuan="+id_satuan;
            	if(parseInt(qty_baru) > parseInt(qty_lama)){
				 $(".nav-tabs-custom").hide();
                  // $(".ghost_batch").load(url);
                  $.ajax({
                      url: 'media.php?ajax=add_penyesuaian_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('.ghost_batch').html(data);
                      }
                    
                      });
                 }
                 else if(parseInt(qty_baru<=0))
                 {
                    c.attr('checked',''); 
                    qty_baru.val(0);
                 }
                 else if(parseInt(qty_baru) < parseInt(qty_lama) && parseInt(qty_baru)>0 )
                 {
                 	 $('.angel_pop').css("visibility", "visible");
                   //alert(obj);
                    $.ajax({
                      url: 'media.php?ajax=load_penyesuaian',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('.modal-body').html(data);
                      }
                    
                      });

                      //$(".modal-body").load("media.php?ajax=load_penyesuaian&obj="+obj); 
                 }

                 
                        
       });


$('body').on('click', '#close_angel_pop_penyesuaian', function (){ 
         
         $('.angel_pop').css("visibility", "hidden");

            });

 $('body').on('click', '#simpan_penyesuaian_batch', function (){ 
         var data = $("#penyesuaian_batch_temp").serialize(); 
        // alert(data);

            $.ajax({
                 type:'post',
                 url :"media.php?ajax=save_penyesuaian_batch",
                data:data,
                 success: function(data) {
                       // alert(data);
                              $(".nav-tabs-custom").show();
                              $(".ghost_batch").html("");                               
                                          
                         },
                           error:function(exception){alert('Exeption:'+exception);}
                         })

            });
                 
function count_on_jumlah_penyesuaian(){
		var qty = $("#jumlah").val();
		var harga = $("#harga_unit").val();
		$("#total_cost").val(qty*harga);
}


      /*save ln batch trf*/
      $('body').on('click', '#save_batch_penyesuaian', function (){
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
                         url :"media.php?ajax=save_stok_penyesuaian_load",
                         data:data,
                         success: function(data) {  
                         alert(data);
                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
              });
 
	