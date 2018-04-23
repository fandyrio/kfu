 /****KONDISI KETIKA MENAMBAH DATA BARU PADA TERIMA BARANG***/
 /**/
 $("#terima_barang").load("media.php?ajax=grn_ln");
 $("#batch_grn").load("media.php?ajax=grn_batch&id=0&nama=");
 //$('#loading').hide();
 
/**************HDR TERIMA BARANG*****/
 

$('body').on('click', '#cancel_grn_hdr', function (){
    // alert("ok");
	$('#loading').css('visibility' , 'visible') ;
  $.ajax({
               type:'post',
               url :"media.php?ajax=cancel_grn_hdr",              
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                   window.location.href = 'media.php?inventori=terimabarang';

               },
			  /* complete: function(){
				$('#loading').css('visibility' , 'hidden') ;
				},*/
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});

  /*simpan terima barang header*/
            $('body').on('click', '#simpan_grn_hdr', function (){
               var data = $("#grn_hdr").serialize();
               var gross_total = $("[name=gross_total]").val();
               var disc_persen = $("[name=disc_persen]").val();
               var disc_amount = $("[name=disc_amount]").val();
               var persen_pajak = $("[name=persen_pajak]").val();
               var pajak_amount = $("[name=pajak_amount]").val();
               var net_total = $("[name=net_total]").val();
               if(!disc_persen){disc_persen=0;}
               if(!disc_amount){disc_amount=0;}
               if(!persen_pajak){persen_pajak=0;}
               if(!pajak_amount){pajak_amount=0;}
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_hdr&gross_total="+gross_total+"&disc_persen="+disc_persen+"&disc_amount="+disc_amount+"&persen_pajak="+persen_pajak+"&pajak_amount="+pajak_amount+"&net_total="+net_total,
               data:data,
               success: function(data) {
                  alert(data);
                alert("berhasil disimpan");
                window.location.href = 'inventori-grn';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

/**************************************FORM GRN LN*****************************************************************************************************/       
/*ajax fomr grn ln*/
$('body').on('click', '#add_grn', function (){

				var supp= $('#supplier_po').val();
				if(!supp){
					alert("PILIH DULU SUPPLIER");
					return;
				}
    var ajax_load = "";
     $("#terima_barang").html(ajax_load).load("media.php?ajax=add_grn_ln");
      
});

/*ajax fomr grn ln*/
$('body').on('click', '#grn_load', function (){
        var supp= $('#supplier_po').val();
        if(!supp){
          alert("PILIH DULU SUPPLIER");
          return false;
        }
        else{
          $.ajax({
                       type:'post',
                       url :"media.php?ajax=sessionstore&id="+supp,
                       data:url,
                      
                       success: function(data) {
                            //console.log('success',data);
                           // alert(data);

                            $(".modal-body").load("media.php?ajax=load_grn_ln");
							

                       },
                       error:function(exception){alert('Exeption:'+exception);

                      return false;
                    }
          })
          //
        }
      
});


$('body').on('click', '.edit_grn_batch', function (){
  var data = $(this).attr('id');     
  $("#batch_grn").load("media.php?ajax=edit_grn_batch&id="+data);
  
       
});
$('body').on('click', '#cancel_grn_batch_directly_edit', function (){
  var data = $('input[name=id_ln]').val();
  //alert(data);     
  $("#batch_grn").load("media.php?ajax=grn_batch&id="+data);
  
       
});
$('body').on('click', '#simpan_grn_batch_directly_edit', function (){
  var data = $("#grn_batch_directly_temp_edit").serialize();    
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_batch_directly_edit",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    var data=$.trim(data);
                    $("#batch_grn").load("media.php?ajax=grn_batch&id="+data);

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});
$('body').on('click', '.edit_grn_ln', function (){
  var data = $(this).attr('id');  
  $("#terima_barang").load("media.php?ajax=edit_grn_ln&id="+data);
       
});
$('body').on('click', '#simpan_edit_grn_ln', function (){
  var data = $("#edit_grn_ln").serialize();  
  alert(data);  
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_grn_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#terima_barang").load("media.php?ajax=grn_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
  
       
});
$('body').on('click', '.hapus_grn_ln', function (){
  var data = $(this).attr('id');   
  $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_grn_ln",
               data:{id:data},
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#terima_barang").load("media.php?ajax=grn_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
})
       
});
$('body').on('click', '.hapus_batch_ln', function (){
  
  var data = $(this).attr('id');  
  //alert(id);
  $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_grn_batch",
               data:{id:data},
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#batch_grn").load("media.php?ajax=grn_batch");

               },
               error:function(exception){alert('Exeption:'+exception);}
})
       
});
			
		/*ajax fomr cancel grn ln*/
         $('body').on('click', '#cancel_grn_ln', function (){				
               $("#terima_barang").load("media.php?ajax=grn_ln");      
            });
		
		/*ajax fomr cancel grn batch directly*/
         $('body').on('click', '#cancel_grn_batch_directly', function (){	
					$(".angel").show();
                    $(".ghost_batch").html("");		 
                  
         });
		 /*ajax fomr simpan grn batch directly*/
         $('body').on('click', '#simpan_grn_batch_directly', function (){
					 var data = $("#grn_batch_directly_temp").serialize();
				$.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_batch_directly",
               data:data,
               success: function(data) {
               // alert(data);
					     $(".angel").show();
					      $(".ghost_batch").html("");
                $("#batch_grn").load("media.php?ajax=grn_batch");
				
               },
               error:function(exception){alert('Exeption:'+exception);}
               })	 
                  
         });
