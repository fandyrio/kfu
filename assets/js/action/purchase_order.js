/***************************************************** TAMBAH PO*************************************************************/

      //$("#purchase_order").html(ajax_load).load("media.php?ajax=po_ln");
          /*simpan po header*/


     $("#purchase_order").load("media.php?ajax=po_ln");

            $('body').on('click', '#simpan_po_hdr', function (){
               var data = $("#po_hdr").serialize();
               var supp = $("#supplier_po").val();
               var dept = $("#deptid").val();

               if(!supp || !dept){
                alert("isi tanda *");
                return false;
               }

                var ln = $("#jlh_ln").val();

                if(parseInt(ln)==0){
                  alert("belum ada isi PO");
                  return false;
                }

              
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_po_hdr",
               data:data,
               success: function(data) {
                  
                  window.location.href = 'media.php?inventori=po';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

        /*PURCHASE ORDER*/
            $('body').on('click', '#add_po', function (){

                var ajax_load = "";
                $("#purchase_order").html(ajax_load).load("media.php?ajax=add_po_ln");
      
            });

        ///////////////////////////////////////////////////////////////////////////////
      			/*simpan quotation ln*/
      			$('body').on('click', '#cancel_po', function (){
      				 $("#purchase_order").load("media.php?ajax=po_ln");
      			      			   
      			});


            /*Edit po ln temp*/
            $('body').on('click', '.edit_po', function (){
               var data = $(this).attr('id');
     
                $("#purchase_order").load("media.php?ajax=edit_po_ln&id="+data);
       
            });

            /*simpan Po_LN*/
            $('body').on('click', '#simpan_po_ln', function (){
                 var data = $("#po_ln").serialize();
                 alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_po_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    alert(data);
                    $("#purchase_order").load("media.php?ajax=po_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

             /*simpan Edit Po_LN*/
            $('body').on('click', '#simpan_edit_po_ln', function (){
                 var data = $("#edit_po_ln").serialize();
                 //alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_po_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    $("#purchase_order").load("media.php?ajax=po_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

             /*HAPUS po ln*/
            $('body').on('click', '.hapus_po', function (){
               var data = $(this).attr('id');
              //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_po_ln&id="+data,
               data:data,
               success: function(data) {
                $("#purchase_order").load("media.php?ajax=po_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
               
            });

              /*Load quotation ln*/
            $('body').on('click', '#load_po', function (){

               var data = $('#supplier_po').val();
               //var satu = $('#idsupp').val();
               //alert(data);

               if($.trim(data)==''){
                alert ("pilih supllier");
               }else{
               //alert(data);
               $("#purchase_order").load("media.php?ajax=load_po_ln&id="+data);
            }
               
            });

            /*Load quotation ln*/
            $('body').on('click', '#update_load_po', function (){

               var data = $('#supplier_po').val();
               //var satu = $('#idsupp').val();
               alert("woi");

               if($.trim(data)==''){
                alert ("pilih supllier");
               }else{
               //alert(data);
               $("#update_p_ln").load("media.php?ajax=load_update_po_ln&id="+data);
            }
               
            });

            /*cancel po hdr*/
             $('body').on('click', '#cancel_po_hdr', function (){       
              $.ajax({
               type:'post',
               url :"media.php?ajax=cancel_po_hdr",
               success: function(data) {
                     //alert(data);
                     window.location.href = 'media.php?inventori=po';                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


			$('body').on('click', '#check_diskon', function (){
				var satu = $('#persen_diskon');
			    var dua = $('#diskon_amount');
			    satu.attr("disabled", !this.checked);
			    dua.attr("disabled", this.checked);
			      			   
			});
			$('body').on('click', '#check_pajak', function (){
				var satu = $('#persen_pajak');
			    var dua = $('#pajak_amount');
			    satu.attr("disabled", !this.checked);
			    dua.attr("disabled", this.checked);
			      			   
			});
/*hidden alamat*/
			$('.alamat_po_hidden').hide();
      
      $('body').on('click', '#alamat_po', function (){
				var div = $('.alamat_po_hidden');
				if (div.is(':visible')) div.hide();
				else div.show();
      
            });



            function count_on_jumlah_po() {
               var jlh 			= $('#jumlah_po').val();
               var jumlah = jlh.replace('.', "");
               var hrg 			= $('#harga_unit').val();
               var harga      = hrg.replace('.', "");
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
			   
               var net_po = $('#net_po').val();
			   
			   if(!harga){harga=0;}
			   
			   if(!persen_diskon){net_po=0;}
			   var hasil_gross = jumlah*harga;
			   if(check_diskon.is(":checked"))
			   {
				    if(!persen_diskon){persen_diskon=0;}
						diskon = persen_diskon/100;

						hasil_net_po = (parseInt(harga)-(parseInt(harga)*parseInt(diskon))*parseInt(jumlah))
			   }
			   else{
				     if(!diskon_amount){diskon_amount=0;}
						diskon = diskon_amount;
						hasil_net_po = (parseInt(hasil_gross)-parseInt(diskon));
			   }
			   
			   if(check_pajak.is(":checked"))
			   {
				    if(!persen_pajak){persen_pajak=0;}
						pajak = persen_pajak/100;
						hasil_net_po = parseInt(hasil_net_po) + parseInt((hasil_net_po*pajak));
						
			   }
			   else{
				     if(!pajak_amount){pajak_amount=0;}
						pajak = pajak_amount;
						hasil_net_po = parseInt(hasil_net_po) + parseInt(pajak);
			   }
			   
			   
				$('#gross_po').val(tandaPemisahTitik(hasil_gross));
				$('#net_po').val(tandaPemisahTitik(hasil_net_po));
            }



          $('body').on('change', '[name=brandnama_po]', function (){  
              var inventori = $(this).val();

              var id_satuan = $.trim(inventori).split("_");

              //alert("woi");

              $('#nama_satuan_po').val(id_satuan[2]);
              $('#inv_po').val(id_satuan[0]);
              $('#id_satuan_po').val(id_satuan[3]);
              $('#brand_nama_po').val(id_satuan[1]);

              
          });


                  /*FUNCTION INSERT QUOTATION FROM LOAD*/
            $('body').on('click', '#simpan_load_po', function (){

            	
             var checkeds = []
                  $("input[name='po_checkbox[]']:checked").each(function ()
                  {
                      checkeds.push(parseInt($(this).val()));
                  });
                      var ajax_load = "";

                      //alert(checkeds);
                
                $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_load_po",
                         data:{id_rq:checkeds},
                         success: function(data) {
                            $("#purchase_order").load("media.php?ajax=po_ln");
                           //alert(data);

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
              });
          
/**********************************************************end new po**********************************************************/

			
     
/***********************************************update po hdr**********************************************************/			

      /*simpan edit quotation header*/
            $('body').on('click', '#simpan_update_po_hdr', function (){
               var data = $("#update_po_hdr").serialize();
               //alert(data);
               var ln = $("#jlh_ln").val();

                if(parseInt(ln)==0){
                  alert("belum ada isi PO");
                  return false;
                }

             $.ajax({
               type:'post',
               url :"media.php?ajax=save_update_po_hdr",
               data:data,
               success: function(data) {
                  
                  window.location.href = 'media.php?inventori=po';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

        /*PURCHASE update ORDER*/
            $('body').on('click', '#update_add_po', function (){
              //alert("woi");

                var ajax_load = "";
                $("#update_p_ln").html(ajax_load).load("media.php?ajax=form_tambah_po_ln");
      
            });



            /*simpan form_tambah_po_LN*/
            $('body').on('click', '#simpan_update_po_ln', function (){
                 var data = $("#update_po_ln").serialize();
                 //alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_tambah_po_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    $("#update_p_ln").load("media.php?ajax=update_po_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


            $('body').on('click', '#cancel_update_po', function (){
               $("#update_p_ln").load("media.php?ajax=update_po_ln");
                           
            });


                    /*HAPUS update quotation ln*/
            $('body').on('click', '.hapus_update_po', function (){
               var data = $(this).attr('id');
                $.ajax({        
               type:'post',
               url :"media.php?ajax=hapus_update_po_ln&id="+data,
               data:data,
               success: function(data) {
                $("#update_p_ln").load("media.php?ajax=update_po_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


          $('body').on('click', '#cancel_update_po_hdr', function (){       
             
                     window.location.href = 'media.php?inventori=po';                
              
               
            });
                            /*FUNCTION INSERT QUOTATION FROM LOAD*/
            $('body').on('click', '#simpan_update_load_po', function (){

              
             var checkeds = []
                  $("input[name='po_checkbox[]']:checked").each(function ()
                  {
                      checkeds.push(parseInt($(this).val()));
                  });
                      var ajax_load = "";

                      var id_hdr = $('[name=id]').val();

                      //alert (id_hdr);

                      //alert(checkeds);
                
                  $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_update_load_po",
                         data:{id_rq:checkeds,
                          id_h:id_hdr},
                         success: function(data) {
                          //alert(data);
                            $("#update_p_ln").load("media.php?ajax=update_po_ln");
                           //

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
                });


                        /*Edit po ln temp*/
            $('body').on('click', '.edit_update_po', function (){
               var data = $(this).attr('id');
     
                $("#update_p_ln").load("media.php?ajax=form_update_po_ln&id="+data);
       
            });



                         /*simpan Edit Po_LN*/
            $('body').on('click', '#simpan_form_update_po_ln', function (){
                 var data = $("#form_update_po_ln").serialize();
                 //alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_po_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    $("#update_p_ln").load("media.php?ajax=update_po_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });




/*************************************************end update po hdr********************************************************/