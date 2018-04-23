$().ready(function() {
	$('#btnLogin').click(function()
	{
		var username=$("#username").val();
		var password=$("#password").val();
		var id_unit=$("#id_unit").val();
		var dataString = 'username='+username+'&password='+password+'&id_unit='+id_unit;
		
		if($.trim(username).length>0 && $.trim(password).length>0)
		{
			$.ajax({
				type: "POST",
				url: "cek-login",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnLogin").val('CONNECTING...');},
				success: function(data){
					if(data)
					{
						if(data=='sudah_login'){
							$("#btnLogin").val('MASUK');
							$("#error").html("<div class='alert alert-warning'>Anda sudah login di tempat lain. Silahkan logout terlebih dahulu. Terima kasih</div>")
						}
						else{
							window.location.href = "home";
						}
						
					}
					else
					{
						$("#btnLogin").val('MASUK');
						$("#error").html("<div class='alert alert-danger'><strong>Oops...!</strong> Invalid username and password.</div>");
					}
				}
			});

		}
		return false;
		
	});
});