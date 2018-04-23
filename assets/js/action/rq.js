            

             //$("#result").html(ajax_load).load("media.php?ajax=rq_ln");

              $("#rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                });
 /*ajax rq*/
            $('body').on('click', '#add_rq', function (){
                var ajax_load = "";
               
                $("#result").html(ajax_load).load("media.php?ajax=add_rq_ln");
      
            });

            $('body').on('click', '#add_update_rq', function (){
              //alert("woi");
                var ajax_load = "";
                $("#update_ln").html(ajax_load).load("media.php?ajax=form_tambah_rq_ln");
      
            });

            $('body').on('click', '#cancel_rq', function (){
                var ajax_load = "";
                $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
      
            });

            /*cancel form tambah ln*/
            $('body').on('click', '#cancel_form_rq', function (){
                var ajax_load = "";
                $("#update_ln").html(ajax_load).load("media.php?ajax=update_rq_ln");
      
            });
            /*cancel form update ln*/
              $('body').on('click', '#cancel_update_rq', function (){
                var ajax_load = "";
                $("#update_ln").html(ajax_load).load("media.php?ajax=update_rq_ln");
      
            });
            /*simpan update_RQ_LN*/
            $('body').on('click', '#simpan_update_rq_ln', function (){
                 var data = $("#update_rq").serialize();
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert("success");
                    $("#update_ln").load("media.php?ajax=update_rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

           /*simpan RQ_LN*/
            $('body').on('click', '#simpan_rq_ln', function (){
                 var data = $("#rquo").serialize();
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert("success");
                    $("#result").load("media.php?ajax=rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

             /*simpan form RQ_LN*/
            $('body').on('click', '#simpan_form_rq_ln', function (){
                 var data = $("#form_rquo").serialize();
            
            //alert("WOI");
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_tambah_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    $("#update_ln").load("media.php?ajax=update_rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

                /*simpan edit RQ_LN*/
            $('body').on('click', '#simpan_edit_rq_ln', function (){
                 var data = $("#edit_rquo").serialize();
              //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                      //alert(data);
                    $("#result").load("media.php?ajax=rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

            /*simpan form_update_rq_LN*/
            $('body').on('click', '#simpan_form_update_rq_ln', function (){
                 var data = $("#update_rquo").serialize();
              //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_form_update_rq_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                      //alert(data);
                    $("#update_ln").load("media.php?ajax=update_rq_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

              /*simpan RQ_HDR*/
            $('body').on('click', '#simpan_rq_hdr', function (){
                 var data = $("#rquohdr").serialize();

                 var ln = $("#jlh_ln").val();

                if(parseInt(ln)==0){
                  alert("belum ada permintaan");
                  return false;
                }
                 //alert(data);
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_rq_hdr",
               data:data,
               success: function(data) {
                    
                    window.location.href = 'media.php?inventori=rq';

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

            /*simpan update_RQ_HDR*/
            $('body').on('click', '#simpan_update_rq_hdr', function (){
                 var data = $("#update_rquohdr").serialize();

                 var ln = $("#jlh_ln").val();

                if(parseInt(ln)==0){
                  alert("belum ada permintaan");
                  return false;
                }
                 //alert(data);

              $.ajax({
               type:'post',
               url :"media.php?ajax=save_update_rq_hdr",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    window.location.href = 'media.php?inventori=rq';

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

            /*HAPUS request quotation ln*/
            $('body').on('click', '.hapus_rq', function (){
               var data = $(this).attr('id');
              //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_rq_ln&id="+data,
               data:data,
               success: function(data) {
                $("#result").load("media.php?ajax=rq_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
               
            });

          /*HAPUS update request quotation ln*/
            $('body').on('click', '.hapus_update_rq', function (){
               var data = $(this).attr('id');
              //alert(data);
             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_update_rq_ln&id="+data,
               data:data,
               success: function(data) {
                $("#update_ln").load("media.php?ajax=update_rq_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
               
            });

            /*Edit request quotation ln temp*/
            $('body').on('click', '.edit_rq', function (){
               var data = $(this).attr('id');
     
                $("#result").load("media.php?ajax=edit_rq_ln&id="+data);
       
            });

            /*Edit request quotation ln*/
            $('body').on('click', '.update_rq', function (){
               var data = $(this).attr('id');
     
                $("#update_ln").load("media.php?ajax=form_update_rq_ln&id="+data);
       
            });

          /*nama_brand*/
             $('body').on('change', '[name=nama_brand]', function (){  
              var inventori = $(this).val();

              var id_satuan = $.trim(inventori).split("_");

              //alert(id_satuan);

              $('#nama_satuan').val(id_satuan[2]);
              $('#inv').val(id_satuan[0]);
              $('#id_satuan').val(id_satuan[3]);
              $('#brand_nama').val(id_satuan[1]);              
            });

                        /*Cancel quotation hdr*/           
            $('body').on('click', '#cancel_rq_hdr', function (){       
              $.ajax({
               type:'post',
               url :"media.php?ajax=cancel_rq_hdr",
               success: function(data) {
                     //alert(data);
                     window.location.href = 'media.php?inventori=rq';                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

                                    /*Cancel UPDATE quotation hdr*/           
            $('body').on('click', '#cancel_update_rq_hdr', function (){       
             
                     window.location.href = 'media.php?inventori=rq';                
              
               
            });

