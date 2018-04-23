
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Cetak</title>
	    <link href="../assert/css/bootstrap.min.css" rel="stylesheet">
	    <link href="../assert/css/jumbotron-narrow.css" rel="stylesheet">
		<script src="../assert/js/jquery.min.js"></script>
	</head>
  	<body>
    <div class="container">
       <div class="jumbotron">
        <h1 class="counter" id="printantrian">
        	0
        </h1>
        <p>
	        <a class="btn btn-lg btn-success next_queue" href="#" role="button" >
	        	Cetak Antrian
	        </a>
        </p>
      	</div>
    
    </div>
  	</body>
  	<script type="text/javascript">
	$("document").ready(function()
	{
	
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "../apps/last_stage_cetak.php",//request
			success: function(data) {
				$(".jumbotron h1").html(data["next"]);
			}
		});
	    // GET NEXT COUNTER
		$(".next_queue").click(function()
		{
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "../apps/daemon_cetak.php",//request
					success: function(data) {
						$(".jumbotron h1").html(data["next"]);

						//printDiv();
						window.open("../../cetak-nomor-antrian?id="+data['next']);
					}
				});

		});
	
	});

		function printDiv() 
		{

		  var divToPrint=document.getElementById('printantrian');

		  var newWin=window.open('','Print-Window');

		  newWin.document.open();

		  newWin.document.write('<html><head><title>Kimia Farma Diagnostika</title>');
		  newWin.document.write(' <link href="../../assets/css/style.css" rel="stylesheet"></head><body onload="window.print()">');
		  newWin.document.write('<div style="text-align:center; margin-top:10px"><h1>Nomor Antrian</h1><p style="font-size:100px">');
		  newWin.document.write(divToPrint.innerHTML);
		  newWin.document.write('</p><footer style="font-size:25px">Silahkan Menunggu</footer></div></body></html>');
		  newWin.document.close();
  
		  var res = window.location;
		}


	</script>
</html>

