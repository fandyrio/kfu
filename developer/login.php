<?php
       include "template/head.php";
       require_once '../config/conn.php';
       require_once '../config/library.php';
	   $setting=pg_fetch_array(pg_query($dbconn,"SELECT * FROM master_setting"));
?>
<body class="hold-transition login-page" >
<div class="hidden-xs">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">
	<div class="login-logo">
    <img src="../images/<?php echo $setting['logo'];?>" class="user-image" alt="User Image" style="width:auto; height: 100px;">
  </div>
    <p class="login-box-msg">Silahkan masukkan username dan password</p>

    <form action="" name="f1" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <input type="submit" name="masuk" value="Masuk" class="btn btn-primary btn-block btn-flat">
         
        </div>
        <!-- /.col -->
      </div>
    </form>
   
      <?php

          if(!empty($_POST['masuk']))
          {
            
            $username = $_POST['username'];
           
            $password = md5($_POST['password']);

            $res=pg_query($dbconn,("Select * from administrator WHERE username='$username' AND password='$password'"));

         
            if(pg_num_rows($res)>0)
            {
              $data=pg_fetch_array($res);
              if($data[1] == $password)
              {
                $message_ok=true;
                $_SESSION['username'] = $data[0];
                $_SESSION['user_login'] = $data[0];

                 $result=pg_query($dbconn,("UPDATE administrator SET waktu_login='$tgl_sekarang $jam_sekarang' WHERE username = '".$data[0]."'"));
               
          ?>
                          <script>
                document.location.href = "media.php";
                </script>

            <?php
              }
                else
              {
                echo "<span class='label label-danger'>Password anda salah</span>";
              }
            }else
            {
              echo "<span class='label label-danger'>Username anda tidak ditemukan</span>";
            }
          }
          ?>
        
          </div>
	<div class="login-right">
		<b><span class="teks-atas"><?php echo $setting['tahun'];?></span></b><br>
		<span class="teks-tengah">Target : <?php echo $setting['teks_depan'];?></span><br>
		<span class="teks-bawah">Real : 0%</span>
	</div>
  </div>
  <div class="images-footer">
	
		<img src="images/login.jpg" class="img-responsive">
	</div>
  <!-- /.login-box-body -->
</div>

<div class="visible-xs">
	<div class="login-box-body">
	<div class="login-logo">
    <img src="../images/<?php echo $setting['logo'];?>" class="user-image" alt="User Image" style="width:auto; height: 50px;">
  </div>
    <p class="login-box-msg"><?php echo $setting['nama'];?></p>

    <form action="" name="f1" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <input type="submit" name="masuk" value="Masuk" class="btn btn-primary btn-block btn-flat">
         
        </div>
        <!-- /.col -->
      </div>
    </form>
   
      <?php

          if(!empty($_POST['masuk']))
          {
            
            $username = $_POST['username'];
           
            $password = md5($_POST['password']);

            $res=pg_query($dbconn,("Select * from administrator WHERE username='$username' AND password='$password'"));

         
            if(pg_num_rows($res)>0)
            {
              $data=pg_fetch_array($res);
              if($data[1] == $password)
              {
                $message_ok=true;
                $_SESSION['username'] = $data[0];
                $_SESSION['user_login'] = $data[0];

                 $result=pg_query($dbconn,("UPDATE administrator SET waktu_login='$tgl_sekarang $jam_sekarang' WHERE username = '".$data[0]."'"));
               
          ?>
                          <script>
                document.location.href = "media.php";
                </script>

            <?php
              }
                else
              {
                echo "<span class='label label-danger'>Password anda salah</span>";
              }
            }else
            {
              echo "<span class='label label-danger'>Username anda tidak ditemukan</span>";
            }
          }
          ?>
        
          </div>
		<div class="login-bottom">
			<b><?php echo $setting['tahun'];?></b><br>
			Target <?php echo $setting['teks_depan'];?><br>
			Real 0%
		</div>
	<img src="images/login.jpg" class="img-responsive">
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->

<!-- jQuery 2.2.3 -->
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->


</body>
</html>
