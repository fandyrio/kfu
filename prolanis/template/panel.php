<?php
session_start();
$users=pg_fetch_array(pg_query($dbconn,"SELECT k.nama from auth_users u JOIN master_karyawan k on k.id=u.id_karyawan 
                                        where u.id_users = '$_SESSION[pro_user]'"));

?>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="media.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>KF</span>
      <!-- logo for regular state and mobile devices -->
     
      <img src="../images/headlogo.png" width="100px">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="../images/logo.png" class="user-image" alt="User Image">-->
              <span  style="font-weight: bold"><?php echo $users['nama'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <!--<li class="user-header">
                <img src="../images/logo.png" class="img-circle" alt="User Image">

                <p>
                   <?php echo $setting['nama'];?>
                  <small>2017</small>
                </p>
              </li>
   
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="media.php?umum=profile" class="btn btn-default btn-flat">Edit Profile</a>-->
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>