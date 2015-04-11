<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>MVTS DASHBOARD | Log in</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.2 -->
	<link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Font Awesome Icons -->
	<link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- iCheck -->
	<link href="{{ asset('plugins/iCheck/square/red.css') }}" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body class="login-page skin-red">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/') }}"><b>MVTS</b>Dashboard</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Sign in to start your session</p>
			{{ Form::open(array('url'=>'/backend/user/login')) }}
			<div class="form-group has-feedback">
				{{ 
					Form::text(
					'email', 
					null, 
					array(
					'id'=>'email', 
					'class'=>'form-control',
					'placeholder'=>'Email',
					'autofocus'=>'',
					)
					) 
				}}
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				{{ 
					Form::password(
					'password',
					array(
					'id'=>'inputPassword', 
					'class'=>'form-control',
					'placeholder'=>'Password',
					)
					) 
				}}
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">    
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="remember_me"> Remember Me
						</label>
					</div>                        
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
				</div><!-- /.col -->
			</div>
			{{ Form::close() }}

			<!-- <a href="#">I forgot my password</a><br> -->

		</div><!-- /.login-box-body -->

		@if(Session::has('error'))
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Opps!</h4>
			{{ Session::get('error') }}
		</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Yes!</h4>
			{{ Session::get('success') }}
		</div>
		@endif

	</div>
<!-- /.login-box -->

<!-- jQuery 2.1.3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-red',
			radioClass: 'iradio_square-red',
increaseArea: '20%' // optional
});
	});
</script>
</body>
</html>