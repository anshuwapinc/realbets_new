<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Realbets</title>


	<link rel="icon" href="<?php echo base_url(); ?>assets/login/logo.png">

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>assets/login/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo base_url(); ?>assets/login/all.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/login/css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>assets/login/style.css" rel="stylesheet">
	<style>
		.alert-danger,
		.alert-success {
			width: 78% !important;
			margin-left: 12% !important;
		}

		.strike {
			display: block;
			text-align: center;
			overflow: hidden;
			white-space: nowrap;
			margin-top: 15px;

			margin-bottom: 15px;
		}

		.strike>span {
			position: relative;
			display: inline-block;
		}

		.strike>span:before,
		.strike>span:after {
			content: "";
			position: absolute;
			top: 50%;
			width: 9999px;
			height: 1px;
			background: grey;
		}

		.strike>span:before {
			right: 100%;
			margin-right: 15px;
		}

		.strike>span:after {
			left: 100%;
			margin-left: 15px;
		}

		input:focus {
			border-left: 3px solid #ffb80c !important;
			border-bottom: 1px solid #1c1c1c !important;
		}

		.contact_support_div {
			margin: 14px auto;
			border-radius: 8px;
			border: 1px solid #757575;
			width: 87%;
			padding: 0;
			position: relative;
			background: #ffffff61;
			border: 1px solid #757575;
		}

		.contact_title {
			font-weight: 700;
			color: #000;
			font-size: 18px;
			padding: 6px;
			border-bottom: 1px solid #757575;
		}

		.contact-body {
			padding: 6px;
		}

		@media (pointer:fine) {
			.contact_support_div {
				width: 350px !important
			}
		}
	</style>
	<script type="text/javascript">

	</script>
</head>

<body>
	<div class="login_container bg_login" style="background-image: url(<?php echo base_url(); ?>assets/login/background.jpg)">
		<div class="login_wrapper-bg">
			<div class="lazy-container-login" id="wrapper">
				<div class="rllogin-header"><img src="<?php echo base_url(); ?>assets/login/logo.png" alt="..."></div>
				<form autocomplete="off" action="<?php echo current_url(); ?>" method="post">
					<div id="login" class="form">
						<?php

						if (!empty($message)) {
						?>
							<div class="alert alert-danger ">
								<button type="button" class="close" onclick="document.querySelector('.alert').remove()" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $message; ?>
							</div>
						<?php
						}

						$errors = validation_errors();


						if (!empty($errors)) {
						?>
							<div class="alert alert-danger ">
								<button type="button" class="close" onclick="document.querySelector('.alert').remove()" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $errors; ?>
							</div>
						<?php
						} ?>
						<?php if (!empty($_SESSION['signup_success'])) {
						?>
							<div class="alert alert-success ">
								<button type="button" class="close" onclick="document.querySelector('.alert').remove()" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $_SESSION['signup_success']; ?>
							</div>
						<?php
						} ?>


						<div class="login_wrapper">

							<div class="form-group">
								<input type="text" name="login_username" id="login_username" value="" placeholder="Username" required="1" class="form-control user_input">
							</div>
							<div class="form-group">
								<input type="password" name="login_password" id="login_password" value="" placeholder="Password" required="1" class="form-control pass_input">
							</div>

							<div class="checkboxs">
								<label><input type="checkbox" name="remember" id="remember" checked=""> Remember me
									<span class="text-muted" style="padding-left:20px"><a href="<?php echo base_url('forgot-password') ?>">Forgot Password</a></span>
								</label>
								<!-- <a href="#" class="apk-btn"><img src="<?php echo base_url(); ?>assets/login/android_app_btn.png" alt="..."></a> -->
							</div>

						</div>
						<div class="login_ftrmy">

							<div class="button-groups">

								<button type="submit" class="btn btn-success">Login</button>


								<!-- <a href="<?php echo base_url(); ?>sign-up" class="btn btn-success">Sign Up</a> -->
							</div>
							<div class="strike">
								<span>or</span>

							</div>




							<div class="button-groups">

								<a href="<?php echo base_url(); ?>sign-up" class="btn btn-success">Sign Up</a>

							</div>
							<label style="padding-top:8px">Create a new account and get 10% bonus</label>
							<!-- <div class="betfairlogo">
								<img src="<?php echo base_url(); ?>assets/login/orbit-betfair.png" alt="...">
							</div> -->
						</div>
				</form>


			</div>

		</div>
	</div>
	<div class="contact_support_div">
		<div class=" col-md-12 col-sm-12 contact_title text-center">
			Contact Support
		</div>
		<div class="contact-body text-center">
			<!-- <a class="btn btn-success  " href="tel:9530201155">+91 9530201155</a> -->
			<a class="btn btn-success  " href="tel:9530201155">venturehubenterprises@gmail.com</a>

		</div>
	</div>



	<div class="partner_logo">
		<img src="<?php echo base_url(); ?>assets/login/img-01.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-02.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-03.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-04.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-05.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-06.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-07.png" alt="...">
		<img src="<?php echo base_url(); ?>assets/login/img-08.png" alt="...">
	</div>
	</div>

	<script type="text/javascript">
		document.onkeydown = function(e) {
			//   if(event.keyCode == 123) {
			//       return false;
			//   }
			//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
			//       return false;
			//   }
			//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
			//       return false;
			//   }
			//  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
			//       return false;
			//   }
			//   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
			//       return false;
			//   }
		}
	</script>

</body>

</html>