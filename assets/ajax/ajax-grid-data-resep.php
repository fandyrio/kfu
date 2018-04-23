<?php
$idJenisPasien=$_POST['idJenisPasien'];
if($idJenisPasien==2)
{
    $fornas=1; //BPJS, tampilkan obat BPJS Saja
}
else
{
    $fornas=0;
}

/* Database connection start */
/*$host = "localhost";
$port = "5432";
$dbname = "mitcare_inventori";
$user = "postgres";
$password = "root";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$dbconn = pg_connect($connection_string) or die ('Could not connect: ' . pg_last_error());
*/
/* Database connection end */


include_once('../../config/conn.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    0 => 'sap_code',
    1 => 'catalog_name'
);

// getting total number records without any search
$sql = "SELECT catalog_id,sap_code,catalog_name ";
$sql.=" FROM item_catalog where status_fornas='$fornas'";
$query=pg_query($dbconn, $sql) or die("assets/ajax/ajax-grid-data-resep.php: get InventoryItems");
$totalData = pg_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter
    $sql = "SELECT catalog_id,sap_code,catalog_name ";
    $sql.=" FROM item_catalog";
    $sql.=" WHERE (sap_code ILIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
    $sql.=" and status_fornas='$fornas')";
    $sql.=" OR (catalog_name ILIKE '%".$requestData['search']['value']."%' ";
    $sql.=" and status_fornas='$fornas')";
    $query=pg_query($dbconn, $sql) or die("assets/ajax/ajax-grid-data-resep.php: get PO");
    $totalFiltered = pg_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT   ".$requestData['length']." OFFSET ".$requestData['start'].""; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=pg_query($dbconn, $sql) or die("assets/ajax/ajax-grid-data-resep.php: get PO"); // again run query with limit
    
} else {    

    $sql = "SELECT catalog_id,sap_code,catalog_name ";
    $sql.=" FROM item_catalog where status_fornas='$fornas'";
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT   ".$requestData['length']." OFFSET ".$requestData['start']."";
    $query=pg_query($dbconn, $sql) or die("assets/ajax/ajax-grid-data-resep.php: get PO");

    
}

$data = array();
while( $row=pg_fetch_assoc($query) ) {  // preparing an array
    $nestedData=array(); 

    $nestedData[] = $row["sap_code"];
    $nestedData[] = "<td class='text-left'>$row[catalog_name]</td>";
    $nestedData[] = '<td><center>
                     
                     <button class="btn btn-default btn-xs" id="btnTambahPesancatatResep" id_k='.$row['catalog_id'].'><i class="icon-plus"></i></button>
                     </center></td>';       
    
    $data[] = $nestedData;
    
}



$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

?>

