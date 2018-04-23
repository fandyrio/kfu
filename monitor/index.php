<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(empty($_SESSION['login_user'])){
	header("location:login");
}
else
{
	//var_dump($_SESSION['id_units']);


	?>
	 	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">    
	   
	    <title>Monitoring:::Antrian</title>
		<link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
	    <link href="../queue/assert/css/bootstrap.min.css" rel="stylesheet">
	    <link href="../queue/assert/css/jumbotron-narrow-monitoring.css" rel="stylesheet">
		<script src="../queue/assert/js/jquery.min.js"></script>
		<div class="audio">
			<audio id="in" src="../queue/audio/new/in.wav"></audio>
		  	<audio id="out" src="../queue/audio/new/out.wav"></audio>
		  	<audio id="suarabel" src="../queue/audio/new/Airport_Bell.mp3"></audio>
			<audio id="suarabelnomorurut" src="../queue/audio/new/nomor-urut.MP3"></audio> 
			<audio id="suarabelsuarabelloket" src="../queue/audio/new/konter.MP3"></audio> 
			<audio id="belas" src="../queue/audio/new/belas.MP3"></audio> 
			<audio id="sebelas" src="../queue/audio/new/sebelas.MP3"></audio> 
			<audio id="puluh" src="../queue/audio/new/puluh.MP3"></audio> 
			<audio id="sepuluh" src="../queue/audio/new/sepuluh.MP3"></audio> 
			<audio id="ratus" src="../queue/audio/new/ratus.MP3"></audio> 
			<audio id="seratus" src="../queue/audio/new/seratus.MP3"></audio> 
			<audio id="UMUM_1" src="../queue/audio/new/umum_1.MP3"></audio> 
			<audio id="UMUM_2" src="../queue/audio/new/umum_2.MP3"></audio> 
			<audio id="UMUM_3" src="../queue/audio/new/umum_3.MP3"></audio> 
			<audio id="GIGI DAN MULUT-1" src="../queue/audio/new/gigi.MP3"></audio> 
			<audio id="suarabelloket5" src="../queue/audio/new/5.MP3"></audio> 
			<audio id="suarabelloket6" src="../queue/audio/new/6.MP3"></audio> 
			<audio id="suarabelloket7" src="../queue/audio/new/7.MP3"></audio> 
			<audio id="suarabelloket8" src="../queue/audio/new/8.MP3"></audio> 
			<audio id="suarabelloket9" src="../queue/audio/new/9.MP3"></audio> 
			<audio id="suarabelloket10" src="../queue/audio/new/sepuluh.MP3"></audio> 
			<audio id="loket" src="../queue/audio/new/dipoli.MP3"></audio> 
		</div>
		<?php
		include "show_antrian.php";

}
?>   

