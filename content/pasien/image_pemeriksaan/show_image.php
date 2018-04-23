<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../../config/conn.php";
$idImage=$_POST['id'];

$getImage=pg_query("SELECT * from pasien_image_pemeriksaan where id='$idImage'");
$fetchImage=pg_fetch_assoc($getImage);

?>
<div class="modal-dialog modal-lg modal-success">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="title-form">Foto</h6>
		</div>
		<div class="modal-body" id="form-data">
			<img src="content/pasien/image_pemeriksaan/images/<?php echo $fetchImage['file'];?>">
		</div>
	</div>
</div>