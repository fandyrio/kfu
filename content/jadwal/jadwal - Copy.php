<?php
switch($_GET['act']){
	
default:
?>
<!-- Breadcrumb -->
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="home">Dashboard</a></li>
	<li class="breadcrumb-item active">Jadwal <?php echo $kategori;?></li>

</ol>

<?php
if($kat=='tunggu'){
	?>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Data
						</div>
						<div class="card-block">
							<form action="" class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-1 form-control-label" for="id_departemen">Departemen</label>
									<div class="col-md-3">
										<select name="id_departemen" id="id_departemen" class="form-control">
										
										</select>
									</div>
									<div class="col-md-1">
										<button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-dot-circle-o"></i> Tampilkan</button>
									</div>
								</div>
							</form>
						
							<table class="table table-bordered" id="myTable">
								<thead>
									<tr>
										<th width="60px">No.</th>
										<th>Waktu Masuk</th>
										<th>Nama</th>
										<th>Jenis Kunjungan</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
elseif($kat=='resepsionis'){
	?>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Data
						</div>
						<div class="card-block">
							<table class="table table-bordered" id="myTable">
								<thead>
									<tr>
										<th width="60px">No.</th>
										<th>Waktu Masuk</th>
										<th>Nama</th>
										<th>Dokter</th>
										<th>Jenis Kunjungan</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
elseif($kat=='saya'){
	?>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-5 col-lg-5">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Tambah Jadwal
						</div>
						<div class="card-block">
							
						</div>
					</div>
				</div>
				<div class="col-sm-7 col-lg-7">
					<div class="card">
						<div class="card-header">
							<i class="icon-grid"></i> Jadwal Saya
						</div>
						<div class="card-block">
							<div id='calendar'></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '2017-10-07',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2017-10-01',
				},
				{
					title: 'Long Event',
					start: '2017-09-07',
					end: '2017-09-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-09-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-09-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2017-09-11',
					end: '2017-09-14'
				},
				{
					title: 'Meeting',
					start: '2017-09-12T10:30:00',
					end: '2017-09-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-09-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-10-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-09-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-09-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-09-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2017-09-28'
				}
			]
		});
		
	});

</script>
	<?php
}
break;

case "saya":

break;

case "buat":

break;
}
?>