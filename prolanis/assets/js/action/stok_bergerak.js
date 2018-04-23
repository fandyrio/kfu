
    $("#bergerak tr ").click(function(event) {
                          
             //var next = $(this).closest('tr').find('td input[type=text]:first');
            // next.attr("disabled", !this.checked);
              //next.val("00");
                var id_brand= $(this).attr('id');
                var id_departemen= $('[name=id_departemen]').val();

                  //alert(id_departemen);
                //alert(id_brand);
                var obj = {};
                 obj.nama = id_brand;
                  obj.id_departemen = id_departemen;
                     $.ajax({
                      url: 'media.php?ajax=stok_bergerak',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#stok_gerak').html(data);
                      }
                    
                      });
                

                //$("#stok_mutasi_batch").load("media.php?ajax=trf_batch_ln&id=");
            });

           /*Edit batch ln temp*/
       $('body').on('click', '.gerak_view_batch', function (){
          var data = $(this).attr('id');
          //alert(data);

              var obj ={};
                obj.nama = data;

                $.ajax({
                    url:'media.php?ajax=view_batch_stok_bergerak',
                    type:'GET',
                    data:obj,
                    success: function (data){
                        //alert(data);
                         $("#view_gerak_batch").html(data);
                    }

                });

         
        
            });

        $('body').on('click', '.view_type', function (){
          var data = $(this).attr('id').split("_");
          
          alert(data[1]);

          if(data[1]=="GRN"){
                        //window.location.href = 'media.php?inventori=stok_bergerak&modul=view_grn&id='+data[0];  
                        window.open('?inventori=stok_bergerak&modul=view_grn&id='+data[0], '_blank');     
          }
          if(data[1]=='TRF'){
            alert("TRF");
          }

             /* var obj ={};
                obj.nama = data;

                $.ajax({
                    url:'media.php?ajax=view_batch_stok_bergerak',
                    type:'GET',
                    data:obj,
                    success: function (data){
                        //alert(data);
                         $("#view_gerak_batch").html(data);
                    }

                });*/

         
        
            });


       /*hidden alamat*/
			/*$('.batch_hidden').hide();
      
	      	  $('body').on('click', '#alamat_po', function (){
    					var div = $('.batch_hidden');
    					if (div.is(':visible')) div.hide();
    					else div.show();
	      
	            });*/


