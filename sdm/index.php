<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Sistem Kepegawaian </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="aset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="aset/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="aset/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />


  </head>
  <body class="login-page " style="background: url('bg.jpg')repeat">
    <div class="login-box gradient">
      <div class="login-logo">
        <a><b>PT Kimia Farma<br/></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body ">
        <h4 class="login-box-msg">Silahkan Masuk untuk akses sistem!</h4>
		
        <form name="login-form" action="cek_login.php"  class="login-form" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback"> 
            <input name="password" type="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">                                    
            </div><!-- /.col -->
            <div class="col-xs-4">
			  <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat"><i class="ace-icon fa fa-key"></i>Masuk</button>
            </div><!-- /.col -->
          </div>
        </form>         
      </div>
    </div>

    <script src="aset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="aset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="aset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>