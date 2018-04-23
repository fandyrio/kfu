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
		$("html, body").animate({ scrollTop: "0px"}); 
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
	
		var position = $("#data_pasien").offset().top; 
		$("html, body").animate({ scrollTop: "0px"}); 

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

	$(".suratKeteranganSehat").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-surat-sehat',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});	

	$(".suratKeteranganSakit").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-surat-sakit',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});	

	$(".suratBebasNarkoba").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-bebas-narkoba',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});

	$(".suratRujukan").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-rujukan',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});

	$(".inform_consent").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-inform',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});

	$(".uploadImage").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;

		$.ajax({
			type: 'POST',
			url: 'uploadImage',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});

	$(".catatResep").click(function(){
		
		var position = $("#data_pasien").offset().top; 

		$("html, body").animate({ scrollTop: "0px"}); 

		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'listResep',
			data: { 
				'id': id
			},
			success: function(msg){

				$("#data_pasien").html(msg);
			}
		});
	});

	

	$(".btnKesimpulanAnamnesa").click(function(){
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
	
	
	$(".btnKeluhanPasien").click(function(){
		$("html, body").animate({ scrollTop: "0px"}); 
		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'pasien-keluhan',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});
	
	$(".btnOrderPasien").click(function(){
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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
		$("html, body").animate({ scrollTop: "0px"}); 
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

	$(".btnDiagnosaPasien").click(function(){
		var position = $("#data_pasien").offset().top; 
		$("html, body").animate({ scrollTop: "0px"}); 
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-diagnosa',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnDiagnosaPasienIcpc").click(function(){
		
		var position = $("#data_pasien").offset().top; 
		$("html, body").animate({ scrollTop: "0px"}); 
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'pasien-diagnosa-icpc',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_pasien").html(msg);
			}
		});
	});

	$(".btnTindakLanjut").click(function(){
			var position = $("#data_pasien").offset().top; 
			$("html, body").animate({ scrollTop: "0px"}); 
			var id = this.id;
			$.ajax({
				type: 'POST',
				url: 'pasien-tindak-lanjut',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_pasien").html(msg);
				}
			});
	});
	$(".btnManualLab").click(function(){
			var position = $("#data_pasien").offset().top; 
			$("html, body").animate({ scrollTop: "100px"}); 
			var id = this.id;
			$.ajax({
				type: 'POST',
				url: 'content/pasien/manual_lab/manual_lab.php',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_pasien").html(msg);
				}
			});
		});	
});