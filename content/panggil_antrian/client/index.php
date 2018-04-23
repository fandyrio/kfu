<?php 
	session_start();
	if (!isset($_SESSION["loket_client"])) 
	{
		$_SESSION["loket_client"] = 0;
	}
?>


<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
  <li class="breadcrumb-item">Panggil Antrian</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
        <div class="card-header">
            <i class="icon-user"></i> Antrian
          </div>

    <div class="card-body">
        <button class="btn btn-sm btn-primary pull-right try_queue" type="button">
            Ulangi Panggilan &nbsp;<span class="glyphicon glyphicon-volume-up"></span>    
        </button>
        
        <div class="jumbotron">
        <h1 class="counter row justify-content-center">
        	0
        </h1>
        <p class="row justify-content-center">
	        <a class="btn btn-sm btn-success next_queue" href="#" role="button">
	        	Next &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
	        </a>
        </p>
      	</div>
    	<form>
        	<label for="exampleInputEmail1" style="text-align: left;"><span class="glyphicon glyphicon-credit-card">&nbsp;</span>NOMOR LOKET</label> 
        	<select class="form-control loket" name="loket" required>
        		<option value="0">-PILIH NOMOR LOKET-</option>
			</select>
        	<br/>
        	<div class="alert alert-danger peringatan" role="alert">
        		<strong>WARNING !!</strong>  Masukan Nomor Loket Anda.
        	</div>
    	</form>
      	<footer class="footer">
        <p>&copy;  <?php echo date("Y");?></p>
      	</footer>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

  	
  	<script type="text/javascript">
	$("document").ready(function()
	{
		// LIST LOKET
		$.post("content/panggil_antrian/apps/admin_init.php", function( data ){
			
			for (var i = 1; i <= data['client']; i++) { 					
				if ( i == <?php echo $_SESSION["loket_client"];?>)
				$('.loket').append('<option value="'+i+'" selected>'+i+'</option>');
				else
				$('.loket').append('<option value="'+i+'">'+i+'</option>');
			}
		}, "json"); 

		// SET EXSIST session LOKET
		<?php if ($_SESSION["loket_client"] != 0) { ?>
		    	$(".peringatan").hide();
		<?php } else {?>
		    	$(".peringatan").show();
		<?php } ?>
		
		// GET LAST COUNTER
		var data = {"loket": <?php echo $_SESSION["loket_client"];?>};
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "content/panggil_antrian/apps/last_stage.php",//request
			data: data,
			success: function(data) {
				$(".jumbotron h1").html(data["next"]);
			}
		});

		// NUMBER LOKET
	    $('form select').data('val',  $('form select').val() );
	    $('form select').change(function() {
	    	//set seassion or save
	    	var data = {"loket": $(".loket").val()};
	    	if ( $(".loket").val() != 0 ) {
	    		$(".peringatan").hide();
	    	}else{
	    		$(".peringatan").show();
	    	}
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "content/panggil_antrian/apps/set_loket.php",//request
				data: data,
				success: function(data) {
					$(".jumbotron h1").html(data["next"]);
				}
			});
	    });
	    $('form select').keyup(function() {
	        if( $('form select').val() != $('form select').data('val') ){
	            $('form select').data('val',  $('form select').val() );
	            $(this).change();
	        }
	    });

	    // GET NEXT COUNTER
		$(".next_queue").click(function()
		{
			var loket = $(".loket").val();
			if (loket==0) {
				$(".peringatan").show();
			}else{
				var data = {"loket" : loket};
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "content/panggil_antrian/apps/daemon.php",//request
					data: data,
					success: function(data) {
						$(".jumbotron h1").html(data["next"]);
						if (data["idle"]=="TRUE") {
							$(".next_queue").hide();
							clearInterval(timerId_adik);
							adik_adudu(loket, data["next"]);
							//window.location.href = 'panggil-antrian';

							


						}
					}
				});
				return false;
			}
			
		});

		var timerId=0;
		// ADUDU
		function adudu(loket, counter){
			timerId = setInterval(function() {
				 $.post("content/panggil_antrian/apps/daemon_try_cek.php", { loket : loket, counter : counter }, function(msg){
					if(msg.huft == 2){
						$(".try_queue").show();
					}
				},'JSON');
			}, 1000);
		 }
		
		var timerId_adik=0;
		// ADIK_ADUDU
		function adik_adudu(loket, counter){
			timerId_adik = setInterval(function() {
				 $.post("content/panggil_antrian/apps/daemon_cek.php", { loket : loket, counter : counter }, function(msg){
					if(msg.huft == 2){
						$(".next_queue").show();
					}
				},'JSON');
			}, 1000);
		}

		// TRY CALL
		$(".try_queue").click(function(){
			var loket = $(".loket").val();

		
			if (loket==0) {
	    		$(".peringatan").show();
			}else{
				var counter = $(".counter").text();
				
				$.post("content/panggil_antrian/apps/daemon_try.php", { loket : loket, counter : counter }, function(msg){
					if(msg.huft == 0){
						$(".try_queue").hide();
						clearInterval(timerId);
						adudu(loket, counter);
					}
				},'JSON'); //request
				return false;
			}
		});	
		
	});
	</script>

