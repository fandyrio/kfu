 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    <!-- Sidebar user panel -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class=" treeview">
        <a href="media.php">
          <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="header">MENU KERJA</li>
      <!-- dashboard-->
         <!--DATA Umum -->
    <li class="treeview  ">
          <a href="#">
            <i class="fa fa-database"></i> <span>Data Umum</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="media.php?umum=provinsi"><i class="fa fa-circle-o"></i> Provinsi</a></li>
            <li><a href="media.php?umum=agama"><i class="fa fa-circle-o"></i> Agama</a></li>
            <li><a href="media.php?umum=suku"><i class="fa fa-circle-o"></i> Suku</a></li>
            <li><a href="media.php?umum=kebangsaan"><i class="fa fa-circle-o"></i> Kebangsaan</a></li>
            <li><a href="media.php?umum=goldar"><i class="fa fa-circle-o"></i> Golongan Darah</a></li>
            <li><a href="media.php?umum=status_kawin"><i class="fa fa-circle-o"></i> Status Kawin</a></li>
            <li><a href="media.php?umum=pekerjaan"><i class="fa fa-circle-o"></i> Pekerjaan</a></li>
            <li><a href="media.php?umum=jabatan"><i class="fa fa-circle-o"></i> Jabatan Pegawai</a></li>
            <li><a href="media.php?umum=segmen"><i class="fa fa-circle-o"></i> Segmen</a></li>

          </ul>
        </li>
        <!--DATA UNIT -->
		
		<li class=" treeview">
      <a href="media.php?inventori=icd10">
        <i class="fa fa-file"></i> <span>ICD 10</span>
      </a>
       <a href="media.php?inventori=icpc">
        <i class="fa fa-file"></i> <span>ICPC</span>
      </a>
    </li>
        <!--DATA Auth -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-key"></i>
            <span>Akses Level</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="media.php?auth=menu"><i class="fa fa-circle-o"></i> Modul Menu</a></li>
            <li><a href="media.php?auth=level"><i class="fa fa-circle-o"></i> Level</a></li>           
          </ul>
        </li>          
       
      
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>