/*************************************************************end function TErima barang LN******************************************************/
		
		/*ajax form grn batch*/
         $('body').on('click', '#add_grn_batch', function (){
			

       $.ajax({
               type:'post',
               url :"media.php?ajax=check_grn_batch",               
               success: function(data) {
              if(data==1){alert('Batch sudah digunakan');}
               if(data==2){alert('Silahkan Pilih Detail Item');}
                 if(data==0){
                 $(".angel").show();
                  //$(".ghost_batch").html("");
                  $("#batch_grn").load("media.php?ajax=add_grn_batch");
        
               }
               alert(data);
               
               },
               error:function(exception){alert('Exeption:'+exception);}
               }) 
      
           });
		   /*simpan grn_LN*/
            $('body').on('click', '#simpan_grn_ln', function (){
                 var data = $("#grn_ln").serialize();
                 //alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_ln",
               data:data,
               success: function(data) {
               //alert(data);
				   $("#terima_barang").load("media.php?ajax=grn_ln");
				  
				  var url = "media.php?ajax=add_grn_batch_directly";
                    //console.log('success',data);
                   //alert(url);
				 
                   
                   $(".angel").hide(url);
                  $(".ghost_batch").load(url);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

$('body').on('click', '#cancel_grn', function (){
	 $("#terima_barang").load("media.php?ajax=grn_ln");
		
      			   
});

function hitung_net_cost(){

  //diskon
  var hasil_net = 0;
         var diskon     = 0;

               
                var res      = $('#gross_total').val();
              var gross = res.replace('.', "");
               var check_diskon = $('#check_diskon');
               var persen_diskon  = $('#persen_diskon').val();
               var diskon_amount  = $('#diskon_amount').val();
      
         //pajak
         var pajak      = 0;
         var check_pajak    = $('#check_pajak');
         var persen_pajak   = $('#persen_pajak').val();
               var pajak_amount   = $('#pajak_amount').val();

  if(check_diskon.is(":checked"))
         {
            if(!persen_diskon){persen_diskon=0;}
            diskon = persen_diskon/100;
           $('#diskon_amount').val(gross*diskon);
            hasil_net = gross-(gross*diskon);
           // alert(hasil_net);

         }
         else{
             if(!diskon_amount){diskon_amount=0;}
            diskon = diskon_amount;
           $('#persen_diskon').val((diskon/gross)*100);
            hasil_net = (gross-diskon);
            
           
         }
         
         if(check_pajak.is(":checked"))
         {
            if(!persen_pajak){persen_pajak=0;}
            pajak = persen_pajak/100;
            $('#pajak_amount').val(hasil_net*pajak);
            hasil_net = parseInt(hasil_net) + parseInt(hasil_net*pajak);
            
            
         }
         else{
             if(!pajak_amount){pajak_amount=0;}
            pajak = pajak_amount;
          $('#persen_pajak').val(pajak/gross*100);
            hasil_net = parseInt(hasil_net) + parseInt(pajak);
         }
         
         $('#net_total').val(hasil_net);
         $('#net_total_show').val(tandaPemisahTitik(hasil_net));
         

}

            function count_on_jumlah_grn() {
               var jumlah 			= $('#jumlah_grn').val();
               var harga 			= $('#harga_unit').val();
               var gross_po 		= $('#gross_po').val();
			   var hasil_net_po 	= 0;
               var check_diskon 	= $('#check_diskon');
			   //diskon
			   var diskon			= 0;
               var persen_diskon 	= $('#persen_diskon').val();
               var diskon_amount 	= $('#diskon_amount').val();
			   
			   //pajak
			   var pajak			= 0;
			   var check_pajak 		= $('#check_pajak');
			   var persen_pajak 	= $('#persen_pajak').val();
               var pajak_amount 	= $('#pajak_amount').val();
			   
               var net_po = $('#net_grn').val();
			   
			   if(!harga){harga=0;}
			   
			   if(!persen_diskon){net_po=0;}
			   var hasil_gross = jumlah*harga;
			   if(check_diskon.is(":checked"))
			   {
				    if(!persen_diskon){persen_diskon=0;}
						diskon = persen_diskon/100;

						hasil_net_po = (harga-(harga*diskon))*jumlah
			   }
			   else{
				     if(!diskon_amount){diskon_amount=0;}
						diskon = diskon_amount;
						hasil_net_po = (hasil_gross-diskon);
			   }
			   
			   if(check_pajak.is(":checked"))
			   {
				    if(!persen_pajak){persen_pajak=0;}
						pajak = persen_pajak/100;
						hasil_net_po = hasil_net_po +(hasil_net_po*pajak);
						
			   }
			   else{
				     if(!pajak_amount){pajak_amount=0;}
						pajak = pajak_amount;
						hasil_net_po = hasil_net_po +pajak;
			   }
			   
			   
				$('#gross_po').val(hasil_gross);
				$('#net_grn').val(hasil_net_po);
          }



/*Kondisi ketika Edit terima barang*/
$("#terima_barang_update").load("media.php?ajax=update_grn_ln");
 $("#batch_grn_update").load("media.php?ajax=update_grn_batch&id=0&nama=");
/*ajax fomr grn ln*/
$('body').on('click', '#update_add_grn', function (){
        
    var ajax_load = "";
     $("#terima_barang_update").html(ajax_load).load("media.php?ajax=add_grn_ln");
      
});
/*simpan grn_LN*/
            $('body').on('click', '#simpan_update_grn_ln', function (){
                 var data = $("#grn_ln_update").serialize();
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_tambah_grn_ln",
               data:data,
               success: function(data) {
           $("#terima_barang_update").load("media.php?ajax=update_grn_ln");
          
           var url = "media.php?ajax=form_grn_batch_directly";
                    //console.log('success',data);
                   //alert(url);
         
                   
                    $(".angel").hide(url);
                    $(".ghost_batch").load(url);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

            /*ajax fomr simpan grn batch directly*/
         $('body').on('click', '#simpan_grn_batch_directly_update', function (){
           var data = $("#grn_batch_directly_update").serialize();
           //alert(data);
        $.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_batch_update_directly",
               data:data,
               success: function(data) {
               alert(data);
               $(".angel").show();
                $(".ghost_batch").html("");
        
               },
               error:function(exception){alert('Exeption:'+exception);}
               }) 
                  
         });

      /*hidden batch load*/

     //$('.batch_po_hidden').css('visibility' , 'hidden') ;

     //document.getElementsByClassName('semana2').style.visibility = "hidden";
      
      /*$('body').on('click', '.batch_po_hidden', function (){
        var div = $('.batch_po_hidden');
        if (div.is(':visible')) div.hide();
        else div.show();
                $("#po_batch_load").load("media.php?ajax=add_batch_load_");
      
            });*/

      /*po load*/
      $("#batch_").hide();

        $('body').on('click', '#po_batch_load tr', function (){
            //$("#po_batch_load tr ").click(function(event) {
              //alert("woi");
                          
             //var next = $(this).closest('tr').find('td input[type=text]:first');
            // next.attr("disabled", !this.checked);
                //next.val("00");
                var id_po= $(this).attr('id');
                alert(id_po);
                 //$("#batch_").show();
            });

 $('body').on('click', '#grn_ln_loader tr', function (){
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
                      url: 'media.php?ajax=grn_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#batch_grn').html(data);
                      }
                    
                      });
                  }

               
                 //$("#batch_").show();
            });
 $('body').on('click', '#grn_ln_update tr', function (){
                var id= $(this).attr('id');
                var nama= $(this).attr('nama');
                 var data =  $(this).attr('data').split("_");
                
                var obj = {};
                 obj.id_satuan = data[0];
                  obj.nama_satuan = data[2];
                 obj.nama = nama;
                 obj.id = id;

                if(id){
                   
                     $.ajax({
                      url: 'media.php?ajax=update_grn_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#batch_grn_update').html(data);
                      }
                    
                      });
                  }

               
                 //$("#batch_").show();
            });

 $('body').on('click', '.edit_grn_ln_update', function (){
  var data = $(this).attr('id');     
  alert(data);
  $("#terima_barang_update").load("media.php?ajax=edit_grn_ln_update&id="+data);
       
});
 $('body').on('click', '#cancel_grn_ln_update', function (){
   $("#terima_barang_update").load("media.php?ajax=update_grn_ln");
    
               
});

