
$("#id_provinsi3").change(function(){
	var id_provinsi=$(this).val();
	$.ajax({
		type 	: 'POST',
		url 	: 'data-kabupaten',
		data	: 'id_provinsi='+id_provinsi,
		success	: function(response){
			$('#id_kabupaten3').html(response);
		}
	});
});

$("#id_kabupaten3").change(function(){
	var id_kabupaten=$(this).val();
	$.ajax({
		type 	: 'POST',
		url 	: 'data-kecamatan',
		data	: 'id_kabupaten='+id_kabupaten,
		success	: function(response){
			$('#id_kecamatan3').html(response);
		}
	});
});

$("#id_kecamatan3").change(function(){
	var id_kecamatan=$(this).val();
	$.ajax({
		type 	: 'POST',
		url 	: 'data-kelurahan',
		data	: 'id_kecamatan='+id_kecamatan,
		success	: function(response){
			$('#id_kelurahan3').html(response);

		}
	});
});

/*PENJAMIN*/
$("#btnSimpanPenjamin").click(function(e) {
	e.preventDefault();
	var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
	var id_hubungan = $("#id_hubungan_penjamin").val(); 
	var nama= $("#nama_penjamin").val();
	var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
	var no_telepon = $("#no_telepon_penjamin").val();
	var no_handphone = $("#no_handphone_penjamin").val();
	var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
	var email = $("#email_penjamin").val();
	var visit_limit = $("#visit_limit_penjamin").val();
	var co_payment = $("#co_payment_penjamin").val();
	var id_provinsi = $("#id_provinsi3").val();
	var id_kabupaten = $("#id_kabupaten3").val();
	var id_kelurahan = $("#id_kelurahan3").val();
	var id_kecamatan = $("#id_kecamatan3").val();
	var alamat = $("#alamat_penjamin").val();
	var catatan = $("#catatan_penjamin").val();
	var dataString = 'id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
	
	$.ajax({
		type:'POST',
		data:dataString,
		url:'aksi-tambah-pasien-penjamin',
		success:function(data) {
			$("#data_penjamin_pasien").html(data);
		}
	});
	
	$.ajax({
		type: 'POST',
		url: 'form-tambah-pasien-penjamin',
		success: function(msg){
			$("#form_penjamin_pasien").html(msg);
		}
	});
});

$("#btnSimpanPenjamin2").click(function(e) {
	e.preventDefault();
	var id_pasien = $("#id_pasien").val(); 
	var id_perusahaan = $("#id_perusahaan_penjamin").val(); 
	var id_hubungan = $("#id_hubungan_penjamin").val(); 
	var nama= $("#nama_penjamin").val();
	var id_pekerjaan = $("#id_pekerjaan_penjamin").val();
	var no_telepon = $("#no_telepon_penjamin").val();
	var no_handphone = $("#no_handphone_penjamin").val();
	var no_telepon_kerja = $("#no_telepon_kerja_penjamin").val();
	var email = $("#email_penjamin").val();
	var visit_limit = $("#visit_limit_penjamin").val();
	var co_payment = $("#co_payment_penjamin").val();
	var id_provinsi = $("#id_provinsi3").val();
	var id_kabupaten = $("#id_kabupaten3").val();
	var id_kelurahan = $("#id_kelurahan3").val();
	var id_kecamatan = $("#id_kecamatan3").val();
	var alamat = $("#alamat_penjamin").val();
	var catatan = $("#catatan_penjamin").val();
	var dataString = 'id_pasien='+id_pasien+'&id_perusahaan='+id_perusahaan+'&id_hubungan='+id_hubungan+'&nama='+nama+'&id_pekerjaan='+id_pekerjaan+'&no_telepon='+no_telepon+'&no_handphone='+no_handphone+'&no_telepon_kerja='+no_telepon_kerja+'&email='+email+'&id_provinsi='+id_provinsi+'&id_kabupaten='+id_kabupaten+'&id_kecamatan='+id_kecamatan+'&id_kelurahan='+id_kelurahan+'&alamat='+alamat+'&catatan='+catatan+'&visit_limit='+visit_limit+'&co_payment='+co_payment;
	
	$.ajax({
		type:'POST',
		data:dataString,
		url:'aksi-tambah-pasien-penjamin2',
		success:function(data) {
			$("#data_penjamin_pasien").html(data);
		}
	});
	
	$.ajax({
		type: 'POST',
		data: { 
			'id_pasien': id_pasien
		},
		url: 'form-tambah-pasien-penjamin2',
		success: function(msg){
			$("#form_penjamin_pasien").html(msg);
		}
	});
});

$(".btnEditPenjamin").click(function(){
	var id = this.id;
	
	$.ajax({
		type: 'POST',
		url: 'edit-pasien-penjamin',
		data: { 
			'id': id
		},
		success: function(msg){
			$("#form_penjamin_pasien").html(msg);
		}
	});
	
});

$(".btnEditPenjamin2").click(function(){
	var id = this.id;
	$.ajax({
		type: 'POST',
		url: 'edit-pasien-penjamin2',
		data: { 
			'id': id
		},
		success: function(msg){
			$("#form_penjamin_pasien").html(msg);
		}
	});
	
});

$(".btnHapusPenjamin").click(function(){
	if(window.confirm("Apakah Anda yakin ingin menghapus data ini?")){
		var id = this.id;
		
		$.ajax({
			type: 'POST',
			url: 'aksi-hapus-pasien-penjamin',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_penjamin_pasien").html(msg);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-penjamin',
			success: function(msg){
				$("#form_penjamin_pasien").html(msg);
			}
		});
	}
	else{
		return false;
	}
});

$(".btnHapusPenjamin2").click(function(){
	if(window.confirm("Apakah Anda yakin ingin menghapus data ini?")){
		var id = this.id;
		var id_pasien = $("#id_pasien").val();
		$.ajax({
			type: 'POST',
			url: 'aksi-hapus-pasien-penjamin2',
			data: { 
				'id': id
			},
			success: function(msg){
				$("#data_penjamin_pasien").html(msg);
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'form-tambah-pasien-penjamin2',
			data: { 
				'id_pasien': id_pasien
			},
			success: function(msg){
				$("#form_penjamin_pasien").html(msg);
			}
		});
	}
	else{
		return false;
	}
});