<script type="text/javascript">
	$(document).ready(function()
	{
		var id_unit="<?php echo $id_unit ?>";
		setInterval(function() {
			$.ajax(
			{
				url:'sound.php',
				success:function(result)
				{
					var data=JSON.parse(result);
					console.log(data);
					var token=data.token;
					var noAntrian=data.no_cetak_antrian;
					var getRoom=data.getRoom;
					var idunit=data.idUnit;
					console.log(idunit);
					if(id_unit==idunit)
					{
						if(token=="XXI")
						{
							$("#"+getRoom).html(noAntrian);
							play(noAntrian,getRoom);
						}
					}
					
				},
				error:function(result)
				{
					var data=JSON.parse(result);
					alert(data);
				}
			});

		}, 1000);
			
	});

	function play(noAntrian,getRoom)
	{

		var inAntrian = $("#in")[0];
		var room = getRoom;
		var myarr = room.split("-");
		var loket=myarr[0]+"_"+myarr[1];
		var totalwaktu = 8568.163;
		var urut=noAntrian;
		for (var i = 0 ; i < urut.toString().length; i++) {
						$(".audio").append('<audio id="suarabel'+i+'" src="../queue/audio/new/'+urut.toString().substr(i,1)+'.MP3" ></audio>');
					};
		inAntrian.pause();
		inAntrian.currentTime=0;
		inAntrian.play();
		totalwaktu=inAntrian.duration*1000;	
		setTimeout(function() {
				document.getElementById('suarabelnomorurut').pause();
				document.getElementById('suarabelnomorurut').currentTime=0;
				document.getElementById('suarabelnomorurut').play();
		}, totalwaktu);
		totalwaktu=totalwaktu+1000;
		if(urut<10){
		
			setTimeout(function() {
					document.getElementById('suarabel0').pause();
					document.getElementById('suarabel0').currentTime=0;
					document.getElementById('suarabel0').play();
				}, totalwaktu);
			totalwaktu=totalwaktu+1000;
			setTimeout(function() {
					document.getElementById('loket').pause();
					document.getElementById('loket').currentTime=0;
					document.getElementById('loket').play();
				}, totalwaktu);
			totalwaktu=totalwaktu+1000;
			setTimeout(function() {
					document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
				}, totalwaktu);
			totalwaktu=totalwaktu+1000;
			setTimeout(function() {
					for (var i = 0 ; i < urut.toString().length; i++) {
						$("#suarabel"+i+"").remove();
					};
				}, totalwaktu);
			totalwaktu=totalwaktu+1000;
		}else if(urut==10){
				setTimeout(function() {
						document.getElementById('sepuluh').pause();
						document.getElementById('sepuluh').currentTime=0;
						document.getElementById('sepuluh').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
					document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if(urut ==11){
				setTimeout(function() {
						document.getElementById('sebelas').pause();
						document.getElementById('sebelas').currentTime=0;
						document.getElementById('sebelas').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if(urut < 20){
				setTimeout(function() {
						document.getElementById('suarabel1').pause();
						document.getElementById('suarabel1').currentTime=0;
						document.getElementById('suarabel1').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('belas').pause();
						document.getElementById('belas').currentTime=0;
						document.getElementById('belas').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if(urut < 100){
			
				setTimeout(function() {
						document.getElementById('suarabel0').pause();
						document.getElementById('suarabel0').currentTime=0;
						document.getElementById('suarabel0').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('puluh').pause();
						document.getElementById('puluh').currentTime=0;
						document.getElementById('puluh').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('suarabel1').pause();
						document.getElementById('suarabel1').currentTime=0;
						document.getElementById('suarabel1').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if(urut==100){
			setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut < 110) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('suarabel2').pause();
						document.getElementById('suarabel2').currentTime=0;
						document.getElementById('suarabel2').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut == 110) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('sepuluh').pause();
						document.getElementById('sepuluh').currentTime=0;
						document.getElementById('sepuluh').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut == 111) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('sebelas').pause();
						document.getElementById('sebelas').currentTime=0;
						document.getElementById('sebelas').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut < 120) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('suarabel2').pause();
						document.getElementById('suarabel2').currentTime=0;
						document.getElementById('suarabel2').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('belas').pause();
						document.getElementById('belas').currentTime=0;
						document.getElementById('belas').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut == 120) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('suarabel1').pause();
						document.getElementById('suarabel1').currentTime=0;
						document.getElementById('suarabel1').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('puluh').pause();
						document.getElementById('puluh').currentTime=0;
						document.getElementById('puluh').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut < 200) {
				setTimeout(function() {
						document.getElementById('seratus').pause();
						document.getElementById('seratus').currentTime=0;
						document.getElementById('seratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('suarabel1').pause();
						document.getElementById('suarabel1').currentTime=0;
						document.getElementById('suarabel1').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('puluh').pause();
						document.getElementById('puluh').currentTime=0;
						document.getElementById('puluh').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				
				if (urut%10!=0) {
					setTimeout(function() {
							document.getElementById('suarabel2').pause();
							document.getElementById('suarabel2').currentTime=0;
							document.getElementById('suarabel2').play();
						}, totalwaktu);
					totalwaktu=totalwaktu+1000;
				}

				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if (urut == 200) {
				setTimeout(function() {
						document.getElementById('suarabel0').pause();
						document.getElementById('suarabel0').currentTime=0;
						document.getElementById('suarabel0').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('ratus').pause();
						document.getElementById('ratus').currentTime=0;
						document.getElementById('ratus').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}else if(urut < 999){
				setTimeout(function() {
						document.getElementById('suarabel0').pause();
						document.getElementById('suarabel0').currentTime=0;
						document.getElementById('suarabel0').play();
				}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				if (urut.toString().substr(1,1) == 0 && urut.toString().substr(2,1)==0) { // 200 300 400 ..
					setTimeout(function() {
							document.getElementById('ratus').pause();
							document.getElementById('ratus').currentTime=0;
							document.getElementById('ratus').play();
						}, totalwaktu);
					totalwaktu=totalwaktu+1000;
				} else if(urut.toString().substr(1,1) == 0 && urut.toString().substr(2,1)!=0){ // 201 304 405 506
					setTimeout(function() {
							document.getElementById('ratus').pause();
							document.getElementById('ratus').currentTime=0;
							document.getElementById('ratus').play();
						}, totalwaktu);
					totalwaktu=totalwaktu+1000;
					setTimeout(function() {
							document.getElementById('suarabel2').pause();
							document.getElementById('suarabel2').currentTime=0;
							document.getElementById('suarabel2').play();
						}, totalwaktu);
					totalwaktu=totalwaktu+1000;
				}else if(urut.toString().substr(1,1) != 0 && urut.toString().substr(2,1)==0){ //210 250 230
					if(urut.toString().substr(1,1) == 1){ //210
						setTimeout(function() {
							document.getElementById('ratus').pause();
							document.getElementById('ratus').currentTime=0;
							document.getElementById('ratus').play();
						}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						setTimeout(function() {
							document.getElementById('sepuluh').pause();
							document.getElementById('sepuluh').currentTime=0;
							document.getElementById('sepuluh').play();
						}, totalwaktu);
						totalwaktu=totalwaktu+1000;
					}else{
						setTimeout(function() {
							document.getElementById('ratus').pause();
							document.getElementById('ratus').currentTime=0;
							document.getElementById('ratus').play();
						}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						setTimeout(function() {
							document.getElementById('suarabel1').pause();
							document.getElementById('suarabel1').currentTime=0;
							document.getElementById('suarabel1').play();
						}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						setTimeout(function() {
							document.getElementById('puluh').pause();
							document.getElementById('puluh').currentTime=0;
							document.getElementById('puluh').play();
						}, totalwaktu);
						totalwaktu=totalwaktu+1000;
					}
				}else if(urut.toString().substr(1,1) != 0 && urut.toString().substr(2,1)!=0){
					if (urut.toString().substr(1,1)==1) {
						if (urut.toString().substr(2,1)==1) { // 211 311 411 511
							setTimeout(function() {
									document.getElementById('ratus').pause();
									document.getElementById('ratus').currentTime=0;
									document.getElementById('ratus').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
							setTimeout(function() {
									document.getElementById('sebelas').pause();
									document.getElementById('sebelas').currentTime=0;
									document.getElementById('sebelas').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
						}else{ //212 215 219
							setTimeout(function() {
									document.getElementById('ratus').pause();
									document.getElementById('ratus').currentTime=0;
									document.getElementById('ratus').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
							setTimeout(function() {
									document.getElementById('suarabel2').pause();
									document.getElementById('suarabel2').currentTime=0;
									document.getElementById('suarabel2').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
							setTimeout(function() {
									document.getElementById('belas').pause();
									document.getElementById('belas').currentTime=0;
									document.getElementById('belas').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
						}
					}else{
						setTimeout(function() {
								document.getElementById('ratus').pause();
								document.getElementById('ratus').currentTime=0;
								document.getElementById('ratus').play();
							}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						setTimeout(function() {
								document.getElementById('suarabel1').pause();
								document.getElementById('suarabel1').currentTime=0;
								document.getElementById('suarabel1').play();
							}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						setTimeout(function() {
								document.getElementById('puluh').pause();
								document.getElementById('puluh').currentTime=0;
								document.getElementById('puluh').play();
							}, totalwaktu);
						totalwaktu=totalwaktu+1000;
						if (urut%10!=0) {
							setTimeout(function() {
									document.getElementById('suarabel2').pause();
									document.getElementById('suarabel2').currentTime=0;
									document.getElementById('suarabel2').play();
								}, totalwaktu);
							totalwaktu=totalwaktu+1000;
						}
					}
				}

				setTimeout(function() {
						document.getElementById('loket').pause();
						document.getElementById('loket').currentTime=0;
						document.getElementById('loket').play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						document.getElementById(loket).pause();
						document.getElementById(loket).currentTime=0;
						document.getElementById(loket).play();
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
				setTimeout(function() {
						for (var i = 0 ; i < urut.toString().length; i++) {
							$("#suarabel"+i+"").remove();
						};
					}, totalwaktu);
				totalwaktu=totalwaktu+1000;
		}

		setTimeout(function(){
			document.getElementById('out').pause();
			document.getElementById('out').currentTime=0;
			document.getElementById('out').play();
		}, totalwaktu);
		totalwaktu=totalwaktu+1000;
		/*setTimeout(function() {
			$.post("../queue/apps/monitoring-daemon-result.php", { id : urut }, function(data){
				if (!data.status) {
					console.log(data.status);		
				}
			}, 'json');
		}, totalwaktu);
		totalwaktu=totalwaktu+1000;*/
	}
	

</script>