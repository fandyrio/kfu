 $("#buka_stok").load("media.php?ajax=buka_stok_ln");
 $("#buka_stok_batch").load("media.php?ajax=buka_stok_batch");
 

$('body').on('click', '#add_buka_stok_ln', function (){
	 $("#buka_stok").load("media.php?ajax=add_buka_stok_ln");		
      			   
});
$('body').on('click', '#add_buka_stok_batch', function (){
	 $(".ghost_batch").load("media.php?ajax=add_buka_stok_batch");		
      			   
});
$('body').on('click', '.edit_bs_ln', function (){
  var data = $(this).attr('id');     
  $("#buka_stok").load("media.php?ajax=edit_bs_ln&id="+data);
       
});
$('body').on('click', '#cancel_bs_ln', function (){
      
  $("#buka_stok").load("media.php?ajax=buka_stok_ln");
       
});

$('body').on('click', '.hapus_bs_ln', function (){
  var data = $(this).attr('id');   

   $.ajax({
               type:'post',
               url :"media.php?ajax=hapus_bs_ln&id="+data,
               data:data,
               success: function(data) {
               $("#buka_stok").load("media.php?ajax=buka_stok_ln");
                //alert(data);

               },
               error:function(exception){alert('Exeption:'+exception);}
    })

 
       
});

$('body').on('click', '.edit_bs_batch', function (){
	alert("woi");
  var data = $(this).attr('id');     
  $("#buka_stok_batch").load("media.php?ajax=edit_bs_batch_directly&id="+data);
       
});
$('body').on('click', '.hapus_bs_batch', function (){
	
  var data = $(this).attr('id');     
  $("#buka_stok").load("media.php?ajax=hapus_bs_batch&id="+data);
       
});
$('body').on('click', '#simpan_edit_bs_ln', function (){
  var data = $("#edit_bs_ln").serialize();    
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_edit_bs_ln",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    //alert(data);
                    $("#buka_stok").load("media.php?ajax=buka_stok_ln");

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});
//simpan edit batch buka stok
$('body').on('click', '#save_bs_batch_directly_edit', function (){
  var data = $("#bs_batch_directly_temp_edit").serialize();    
  alert(data);
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_bs_batch_edit",
               data:data,
               success: function(data) {
                    //console.log('success',data);
                    alert('berhasil');
                    $("#buka_stok_batch").load("media.php?ajax=buka_stok_batch");

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});
 /*simpan bs_LN*/
            $('body').on('click', '#simpan_bs_ln', function (){
                 var data = $("#fsimpan_bs_ln").serialize();
                // alert(data);
            
              $.ajax({
               type:'post',
               url :"media.php?ajax=save_bs_ln",
               data:data,
               success: function(data) {
               	alert(data);
          				  $("#buka_stok").load("media.php?ajax=buka_stok_ln");
          				  
          				   var url = "media.php?ajax=add_bs_batch_directly";
                    //console.log('success',data);
                   //
				 
                   //
                    $(".angel").hide();
                    $(".ghost_batch").load(url);

               },
               error:function(exception){alert('Exeption:'+exception);}
               })
               
});

 /*ajax fomr simpan grn batch directly*/
         $('body').on('click', '#save_bs_batch_directly', function (){
					 var data = $("#bs_batch_directly_temp").serialize();
				$.ajax({
               type:'post',
               url :"media.php?ajax=save_bs_batch_directly",
               data:data,
               success: function(data) {
               alert(data);
					     $(".angel").show();
					      $(".ghost_batch").html("");
                $("#buka_stok_batch").load("media.php?ajax=buka_stok_batch");
				
               },
               error:function(exception){alert('Exeption:'+exception);}
               })	 
                  
         });


 $('body').on('click', '#tabelstok tr', function (){
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
                      url: 'media.php?ajax=buka_stok_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#buka_stok_batch').html(data);
                      }
                    
                      });
                  }

            });
 $('body').on('click', '#simpan_bs_hdr', function (){
  var data = $("#bs_hdr").serialize();   
  alert(data); 
  $.ajax({
               type:'post',
               url :"media.php?ajax=save_bs_hdr",
               data:data,
               success: function(data) {
                alert(data);
                 window.location.href = 'media.php?inventori=stok_buka';

               },
               error:function(exception){alert('Exeption:'+exception);}
  })
       
});

	