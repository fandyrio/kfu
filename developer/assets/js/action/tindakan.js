
      $('body').on('click', '#simpan_tindakan', function (){
                       var data = $("#form-tambah-tindakan").serialize();
                   // alert(data);
                  
                 $.ajax({
                     type:'post',
                     url :"media.php?ajax=save_tindakan",
                     data:data,
                     success: function(data) {
                      

                       window.location.href = 'media.php?tindakan=tindakan';
                     

                     },
                     error:function(exception){alert('Exeption:'+exception);}
                     })
       });

       $('body').on('click', '#simpan_tindakan_update', function (){
                    var data = $("#form-update-tindakan").serialize();    

                  
               $.ajax({
                     type:'post',
                     url :"media.php?ajax=update_tindakan",
                     data:data,
                     success: function(data) {                                          
                       window.location.href = 'media.php?tindakan=tindakan';
                     

                     },
                     error:function(exception){
                      //window.location.href = 'media.php?tindakan=tindakan';
                      alert('Exeption:'+exception);
                      }
                     })
                     
       });

       $('body').on('click', '#simpan_tindakan_group', function (){
                       var data = $("#form-tambah-tindakan-group").serialize();                   
                  
                   $.ajax({
                     type:'post',
                     url :"media.php?ajax=save_tindakan_group",
                     data:data,
                     success: function(data) {
                    
                      window.location.href = 'media.php?tindakan=tindakan_group';                    

                     },
                     error:function(exception){alert('Exeption:'+exception);}
                     })
       });

       $('body').on('click', '#simpan_tindakan_group_update', function (){
                    var data = $("#form-update-tindakan-group").serialize();
                   
              $.ajax({
                     type:'post',
                     url :"media.php?ajax=update_tindakan_group",
                     data:data,
                     success: function(data) {
                     

                       window.location.href = 'media.php?tindakan=tindakan_group';
                     

                     },
                     error:function(exception){alert('Exeption:'+exception);}
                     })
                    
                     
       });




            

