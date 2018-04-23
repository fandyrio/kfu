 <?php
            //$id_users = $_SESSION['id_users'];
            $id = $_POST['id'];
            $nama_brand = $_POST['brand_nama'];
            $jumlah = $_POST['jumlah'];
            $id_satuan = $_POST['id_satuan'];
           
            $harga_unit = $_POST['harga_unit'];
            $total_harga = $_POST['total_harga'];
            $komen = $_POST['komen'];
          
            if (!isset($_POST['diskon_persen']) || empty($_POST['diskon_persen'])) {
                    $diskon_persen = 'NULL';
                } else {
                    $diskon_persen = "'" . pg_escape_string($_POST['diskon_persen']) . "'";
                }


             if (!isset($_POST['diskon_amt']) || empty($_POST['diskon_amt'])) {
                    $diskon_amt = 'NULL';
                } else {
                    $diskon_amt = "'" . pg_escape_string($_POST['diskon_amt']) . "'";
                }
                
                if (!isset($_POST['pajak_persen'] ) || empty($_POST['pajak_persen'])) {
                    $pajak_persen = 'NULL';
                } else {
                    $pajak_persen = "'" . pg_escape_string($_POST['pajak_persen']) . "'";
                }

                if (!isset($_POST['pajak_amt']) || empty($_POST['pajak_amt'])) {
                    $pajak_amt = 'NULL';
                } else {
                    $pajak_amt = "'" . pg_escape_string($_POST['pajak_amt']) . "'";
                }   
 
            $nett_total = $_POST['nett_total'];
            $id_inv = $_POST['id_inv'];



            $res=pg_query($dbconn,"UPDATE po_ln set 
			nama_brand='".$nama_brand."',
			id_satuan='".$id_satuan."', 
			jumlah='".$jumlah."'
            , harga_unit='".$harga_unit."'
            , total_harga='".$total_harga."'
            , komen='".$komen."'
            , diskon_amt=$diskon_amt
            , diskon_persen=$diskon_persen
            , pajak_persen=$pajak_persen
            , pajak_amt=$pajak_amt
            , nett_total='".$nett_total."'
            , id_inv='".$id_inv."'
			WHERE id = '".$id."'");

                     
            /*var_dump("UPDATE po_ln_temp set 
            nama_brand='".$nama_brand."',
            id_satuan='".$id_satuan."', 
            jumlah='".$jumlah."'
            , harga_unit='".$harga_unit."'
            , total_harga='".$total_harga."'
            , komen='".$komen."'
            , diskon_amt=$diskon_amt
            , diskon_persen=$diskon_persen
            , pajak_persen=$pajak_persen
            , pajak_amt=$pajak_amt
            , nett_total='".$total_harga."'
            , id_inv='".$id_inv."'
            WHERE id = '".$id."'");*/
?>  