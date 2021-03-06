<!DOCTYPE html>
<html lang="en">
<head>
	<title>Khao Yai</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="image/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap1/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter"></div>
		<div class="container-login100" style="background-image: url('image/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form class="login100-form validate-form" name="frmforgetPassword"  method="post" action="changsuccess.php">
					<div class="login100-form-avatar">
						<img src="image/avatar-01.png" alt="AVATAR" onclick="window.location='index.html'">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
                    Khao Yai National Park
                    <br>
                    <br>
                    <br>
                    Please input new password
					</span>
                    <input type="hidden" id="username" name="username" value="<?php echo $_GET['username'] ?>">
                    <input type="hidden" id="SID" name="SID" value="<?php echo $_GET['SID'] ?>">

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" id="Password" type="password" name="Password" placeholder="New password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" >
							Submit
						</button></a>
					</div>
					<div class="text-center w-full">
						<a class="txt1" href="register.html">
							Create new account
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
					<div class="text-center w-full p-t-25 p-b-230">
						<a href="ForgetPassword.php" class="txt1">
							Forgot Username / Password?
						</a>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap1/js/popper.js"></script>
	<script src="vendor/bootstrap1/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>