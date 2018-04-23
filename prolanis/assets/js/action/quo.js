	/********************************************tambah PENAWARAN HARGA ***************************************************/
          
          /*simpan quotation header*/
            $('body').on('click', '#penawaran_harga_save', function (){
               var data = $("#form_penawaran").serialize();
               //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_q_hdr",
               data:data,
               success: function(data) {
                  //alert("berhasil disimpan");
                  window.location.href = 'media.php?inventori=quotation';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


            /*Cancel quotation hdr*/           
            $('body').on('click', '#cancel_quo', function (){
          
              $.ajax({
               type:'post',
               url :"media.php?ajax=cancel_q_hdr",
               success: function(data) {
                     //alert(data);
                     window.location.href = 'media.php?inventori=quotation';
                     

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

          /*simpan quotation ln*/
      			$('body').on('click', '#simpan_q_ln', function (){
      				 var data = $("#quo").serialize();
      				 //alert("woi");
      			 $.ajax({
      			   type:'post',
      			   url :"media.php?ajax=save_q_ln",
      			   data:data,
      			   success: function(data) {
                var hasil = $.trim(data);
                alert(hasil);
                if( hasil === "success"){
                  $("#quotation").load("media.php?ajax=quotation");
                }else{
                   // alert("gagal"); 					
                  }
      			   },
      			   error:function(exception){alert('Exeption:'+exception);}
      			   })
      			   
      			});
            /*HAPUS quotation ln*/
            $('body').on('click', '.hapus_quotation', function (){
               var data = $(this).attr('id');
                $.ajax({        
               type:'post',
               url :"media.php?ajax=hapus_q_ln&id="+data,
               data:data,
               success: function(data) {
                $("#quotation").load("media.php?ajax=quotation");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


          /*Load quotation ln*/
            $('body').on('click', '#load_q', function (){

               var data = $('#id_suppli').val();
               //var satu = $('#idsupp').val();
               //alert(data);

               if($.trim(data)==''){
                alert ("pilih supllier");
               }else{
               
              $("#quotation").load("media.php?ajax=load_q_ln&id="+data);
            }
               
            });

          /*simpan edit Q_LN*/
            $('body').on('click', '#simpan_edit_q_ln', function (){
                 var data = $("#edit_quo").serialize();
                  //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_q_ln",
               data:data,
               success: function(data) {
                ///alert(data);
                    $("#quotation").load("media.php?ajax=quotation");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

        /*tambah quotation ln baru*/
          $('body').on('click', '#add_q', function (){
            var ajax_load = "";
            $("#quotation").html(ajax_load).load("media.php?ajax=q_ln");
    
          });

          /*cancel ln*/
          $('body').on('click', '#cancel_q', function (){
            //alert("woi");
            var ajax_load = "";
            $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
   
          });

        /*Edit quotation ln*/
            $('body').on('click', '.edit_quotation', function (){
               var data = $(this).attr('id');     
                $("#quotation").load("media.php?ajax=edit_q_ln&id="+data);
       
            });

                        /*FUNCTION INSERT QUOTATION FROM LOAD*/
            $('body').on('click', '#simpan_load_q', function (){
              var checkeds = []
                  $("input[name='q_checkbox[]']:checked").each(function ()
                  {
                      checkeds.push(parseInt($(this).val()));
                  });
                      var ajax_load = "";
                
                $.ajax({
                         type:'post',
                         url :"media.php?ajax=save_load_q",
                         data:{id_rq:checkeds},
                         success: function(data) {
                            $("#quotation").load("media.php?ajax=quotation");
                           //alert(data);

                         },
                         error:function(exception){alert('Exeption:'+exception);}
                         })
             
              });

            /*cancel load quotation*/
            $('body').on('click', '#cancel_load_q', function (){
                      var ajax_load = "";
                      $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                
             
              });
  



/********************************************UPDATE PENAWARAN HARGA ***************************************************/
         /*simpan  form_tambah_quotation ln*/
            $('body').on('click', '#simpan_form_tambah_q_ln', function (){
               var data = $("#new_quo").serialize();
               //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_tambah_q_ln",
               data:data,
               success: function(data) {
                alert(data);
                var hasil = $.trim(data);
                //alert(hasil);
                if( hasil === "success"){
                  alert(hasil);
                  $("#update_q_ln").load("media.php?ajax=update_q_ln");
                }else{
                   // alert("gagal");           
                  }
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });
			

      /*simpan edit quotation header*/
            $('body').on('click', '#update_penawaran_harga_save', function (){
               var data = $("#update_form_penawaran").serialize();
               //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_update_q_hdr",
               data:data,
               success: function(data) {
                  //alert("data");
                  window.location.href = 'media.php?inventori=quotation';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

				

        /*HAPUS update quotation ln*/
            $('body').on('click', '.hapus_update_quotation', function (){
               var data = $(this).attr('id');
                $.ajax({        
               type:'post',
               url :"media.php?ajax=hapus_update_q_ln&id="+data,
               data:data,
               success: function(data) {
                $("#update_q_ln").load("media.php?ajax=update_q_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


            /*simpan form_update quatation ln*/
            $('body').on('click', '#simpan_form_update_q_ln', function (){
                 var data = $("#update_quo").serialize();
                  //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_q_ln",
               data:data,
               success: function(data) {
                //alert(data);
                    $("#update_q_ln").load("media.php?ajax=update_q_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

                  ///////////////////////

          /*update quatation ln*/
            $('body').on('click', '#update_add_q', function (){
            var ajax_load = "";
            $("#update_q_ln").html(ajax_load).load("media.php?ajax=form_tambah_q_ln");
    
          });
          /*update form_update quatation ln*/
             $('body').on('click', '.edit_update_quotation', function (){
               var data = $(this).attr('id');     
                $("#update_q_ln").load("media.php?ajax=form_update_q_ln&id="+data);
       
            });




          $('body').on('click', '#cancel_update_q', function (){
            //alert("woi");
            var ajax_load = "";
            $("#update_q_ln").html(ajax_load).load("media.php?ajax=update_q_ln");
   
          });

                    /*cancel ln*/
          $('body').on('click', '#cancel_update_hdr_q', function (){
            //alert("woi");
            window.location.href = 'media.php?inventori=quotation';
   
          });

/********************************************PENAWARAN HARGA ***************************************************/


                      /*gross n net quotation*/
            function hargaFunction() {
               var jumlah = document.getElementById('jumlah_brand').value,
                    harga = document.getElementById('harga_unit').value;

               //alert(harga);

               var gross = parseInt(jumlah) * parseInt(harga);

               //alert(gross);
               document.getElementById("gross_unit").value = gross;
               document.getElementById("net_unit").value = gross;
               document.getElementById("net_price").value = harga;

               //gross_unit.innerHTML = gross;
            }

            function discFunction(){

               var  diskon = document.getElementById('diskon_unit').value,
                    jumlah = document.getElementById('jumlah_brand').value,
                    gross = document.getElementById('gross_unit').value,
                    harga = document.getElementById('harga_unit').value;

              var net_price = parseInt(harga)-parseInt(diskon);
              var diskon_net = parseInt(jumlah) * parseInt(diskon);
              var net = parseInt(gross) - parseInt(diskon_net);

              document.getElementById("net_unit").value= net;
              document.getElementById("net_price").value= net_price;
                //alert(diskon_net);

            }
			
			

