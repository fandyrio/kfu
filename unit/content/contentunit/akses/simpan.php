<?php
switch($_GET['act'])
{
	case "baru":
    $id_level = $_POST['id_level'];
    $post = 'ARRAY['. implode(',', $_POST['id_menu']). ']';

    $cek = pg_query($dbconn, "SELECT * FROM auth_akses_menu WHERE id_level ='".$id_level."'");
    
    if(pg_num_rows($cek>0))
    {     
    }else{
      $sql =pg_query($dbconn, "INSERT INTO auth_akses_menu(id_level, id_menu) 
                          SELECT $id_level id, x
                          FROM unnest($post) x");

    }

	if($cek){
           	$_SESSION["msg"] = 'Data berhasil ditambah.';
			$_SESSION["status"] = "sukses"; ?>
			<script>
			 document.location.href = "media.php?auth=akses";
			</script>

		<?php
	} else{
	    	$_SESSION["msg"] = 'Data gagal ditambah.';
			$_SESSION["status"] = "gagal";
			echo mysql_error();

			
			?>
			<script>
			document.location.href = "media.php?auth=akses";
				
			</script>
			<?php
	    }
	break;

	case "edit":
    $id_lev = $_POST['id_lev'];
    $post = 'ARRAY['. implode(',', $_POST['id_menu']). ']';

    $hasil =pg_query($dbconn, "Delete from auth_akses_menu where id_level='$id_lev' ");

    $sql =pg_query($dbconn, "INSERT INTO auth_akses_menu(id_level, id_menu) 
                          SELECT $id_lev id, x
                          FROM unnest($post) x");
   
 
	if($sql)
	{
		
		$_SESSION["msg"] = 'Data berhasil diubah.';
		$_SESSION["status"] = "sukses";
		?>
		<script>
			document.location.href = "media.php?auth=akses";
			
		</script>
		<?php
		
	}else
	{
		$_SESSION["msg"] = 'Data gagal diubah.';
		$_SESSION["status"] = "gagal";
		?>
		<script>
			document.location.href = "";
			
		</script>
		<?php
	}

	

	break;
}

?>