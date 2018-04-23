<?php
include_once "../config/conn.php";
$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $setting['title'];?></title>
  <link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-toggle.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.css">
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="assets/plugins/iCheck/flat/blue.css"> -->
  <!-- Morris chart -->
  <!-- <link rel="stylesheet" href="assets/plugins/morris/morris.css">
  <!-- jvectormap -->
 <!-- <link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css"> -->
  <!-- Date Picker -->
  <link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <!-- <link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->

  <script type="text/javascript" src="assets/bootstrap/js/my.js"></script>

   <script type="text/javascript">
     
     <?php
            function createRandomPassword() { 

                $chars = "0123456789"; 
                srand((double)microtime()*1000000); 
                $i = 0; 
                $pass = '' ;
                $code = "RQ";
                
                $jum =date('dmy');

                while ($i <= 3) { 
                    $num = rand() % 33; 
                    $tmp = substr($chars, $num, 1); 
                    $pass = $pass . $tmp; 
                    $i++; 
                } 

                $no_member = $code.''.$jum.''.$pass;
                return $no_member; 

     }

     ?>

   </script>

</head>