$('body').on('click', '#simpan_edit_grn_ln_update', function (){
  var data = $("#edit_grn_ln_update").serialize();    
  alert(data);
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_grn_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                   alert(data);
                    $("#terima_barang_update").load("media.php?ajax=update_grn_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});

$('body').on('click', '.hapus_batch_ln_update', function (){
  var data = $(this).attr('id');   
  $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_grn_batch_update",
               data:{id:data},
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#terima_barang_update").load("media.php?ajax=update_grn_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
})
       
});

$('body').on('click', '.edit_grn_batch_update', function (){
  var data = $(this).attr('id');     
  
  $("#batch_grn_update").load("media.php?ajax=edit_grn_batch_update&id="+data);
       
});
/*ajax form grn batch*/
         $('body').on('click', '#add_grn_batch_update', function (){
      

       $.ajax({
               type:'post',
               url :"media.php?ajax=check_grn_batch_update",               
               success: function(data) {
              //if(data==1){alert('Batch sudah digunakan');}
              // if(data==2){alert('Silahkan Pilih Detail Item');}
               //  if(data==0){
                // $(".nav-tabs-custom").show();
                  //$(".ghost_batch").html("");
                  $("#batch_grn_update").load("media.php?ajax=form_tambah_grn_batch");
        
              // }
               
               },
               error:function(exception){alert('Exeption:'+exception);}
               }) 
      
           });

  $('body').on('click', '#simpan_grn_batch_update', function (){
           var data = $("#grn_batch_update").serialize();
        $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_grn_batch",
               data:data,
               success: function(data) {
               // alert(data);
             //  $(".nav-tabs-custom").show();
             //   $(".ghost_batch").html("");
                $("#batch_grn_update").load("media.php?ajax=update_grn_batch");
        
               },
               error:function(exception){alert('Exeption:'+exception);}
               })  
                  
         });

  $('body').on('click', '#simpan_grn_batch_directly_edit_update', function (){
           var data = $("#grn_batch_update").serialize();
           alert(data);
        /*$.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_grn_batch",
               data:data,
               success: function(data) {
               // alert(data);
             //  $(".nav-tabs-custom").show();
             //   $(".ghost_batch").html("");
                $("#batch_grn_update").load("media.php?ajax=update_grn_batch");
        
               },
               error:function(exception){alert('Exeption:'+exception);}
               })  */
                  
         });

  /*update terima barang header*/
            $('body').on('click', '#simpan_grn_hdr_update', function (){
               var data = $("#grn_hdr_update").serialize();
               alert(data);
               var gross_total = $("[name=gross_total]").val();
               var disc_persen = $("[name=disc_persen]").val();
               var disc_amount = $("[name=disc_amount]").val();
               var persen_pajak = $("[name=persen_pajak]").val();
               var pajak_amount = $("[name=pajak_amount]").val();
               var net_total = $("[name=net_total]").val();
               if(!disc_persen){disc_persen=0;}
               if(!disc_amount){disc_amount=0;}
               if(!persen_pajak){persen_pajak=0;}
               if(!pajak_amount){pajak_amount=0;}
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_update_grn_hdr&gross_total="+gross_total+"&disc_persen="+disc_persen+"&disc_amount="+disc_amount+"&persen_pajak="+persen_pajak+"&pajak_amount="+pajak_amount+"&net_total="+net_total,
               data:data,
               success: function(data) {
                  //alert(data);
                  alert("berhasil disimpan");
                 window.location.href = 'media.php?inventori=grn';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
             
               
            });
$('body').on('click', '#cancel_grn_hdr_update', function (){
    // alert("ok");
  $('#loading').css('visibility' , 'visible') ;
  window.location.href = 'media.php?inventori=terimabarang';

});
/****************************************/
$("#terima_barang_view").load("media.php?ajax=view_grn_ln");
 $("#batch_grn_view").load("media.php?ajax=view_grn_batch&id=0&nama=");
 $('body').on('click', '#grn_ln_view tr', function (){
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
                      url: 'media.php?ajax=view_grn_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#batch_grn_view').html(data);
                      }
                    
                      });
                  }

               
                 //$("#batch_").show();
            });

			
	$('body').on('change', '[name=nama_brand]', function (){  
              var inventori = $(this).val();
              var id_satuan = $.trim(inventori).split("_");

              $('#nama_satuan').val(id_satuan[2]);
              $('#inv').val(id_satuan[0]);
              $('#id_satuan').val(id_satuan[3]);
              $('#brand_nama').val(id_satuan[1]);

              
          });		
     
