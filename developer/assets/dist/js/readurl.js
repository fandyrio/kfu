function readURL2(input) { // Mulai membaca inputan gambar
	var val = $('#fupload2').val();

	switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
		case 'jpg': case 'png': case 'gif':
			var size = parseFloat($("#fupload2")[0].files[0].size / 1024).toFixed(2);
			if(size<=2000){
				if (input.files && input.files[0]) {
					var reader = new FileReader(); 
					var image = new Image();
					reader.onload = function (e) { 
						image.src    = e.target.result;
						image.onload = function() {
								$('#preview_gambar2')
								.attr('src', e.target.result)
								.width('100%');
							}
						}
					};
					reader.readAsDataURL(input.files[0]);
				}
			else{
				$('#fupload2').val('');
				alert("Maksimal 2000 KB image");
				return false;
			}
			break;
		default:
			$('#fupload2').val('');
			alert("Invalid extension");
			return false;
			break;
	}
}

function readURL3(input) { 
	var val = $('#fupload3').val();

	switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
		case 'jpg': case 'png':
			var size = parseFloat($("#fupload3")[0].files[0].size / 1024).toFixed(2);
			if(size<=750){
				if (input.files && input.files[0]) {
					var reader = new FileReader(); 
					var image = new Image();
					reader.onload = function (e) { 
						image.src    = e.target.result;
						image.onload = function() {
								$('#preview_gambar3')
								.attr('src', e.target.result)
								.width('100%');
							}
						}
					};
					reader.readAsDataURL(input.files[0]);
				}
			else{
				$('#fupload3').val('');
				alert("Maksimal 750 KB image");
				return false;
			}	
			break;
		break;
		default:
			$('#fupload3').val('');
			alert("Invalid extension");
			return false;
			break;
	}
}