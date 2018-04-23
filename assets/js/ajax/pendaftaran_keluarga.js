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
	
	$('#myTab2 a').click(function(e) {
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
	$('#myTab2 a[href="' + hash + '"]').tab('show');
	
	$("#id_provinsi").change(function(){
		var id_provinsi=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kabupaten',
			data	: 'id_provinsi='+id_provinsi,
			success	: function(response){
				$('#id_kabupaten').html(response);
			}
		});
	});
	
	$("#id_kabupaten").change(function(){
		var id_kabupaten=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kecamatan',
			data	: 'id_kabupaten='+id_kabupaten,
			success	: function(response){
				$('#id_kecamatan').html(response);
			}
		});
	});
	
	$("#id_kecamatan").change(function(){
		var id_kecamatan=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kelurahan',
			data	: 'id_kecamatan='+id_kecamatan,
			success	: function(response){
				//$('#id_kelurahan').html(response);

			}
		});
	});
	
	$("#id_provinsi2").change(function(){
		var id_provinsi=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kabupaten',
			data	: 'id_provinsi='+id_provinsi,
			success	: function(response){
				$('#id_kabupaten2').html(response);
			}
		});
	});
	
	$("#id_kabupaten2").change(function(){
		var id_kabupaten=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kecamatan',
			data	: 'id_kabupaten='+id_kabupaten,
			success	: function(response){
				$('#id_kecamatan2').html(response);
			}
		});
	});
	
	$("#id_kecamatan2").change(function(){
		var id_kecamatan=$(this).val();
		$.ajax({
			type 	: 'POST',
			url 	: 'data-kelurahan',
			data	: 'id_kecamatan='+id_kecamatan,
			success	: function(response){
				//$('#id_kelurahan2').html(response);

			}
		});
	});
	
	
	
	
	$("#btnSimpanKeluarga").click(function(e) {
		e.preventDefault();
		var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
		var nama = $("#nama2").val();
		var id_pekerjaan = $("#id_pekerjaan2").val();
		var no_telepon = $("#no_telepon2").val();
		var no_handphone = $("#no_handphone2").val();
		var no_telepon_kerja = $("#no_telepon_kerja2").val();
		var email = $("#email2").val();
		var id_provinsi = $("#id_provinsi2").val();
		var id_kabupaten = $("#id_kabupaten2").val();
		var id_kelurahan = $("#id_kelurahan2").val();
		var id_kecamatan = $("#id_kecamatan2").val();
		var alamat = $("#alamat2").val();
		var dataString = 'id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
		
		$.ajax({
			type:'POST',
			data:dataString,
			url:'aksi-tambah-pasien-keluarga',
			success:function(data) {
				$("#data_keluarga_pasien").html(data);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-keluarga',
			success: function(msg){
				$("#form_keluarga_pasien").html(msg);
			}
		});
	});
	
	$("#btnSimpanKeluarga2").click(function(e) {
		e.preventDefault();
		var id_pasien = $("#id_pasien").val(); 
		var id_hubungan_keluarga = $("#id_hubungan_keluarga").val(); 
		var nama = $("#nama2").val();
		var id_pekerjaan = $("#id_pekerjaan2").val();
		var no_telepon = $("#no_telepon2").val();
		var no_handphone = $("#no_handphone2").val();
		var no_telepon_kerja = $("#no_telepon_kerja2").val();
		var email = $("#email2").val();
		var id_provinsi = $("#id_provinsi2").val();
		var id_kabupaten = $("#id_kabupaten2").val();
		var id_kelurahan = $("#id_kelurahan2").val();
		var id_kecamatan = $("#id_kecamatan2").val();
		var alamat = $("#alamat2").val();
		var dataString = 'id_pasien='+id_pasien+'&id_hubungan_keluarga='+id_hubungan_keluarga+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat;
		
		$.ajax({
			type:'POST',
			data:dataString,
			url:'aksi-tambah-pasien-keluarga2',
			success:function(data) {
				$("#data_keluarga_pasien").html(data);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-keluarga2',
			success: function(msg){
				$("#form_keluarga_pasien").html(msg);
			}
		});
	});
	
	$(".btnEditKeluarga").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-keluarga',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form_keluarga_pasien").html(msg);
			}
		});
	});

	$(".btnEditKeluarga2").click(function(){
		var id = this.id;
		$.ajax({
			type: 'POST',
			url: 'edit-pasien-keluarga2',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#form_keluarga_pasien").html(msg);
			}
		});
		
	});
	
	$(".btnHapusKeluarga").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus data ini?")){
			var id = this.id;
			
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga',
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
	
	$(".btnHapusKeluarga2").click(function(){
		if(window.confirm("Apakah Anda yakin ingin menghapus data ini?")){
			var id = this.id;
			var id_pasien = $("#id_pasien").val();
			$.ajax({
				type: 'POST',
				url: 'aksi-hapus-pasien-keluarga2',
				data: { 
					'id': id
				},
				success: function(msg){
					$("#data_keluarga_pasien").html(msg);
				}
			});
			
			$.ajax({
				type: 'POST',
				url: 'form-tambah-pasien-keluarga2',
				data: { 
					'id_pasien': id_pasien
				},
				success: function(msg){
					$("#form_keluarga_pasien").html(msg);
				}
			});
		}
		else{
			return false;
		}
	});
});