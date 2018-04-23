$(function () {
	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});

	// store the currently selected tab in the hash value
	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		var id = $(e.target).attr("href").substr(1);
		window.location.hash = id;
	});

	// on load of the page: switch to the currently selected tab
	var hash = window.location.hash;
	$('#myTab a[href="' + hash + '"]').tab('show');
	
	
	
	$(".btnInfoPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-data-info',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});	

	$(".btnPemeriksaanFisik").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-pemeriksaan-fisik',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});	

	$(".btnKesimpulanAnamnesa").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-kesimpulan-saran',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});	
	
	$(".btnKunjunganPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-data-kunjungan',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});	
	
	$(".btnPerhatianPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-perhatian',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	
	$(".btnPeringatanPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-peringatan',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnOrderPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-order',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnSingleTestPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-singletest',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnMultiTestPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-multitest',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnNonLabPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-nonlab',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnMcuPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-mcu',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnAnamnesaPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-anamnesa',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnPemeriksaanFisikPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-fisik',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnMataPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-mata',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnThtPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-tht',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnMulutPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-mulut',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnLeherPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-leher',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	
	$(".btnThoraxPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-thorax',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	//
	$(".btnAbdomenPasien").click(function(){
		var id = this.id;
		//alert(id);
		$.ajax({
			type: 'POST',
			url: 'pasien-abdomen',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnRektalPasien").click(function(){
		var id = this.id;
		//alert(id);
		$.ajax({
			type: 'POST',
			url: 'pasien-rektal',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnExtremitasPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-extremitas',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnPemeriksaanNeurologisPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-neurologis',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnPemeriksaanKulitPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-kulit',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnLainPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-lain',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	$(".btnResepPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'resep-pasien',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnHasilLabPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-hasillab',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	$(".btnFormPemeriksaan").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'form-pemeriksaan',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	$(".btnAmbilSampel").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'ambil-sampel',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnAmbilGambar").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'ambil-gambar',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnGambarPasien").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-gambar',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	$(".btnResepObat").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'resep-obat',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnCatatResep").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'catat-resep',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
});