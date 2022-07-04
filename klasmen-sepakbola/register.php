<?php
include './controller/User_Controller.php';

session_start();
if (isset($_SESSION['id'])) {
	header("location:index.php");
}

$register = new User_Controller();
$pesan_form = '';
if(isset($_POST['register']))
{
	$pesan_form = $register->register($_POST);
}

$nama_depan = (isset($_POST['nama_depan'])) ? $_POST['nama_depan'] : '';
$nama_belakang = (isset($_POST['nama_belakang'])) ? $_POST['nama_belakang'] : '';
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$konfirmasi_password = (isset($_POST['konfirmasi_password'])) ? $_POST['konfirmasi_password'] : '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
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
	                            <h4 class="display-5 text-center mb-3">Registrasi</h4>
	                            <?php echo $pesan_form ?>
	                            <form method="post" action="">
	                            	<div class="row">
	                            		<div class="col-md-6">
			                                <div class="form-group mb-3">
			                                    <input name="nama_depan" value="<?= $nama_depan ?>" type="text" placeholder="Nama Depan" required class="form-control rounded-pill border-0 shadow-sm px-4">
			                                </div>
	                            		</div>
	                            		<div class="col-md-6">
			                                <div class="form-group mb-3">
			                                    <input name="nama_belakang" value="<?= $nama_belakang ?>" type="text" placeholder="Nama Belakang" required class="form-control rounded-pill border-0 shadow-sm px-4">
			                                </div>
	                            		</div>
	                            	</div>
	                                <div class="form-group mb-3">
	                                    <input name="username" value="<?= $username ?>" type="text" placeholder="Username" required class="form-control rounded-pill border-0 shadow-sm px-4">
	                                </div>
	                                <div class="form-group mb-3">
	                                    <input name="email" value="<?= $email ?>" type="email" placeholder="Email" required class="form-control rounded-pill border-0 shadow-sm px-4">
	                                </div>
	                                <div class="form-group mb-3">
	                                    <input name="password" value="<?= $password ?>" type="password" placeholder="Password" required class="form-control rounded-pill border-0 shadow-sm px-4 text-secondary">
	                                </div>
	                                <div class="form-group mb-3">
	                                    <input name="konfirmasi_password" value="<?= $konfirmasi_password ?>" type="password" placeholder="Konfirmasi Password" required class="form-control rounded-pill border-0 shadow-sm px-4 text-secondary">
	                                </div>
	                                <button name="register" type="submit" class="btn btn-secondary w-100 center btn-block text-uppercase mb-2 rounded-pill shadow-sm">Registrasi</button>
	                                <div class="text-center">
	                                	<p>Sudah punya akun? <a href="login.php">Login</a></p>
	                                </div>
	                            </form>
	                        </div>
	                    </div>
	                </div><!-- End -->

	            </div>
	        </div><!-- End -->

	    </div>
	</div>


	<script type="text/javascript" src="asset/js/jquery.min.js"></script>
	<script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
</body>
</html>