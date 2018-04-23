<?php
error_reporting(0);
session_start();
include "../timeout.php";
date_default_timezone_set("Asia/Jakarta");
if($_SESSION['login']==1){
	if(!cek_login()){
		$_SESSION['login'] = 0;
	}
}
if($_SESSION['login']==0){
  header('location:keluar');
}

else{
$_SESSION['id_users']=$_SESSION['login_user']; 

include "../config/conn.php";
$users=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_kategori_harga WHERE id='$_SESSION[login_user]'"));

$setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="../images/<?php echo $setting['logo'];?>">
    <title>Partner Penjamin ::: <?php echo $setting['title'];?></title>

    
	<link href="../assets/css/animate.min.css" rel="stylesheet">
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Icons -->
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../assets/css/style_media.css" rel="stylesheet">
    <link href="../assets/css/modal.css" rel="stylesheet">
    <link href="../assets/js/datepicker/datepicker3.css" rel="stylesheet">

	
	<!--calendar-->
	<link href="../assets/css/fullcalendar.min.css" rel="stylesheet" />
	<link href="../assets/css/fullcalendar.print.min.css" rel="stylesheet" media="print" />
	
	<!--select2-->
	<link rel="stylesheet" href="../assets/css/select2.min.css">
    <style type="text/css">
            .canvasChart {
                width: 70%;
                margin: 0px auto;
            }

        #loading{
            background: whitesmoke;
            position: absolute;
            top: 140px;
            left: 82px;
            padding: 5px 10px;
            border: 1px solid #ccc;
        }
    </style>

	
	<script src="../assets/js/jquery-3.1.1.min.js"></script>

    <script src="../assets/js/Chart.js"></script>
                <script>
        $(document).ready(function(){
            // Sembunyikan alert validasi kosong
            $("#kosong").hide();
        });
        </script>
    
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
        <a class="navbar-brand" href="">
			<center><img src="../images/<?php echo $setting['logo'];?>" class="img-fluid img-logo"></center>
		</a>
        <button class="navbar-toggler sidebar-minimizer d-md-down-none margin-20" type="button">☰</button>

        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="">
					<span class="title-global"><?php echo $setting['nama'];?></span>
				</a>
            </li>
        </ul>
		
		
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--img src="images/users/" class="img-avatar" alt="<?php echo $users['username'];?>"-->
                    <span class="d-md-down-none"><i class="icon-user"></i> <?php echo $users['username'];?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <a class="dropdown-item" href="profile"><i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="keluar"><i class="fa fa-lock"></i> Keluar</a>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        <div class="sidebar">
			<?php include "menu.php" ?>
            
        </div>

        <!-- Main content -->
        <main class="main">
			<?php
				include "content.php";
			?>
            
        </main>
    </div>

    <footer class="app-footer">
        <a href="#"><?php echo $setting['nama'];?></a> © 2017.
        <span class="float-right">Supported By <a href="#"><?php echo $setting['footer'];?></a>
        </span>
    </footer>

    <div id="form-modal2" class="modal fade"></div>
	
	<script src="../assets/js/datepicker/bootstrap-datepicker.js"></script>
    <script src="../assets/js/tether.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/pace.min.js"></script>
    


    <!-- Plugins and scripts required by all views -->
    <!--<script src="assets/js/Chart.min.js"></script>


    <!-- Calendar -->
	<script src="../assets/js/moment.min.js"></script>
	<script src="../assets/js/fullcalendar.min.js"></script>	

	<script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/js/views/main.js"></script>
    <script src="../assets/js/views/loader.js"></script>
	<script src="../assets/js/app.js"></script>
    
    <!-- Plugins and scripts required by this views -->

    <!-- Custom scripts required by this view -->
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	
	<script src="../assets/js/jquery.maskedinput.min.js"></script>
	<script src="../assets/js/readurl.js"></script>
	<script src="../assets/js/datatable_code.js"></script>

    <script src="../assets/js/pemisahtitik.js"></script>
	
	<!--select2-->
	<script src="../assets/js/select2.full.js"></script>
	
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		
		$(document).ready(function(){
			$(".date").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
			
			 $('.js-example-basic-single').select2();
		});


        $( function() {
            $( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy' });
            //alert('woi');
            
          } );
          $( function() {
            $( "#datepicker3" ).datepicker({ format: 'dd-mm-yyyy' });
            //alert('woi');
            
          } );

            $( function() {
            $( "#datepicker2" ).datepicker({ format: 'dd-mm-yyyy' });
          } );


            $(function(){
                // don't cache ajax or content won't be fresh
                $.ajaxSetup ({
                    cache: false
                });
                var ajax_load = "";
                
                // load() functions
                $("#rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                });

                 $("#add_rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=add_rq_ln");
                    //alert("woi");
                });
                // $("#quotation").html(ajax_load).load("media.php?ajax=q_ln");
               
                $("#cancel_rq").click(function(){
                    $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                });
                $("#cancel_q").click(function(){
                    $("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                });

                 $("#stok_gerak").html(ajax_load).load("assets/ajax/stok_bergerak.php");
                 $("#update_p_ln").html(ajax_load).load("media.php?ajax=update_po_ln"); 
                 $("#update_q_ln").html(ajax_load).load("media.php?ajax=update_q_ln"); 
                 $("#update_ln").html(ajax_load).load("media.php?ajax=update_rq_ln");
                 $("#result").html(ajax_load).load("media.php?ajax=rq_ln");
                 //$("#quotation").html(ajax_load).load("media.php?ajax=quotation");
                
                 //$("#purchase_order").html(ajax_load).load("media.php?ajax=po_ln");
               
            // end  
            });

                $(".example2 td [type=checkbox]").click(function() {
                          
                 var next = $(this).closest('tr').find('td input[type=text]:first');
                 next.attr("disabled", !this.checked);
                });

                $(".input2 td [type=checkbox]").click(function() {
                          
                // first find 
                //var next = $(this).closest('tr').find('td input[type=text]:first');
                //next.attr("disabled", !this.checked);
                 //var intes =  $(this).closest('tr').find('td input[type=text]:eq(0)');
                 /**/
                 var isSelected =  $(this).closest('tr').find('td input[type=text]');
                 
                  isSelected.attr("disabled", !this.checked);
                  isSelected.val(0);
                                            
        });
        $("#id_perusahaan").change(function(){
        var id_perusahaan=$(this).val();
        //alert(id_perusahaan);
        $.ajax({
            type    : 'POST',
            url     : 'data/unit.php',
            data    : 'id='+id_perusahaan,
            success : function(response){
                $('#unites').html(response);

            }
        });
    });
            
		
	</script>
</body>
</html>
<?php
pg_close($dbconn);
}
?>