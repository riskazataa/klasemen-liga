<?php
include './controller/User_Controller.php';

session_start();
if (isset($_SESSION['id'])) {
	header("location:index.php");
}

$email = (isset($_SESSION['email'])) ? $_SESSION['email'] : '';
$password = (isset($_SESSION['password'])) ? $_SESSION['password'] : '';

$login = new User_Controller();
$login = $login->login($_POST);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	
	<div class="container-fluid vh-100">
	    <div class="row no-gutter">
	        <!-- The image half -->
	        <div class="col-md-6 d-none d-md-flex bg-image"></div>


	        <!-- The content half -->
	        <div class="col-md-6 bg-light">
	            <div class="login d-flex align-items-center py-5">

	                <!-- Demo content-->
	                <div class="container">
	                    <div class="row">
	                        <div class="col-lg-10 col-xl-7 mx-auto">
	                            <h3 class="display-4">Login</h3>
	                            <p class="text-muted mb-4">Login untuk mengelola klasemen.</p>
	                            <?php echo $login ?>
	                            <form method="post" action="">
	                                <div class="form-group mb-3">
	                                    <input name="email" type="text" placeholder="Username/Email" value="<?php echo $email ?>" class="form-control rounded-pill border-0 shadow-sm px-4">
	                                </div>
	                                <div class="form-group mb-3">
	                                    <input name="password" type="password" placeholder="Password" value="<?php echo $password ?>" class="form-control rounded-pill border-0 shadow-sm px-4 text-secondary">
	                                </div>
	                                <div class="custom-control custom-checkbox mb-3">
	                                    <input name="ingat" type="checkbox" checked class="custom-control-input">
	                                    <label for="customCheck1" class="custom-control-label">Ingat Saya</label>
	                                </div>
	                                <button name="login" type="submit" class="btn btn-secondary w-100 btn-block text-uppercase mb-2 rounded-pill shadow-sm">Login</button>
	                                <div class="text-center">
	                                	<p>Belum punya akun? <a href="register.php">Register</a></p>
	                                </div>
	                            </form>
	                        </div>
	                    </div>
	                </div><!-- End -->

	            </div>
	        </div><!-- End -->

	    </div>
	</div>

	<script type="text/javascript" src="./asset/js/jquery.min.js"></script>
	<script type="text/javascript" src="./asset/js/bootstrap.min.js"></script>
</body>
</html>