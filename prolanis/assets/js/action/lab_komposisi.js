
//$("#edit_add_referal").load("media.php?ajax=add_referal_range");
$("#komposisi_lab_edit").load("media.php?ajax=load_edit_komposisi");
$("#komposisi_lab").load("media.php?ajax=load_komposisi");


$('body').on('click', '#simpan_komposisi_lab', function (){
                 var id_inv = $("#id_inv").val();
                 var jumlah = $("#jumlah").val();                
                
            var data = 'id_inv='+id_inv+'&jumlah='+jumlah;
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_load_komposisi",
               data:data,
               success: function(data) {
               //alert(data);
			         // $("#add_referal").load("media.php?ajax=add_referal_range");
                $("#komposisi_lab").load("media.php?ajax=load_komposisi");
              

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
 });

$('body').on('click', '.hapus_komposisi', function (){
            var data = $(this).attr('id');
             // alert(data);

             $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_komposisi&id="+data,
               data:data,
               success: function(data) {
                 $("#komposisi_lab").load("media.php?ajax=load_komposisi");

                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
 });

                /*simpan edit RQ_LN*/
            $('body').on('click', '#simpan_komposisi_update', function (){                 
              var id_inv = $("#id_inv").val();
              var jumlah = $("#jumlah").val();    
               var data = 'id_inv='+id_inv+'&jumlah='+jumlah;
             $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_komposisi",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                      alert(data);
                     $("#komposisi_lab_edit").load("media.php?ajax=load_edit_komposisi");

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
            });

