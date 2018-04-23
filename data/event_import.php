 <?php
	include "../config/conn.php";
	session_start();


if(isset($_GET["id"])){
    $id=$_GET["id"];
 $result =pg_query($dbconn, "SELECT h.*, p.nama_paket FROM billing_paket_kategori_harga_unit h 
             INNER JOIN billing_paket p ON p.id = h.id_billing_paket
                       WHERE h.id_unit='$_SESSION[id_units]' and h.id_kategori_harga='$id'");

           echo "<select name='id_billing' class='form-control col-md-4' required>
                      
					<option value=''>Pilih Event</option>";

                  
    		while ($row =pg_fetch_assoc($result)){
                      echo "<option value='".$row['id_billing_paket']."'>".$row['nama_paket']."</option>";
               }
              
	     	echo "</select>";
   }else{

    echo "<select class='form-control col-md-4' required>
                      
          <option value=''>Pilih Event</option>";              
        echo "</select>";
   }     