
    $("#stok_saat_ini tr ").click(function(event) {
                          
             //var next = $(this).closest('tr').find('td input[type=text]:first');
            // next.attr("disabled", !this.checked);
              //next.val("00");
                var id_brand= $(this).attr('data-mit-brand');
                var id_departemen= $(this).attr('data-mit-departemen');
                var bal= $(this).attr('data-bal');

                  //alert(id_departemen);
                alert(id_brand);
                var obj 			= {};
                 obj.nama 			= id_brand;
                 obj.id_departemen 	= id_departemen;
                 obj.bal 			= bal;
                     $.ajax({
                      url: 'media.php?ajax=stok_saat_ini_batch',
                      type: 'GET',
                      data: obj,
                      success: function (data) {
                          $('#batch_cu').html(data);
                      }
                    
                      });
                

                //$("#stok_mutasi_batch").load("media.php?ajax=trf_batch_ln&id=");
            });

     /*simpan closing header*/
            $('body').on('click', '#save_closing_stok', function (){
            	alert("on development");
            	//var id_departemen= $(this).attr('data-mit-departemen');
               
              
          /*   $.ajax({
               type:'post',
               url :"media.php?ajax=save_grn_hdr&gross_total="+gross_total+"&disc_persen="+disc_persen+"&disc_amount="+disc_amount+"&persen_pajak="+persen_pajak+"&pajak_amount="+pajak_amount+"&net_total="+net_total,
               data:data,
               success: function(data) {
                  alert(data);
                 // alert("berhasil disimpan");
                 //window.location.href = 'media.php?inventori=grn';
                
               },
               error:function(exception){alert('Exeption:'+exception);}
               })*/
               
            });

          