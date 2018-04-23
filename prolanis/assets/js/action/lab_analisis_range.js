
$("#edit_add_referal").load("media.php?ajax=add_referal_range");
$("#edit_referal_r").load("media.php?ajax=load_edit_referal_range");
$("#referal_r").load("media.php?ajax=load_reference_range");
$("#add_referal").load("media.php?ajax=add_referal_range");


$('body').on('click', '#simpan_referal_range', function (){
                 var data = $("#referal_range").serialize();
                
            //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_load_referal_range",
               data:data,
               success: function(data) {
              // alert(data);
			  $("#add_referal").load("media.php?ajax=add_referal_range");
                $("#referal_r").load("media.php?ajax=load_reference_range");
                $("#edit_referal_r").load("media.php?ajax=load_edit_referal_range");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
 });

$('body').on('click', '.hapus_range', function (){
            var data = $(this).attr('id');
             // alert(data);

             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_referal&id="+data,
               data:data,
               success: function(data) {
                $("#referal_r").load("media.php?ajax=load_reference_range");
                $("#add_referal").load("media.php?ajax=add_referal_range");
                $("#edit_referal_r").load("media.php?ajax=load_edit_referal_range");

                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
 });


      $('body').on('click', '#simpan_analisis', function (){
                       var data = $("#analysis_range").serialize();
                    //alert(data);
                  
                    $.ajax({
                     type:'post',
                     url :"media.php?ajax=save_lab_analisis",
                     data:data,
                     success: function(data) {
                     // alert(data);

                     window.location.href = 'media.php?lab=analysis';
                     

                     },
                     error:function(exception){alert('Exeption:'+exception);}
                     })
       });


      $('body').on('click', '#simpan_analisis_update', function (){
                       var data = $("#update_analysis_range").serialize();
                   //alert(data);
                  
                    $.ajax({
                     type:'post',
                     url :"media.php?ajax=save_edit_lab_analisis",
                     data:data,
                     success: function(data) {
                  
                       window.location.href = 'media.php?lab=analysis';
                     

                     },
                     error:function(exception){alert('Exeption:'+exception);}
                     })
       });


                /*simpan edit RQ_LN*/
            $('body').on('click', '#simpan_edit_range', function (){
                 var data = $("#edit_referal_range").serialize();
             //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_referal",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                      //alert(data);
                      $("#referal_r").load("media.php?ajax=load_reference_range");
                     $("#add_referal").load("media.php?ajax=add_referal_range");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });


                        /*Edit request quotation ln temp*/
            $('body').on('click', '.edit_range', function (){
               var data = $(this).attr('id');
               //alert("woi");
     
                $("#add_referal").load("media.php?ajax=edit_referal_range&id="+data);
       
            });

          $('body').on('click', '#batal_range', function (){
              
     
               $("#add_referal").load("media.php?ajax=add_referal_range");
       
            });