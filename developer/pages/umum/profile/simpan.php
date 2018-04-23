<?php
	

	$id = $_POST['id'];
	$username = pg_escape_string($_POST['username']);
	$PESAN="";
	
	
	
	$old_password = md5(pg_escape_string($_POST['old_password']));
	 $new_pass = $_POST['new_pass'];
	 $confirm_pass = $_POST['confirm_pass'];

	 if ($_POST['new_pass']!="" || !empty($_POST['new_pass'])) {
		 if ($_POST['confirm_pass']!="" || !empty($_POST['confirm_pass'])) {
		 	$res=pg_query($dbconn,"Select username from auth_users where password='$old_password' AND id_users='$id' ");

         
            if(pg_num_rows($res)>0)
            {
            	
            	if ($new_pass == $confirm_pass) {
            		
						$password = md5(pg_escape_string($_POST['new_pass']));
						$result=pg_query($dbconn,"UPDATE auth_users SET  password='".$password."' WHERE id_users = $id");	
				}
				else{

					$PESAN="PASSWORD BARU TIDAK SAMA ";
				}
				  
			}
			else{

					$PESAN="SALAH PASSWORD ";
				} 

            }
				  
	 	}
	 	else{
	 		$res=pg_query($dbconn,"Select username from auth_users where password='$old_password' AND id_users='$id' ");
	 				 if(pg_num_rows($res) > 0 )

           			 {
           			 	$res1=pg_query($dbconn,"Select id_users from auth_users where username='$username' ");
           			 	 if(pg_num_rows($res1) < 1 )

           				 {
           				 	$result=pg_query($dbconn,"UPDATE auth_users SET username='".$username."' WHERE id_users = $id");
						}
						else{
							$PESAN="USERNAME SUDAH DIGUNAKAN ";

						}
					}
					else{
						$PESAN="PASSWORD SALAH";
					}
			}		  
	

	

	if($result)
	{		
		
		?>
		<script>
			alert('success update profil');
			document.location.href = "media.php";
			
		</script>
		<?php
		
	}else
	{
		
		?>
		<script>
			alert('<?php echo $PESAN; ?>');
			document.location.href = "media.php?umum=profile";
			
		</script>
		<?php
	}

	


?>