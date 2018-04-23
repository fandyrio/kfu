<?php
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


include_once('../../../config/conn.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    0 => 'kode',
    1 => 'nama'
);

// getting total number records without any search
$sql = "SELECT id,kode,nama ";
$sql.=" FROM master_icpc";
$query=pg_query($dbconn, $sql) or die("content/pasien/diagnosa_icpc/ajax-grid-icpc.php: get InventoryItems");
$totalData = pg_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter
    $sql = "SELECT id, kode, nama ";
    $sql.=" FROM master_icpc";
    $sql.=" WHERE kode ILIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
    $sql.=" OR nama ILIKE '%".$requestData['search']['value']."%' ";
    $query=pg_query($dbconn, $sql) or die("content/pasien/diagnosa_icpc/ajax-grid-icpc.php: get PO");
    $totalFiltered = pg_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT   ".$requestData['length']." OFFSET ".$requestData['start'].""; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=pg_query($dbconn, $sql) or die("content/pasien/diagnosa_icpc/ajax-grid-icpc.php: get PO"); // again run query with limit
    
} else {    

    $sql = "SELECT id, kode, nama ";
    $sql.=" FROM master_icpc";
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT   ".$requestData['length']." OFFSET ".$requestData['start']."";
    $query=pg_query($dbconn, $sql) or die("content/pasien/diagnosa_icpc/ajax-grid-icpc.php: get PO");

    
}

$data = array();
while( $row=pg_fetch_assoc($query) ) {  // preparing an array
    $nestedData=array(); 

    $nestedData[] = $row["kode"];
    $nestedData[] = "<td class='text-left'>$row[nama]</td>";
    $nestedData[] = '<td><center>
                     <button class="btn btn-default btn-xs btnTambahDiagnosaIcpc" id='.$row['id'].'><i class="icon-plus"></i></button>
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
