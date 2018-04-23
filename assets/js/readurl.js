function readURL(input) { // Mulai membaca inputan gambar
	var val = $('#fupload').val();

	switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
		case 'jpg': case 'png': case 'jpeg': case 'JPG': case 'PNG': case 'JPEG':
			if (input.files && input.files[0]) {
				var reader = new FileReader(); 
				var image = new Image();
				reader.onload = function (e) { 
					image.src    = e.target.result;
					image.onload = function() {
							$('#preview_gambar')
							.attr('src', e.target.result)
							.width('200px');
						}
				}
			};
			reader.readAsDataURL(input.files[0]);
			break;
		default:
			$('#fupload').val('');
			alert("Invalid extension");
			$('#preview_gambar')
			.attr('src', 'img/default.png')
			.width('200px');
			return false;
			break;
	}
}