$('body').on('click', '#check_diskon', function (){
        var satu = $('#persen_diskon');
          var dua = $('#diskon_amount');
          satu.attr("disabled", !this.checked);
          dua.attr("disabled", this.checked);
          //alert("noob");
                     
      });
      $('body').on('click', '#check_pajak', function (){
        var satu = $('#persen_pajak');
          var dua = $('#pajak_amount');
          satu.attr("disabled", !this.checked);
          dua.attr("disabled", this.checked);
                     
      });

 function count_grn() {
               var jumlah       = $('#jumlah_grn').val();

               var res      = $('#harga_unit').val();
              var harga = res.replace('.', "");
                
               var gross_po     = $('#gross_po').val();
         var hasil_net_po   = 0;
               var check_diskon   = $('#check_diskon');
         //diskon
         var diskon     = 0;
               var persen_diskon  = $('#persen_diskon').val();
               var diskon_amount  = $('#diskon_amount').val();
         
         //pajak
         var pajak          = 0;
         var check_pajak    = $('#check_pajak');
         var persen_pajak   = $('#persen_pajak').val();
         var pajak_amount   = $('#pajak_amount').val();
         
               var net_po = $('#net_grn').val();
         
         if(!harga){harga=0;}
         
         if(!persen_diskon){net_po=0;}
         var hasil_gross = jumlah*harga;

         //check diskon
         if(check_diskon.is(":checked"))
         {
            if(!persen_diskon){persen_diskon=0;}
            diskon = persen_diskon/100;

            hasil_net_po = (harga-(harga*diskon))*jumlah;
            $('#diskon_amount').val((harga*diskon)*jumlah);
         }
         else{
             if(!diskon_amount){diskon_amount=0;}
            diskon = diskon_amount;
             $('#persen_diskon').val((diskon/jumlah/harga)*100);
            hasil_net_po = (hasil_gross-diskon);
         }
         ////////////////////////////////////////////
         if(check_pajak.is(":checked"))
         {
            if(!persen_pajak){persen_pajak=0;}
            pajak = persen_pajak/100;
            var pajak_amt= parseInt(hasil_net_po*pajak);
            hasil_net_po = parseInt(hasil_net_po) + parseInt(hasil_net_po*pajak);
          
            //alert(hasil_net_po);
           $('#pajak_amount').val(pajak_amt);
            
         }
         else{
             if(!pajak_amount){pajak_amount=0;}
            pajak = pajak_amount;
             $('#persen_pajak').val((pajak/jumlah/harga)*100);
            hasil_net_po = parseInt(hasil_net_po) + parseInt(pajak);
         }
         
         
        $('#gross_po').val(hasil_gross);
         $('#gross_po_show').val(tandaPemisahTitik(hasil_gross));
        
        $('#net_grn').val(hasil_net_po);
        $('#net_grn_show').val(tandaPemisahTitik(hasil_net_po));
         $('#harga_bersih').val(hasil_net_po/jumlah);
          }

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