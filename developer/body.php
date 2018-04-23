<?php
$d=pg_fetch_array(pg_query($dbconn,"SELECT a.tanggal_login, a.jam_login, b.nama FROM auth_users a, master_karyawan b WHERE a.id_karyawan=b.id AND a.id_users='$_SESSION[id_users]'"));
?>
<div class="content-wrapper">


    <!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-info">
					<strong>Hi, <?php echo $d['nama'];?> .</strong>
					Waktu Login Anda : 
					<?php 
						$tanggal=DateToIndo($d['tanggal_login']);
						$jam=$d['jam_login'];
						echo "$tanggal $jam";
					?>
					
				</div>
		
				<div class="box box-success">
					<div class="box-header with-border">
						<i class="fa fa-map"></i>
						<h3 class="box-title">Data Seluruh Unit</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div id="map-canvas" style="height: 400px; width: 100%;"></div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
    </section>
    <!-- /.content -->
</div>

<?php
$relawan=pg_query($dbconn,"SELECT nama, latlong FROM master_unit");
$re=pg_fetch_array(pg_query($dbconn,"SELECT COUNT(id) AS tot FROM master_unit"));
$data="";
$no=1;
while($r=pg_fetch_array($relawan)){
	if($no<$re['tot']){
		$data.="['$r[nama]', $r[latlong]],";
	}
	else{
		$data.="['$r[nama]', $r[latlong]]";
	}
	$no++;
}
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDb3hUocjT4p9z45iwS-uiHQF6UpUFpSVU&v=3.exp&libraries=places&language=in"></script>
<script>
     
    var markers = [
      <?php echo $data;?>
    ];
 
	function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }     
        var map = new google.maps.Map(mapCanvas, mapOptions)
 
		var infowindow = new google.maps.InfoWindow(), marker, i;
		var bounds = new google.maps.LatLngBounds(); // diluar looping
		for (i = 0; i < markers.length; i++) {  
		pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
		bounds.extend(pos); // di dalam looping
		marker = new google.maps.Marker({
			position: pos,
			map: map
		});
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(markers[i][0]);
				infowindow.open(map, marker);
			}
		})(marker, i));
		map.fitBounds(bounds); // setelah looping
		}
 
	}
 google.maps.event.addDomListener(window, 'load', initialize);
</script>