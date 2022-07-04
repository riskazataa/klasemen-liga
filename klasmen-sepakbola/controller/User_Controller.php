<?php
require_once 'Mysql.php';

class User_Controller extends Mysql {

    function __construct() {
    	$this->dbConnect();
    }

    function login($params){
    	$pesan_form = '';
		if (isset($params['login'])) {
			if (empty($params['email']) || empty($params['password'])) {
				$pesan_form = '<p class="text-danger">Email dan Password harus diisi!</p>';
			} else{
				$login = $this->query("SELECT * FROM data_users WHERE email = '$params[email]' OR username = '$params[email]'");

				if (mysqli_num_rows($login) > 0) {
					$login = mysqli_fetch_assoc($login);
					if (!password_verify($params['password'], $login['password'])) {
						$pesan_form = '<p class="text-danger">Password salah!</p>';
						goto output;
					}

			    	session_start();
					$_SESSION['id'] = $login['id'];
					if (isset($params['ingat']) && $params['ingat'] == 'on') {
						$_SESSION['email'] = $params['email'];
						$_SESSION['password'] = $params['password'];
					} else {
						unset($_SESSION["email"]);
						unset($_SESSION["password"]);
					}
					header("location:index.php");
				} else {
					$pesan_form = '<p class="text-danger">User tidak ditemukan</p>';
				}
			} 
		}

		output:
		return $pesan_form;
    }
  
    function register($params){
    	$pesan_form = '';

		$nama_depan = $params['nama_depan'];
		$nama_belakang = $params['nama_belakang'];
		$username = $params['username'];
		$email = $params['email'];
		$password = $params['password'];
		$konfirmasi_password = $params['konfirmasi_password'];
		if (empty($nama_depan) || empty($nama_belakang) || empty($username) || empty($email) || empty($password) || empty($konfirmasi_password)) {
			$pesan_form = '<p class="text-danger">Mohon isi seluruh data!</p>';
		} else{

			if ($username != str_replace(' ', '', $username)) {
				$pesan_form = '<p class="text-danger">Username tidak boleh memiliki spasi!</p>';
				goto output;
			}

			if ($password !== $konfirmasi_password) {
				$pesan_form = '<p class="text-danger">Konfirmasi password tidak sesuai!</p>';
				goto output;	
			}

			// Cek username dan email tidak boleh sama
			$cek_email = $this->query("SELECT * FROM data_users WHERE email = '$email'");
			$cek_username = $this->query("SELECT * FROM data_users WHERE username = '$username'");
			if (mysqli_num_rows($cek_email) > 0) {
				$pesan_form = '<p class="text-danger">Email telah digunakan!</p>';
				goto output;	
			}
			if (mysqli_num_rows($cek_username) > 0) {
				$pesan_form = '<p class="text-danger">Username telah digunakan!</p>';
				goto output;	
			}
			// Akhir cek email dan username

			$password = password_hash($password, PASSWORD_DEFAULT);
			$tambah = $this->query("INSERT INTO data_users(nama_depan, nama_belakang, username, email, password) VALUES ('$nama_depan', '$nama_belakang', '$username', '$email', '$password')");
			if(!$tambah){
				$pesan_form = '<p class="text-danger">Anda gagal mendaftar!</p>';
			} else {
				$pesan_form = '<p class="text-success">Anda berhasil mendaftar, silahkan lakukan login!</p>';
			}

		}

		output:
		return $pesan_form;
    }
}
?>