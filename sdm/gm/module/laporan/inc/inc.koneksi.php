<?php 

$host = "localhost";
$port = "5432";
$dbname = "kf_sdm";
$user = "postgres";
$password = "root";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";
$dbconn = pg_connect($connection_string);


if($dbconn){
  //echo "Connected to ". pg_host($dbconn); 
}else{
    echo "Error in connecting to database.";
}




?>