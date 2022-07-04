<?php
include './controller/Klasemen_Controller.php';

session_start();
if (!isset($_SESSION['id'])) {
	header("location:index.php");
}

$klasemen = new Klasemen_Controller();

$pesan_form = '';
if(isset($_POST['tambahkan']))
{
	$pesan_form = $klasemen->tambah(array_merge($_POST, $_FILES));
}

$submit_form = '<button type="submit" class="btn btn-success" name="tambahkan">Simpan</button>';

$nama = (isset($_POST['nama'])) ? $_POST['nama'] : '';
$main = (isset($_POST['main'])) ? $_POST['main'] : '';
$logo = '';
$tampil_main = '';

if(isset($_GET['hal']))
{
	if ($_GET['hal'] == "hapus")
	{
		$pesan_form = $klasemen->hapus($_GET['id']);
	} else if ($_GET['hal'] == "edit") {

		$submit_form = '<button type="submit" class="btn btn-success" name="update">Edit</button>';

		if (isset($_POST['update'])) {
			$pesan_form = $klasemen->edit(array_merge($_POST, $_FILES), $_GET['id']);
		}

		$detail_klasemen = $klasemen->detail($_GET['id']);
		$nama = $detail_klasemen['nama_team'];
		$main = $detail_klasemen['main'];

		$logo = '<br><img src="./assets/img/'.$detail_klasemen['logo_team'].'" class="mb-2 mt-2" style="width: 100px; height: 100px">';

		$i = 1;
		foreach (explode(',', $detail_klasemen['performa']) as $key => $val) {
			$tampil_main .= '
			<div class="form-group mb-2">
				<label>Permainan '.$i.'</label>
				<select name="performa[]" class="w-100">
					<option value="1" '.(($val == 1)?'selected':'').'>Menang</option>
					<option value="2" '.(($val == 2)?'selected':'').'>Seri</option>
					<option value="3" '.(($val == 3)?'selected':'').'>Kalah</option>
				</select>
			</div>

			<div class="row col-md-12 align-center mb-4">
				<div class="form-group mb-2 col-md-6">
					<label>Score Team</label>
					<input type="number" name="score_team[]" value="'.$detail_klasemen['score_team'][$key].'" class="form-control" required>
				</div>
				<div class="form-group mb-2 col-md-6">
					<label>Score Lawan</label>
					<input type="number" name="score_lawan[]" value="'.$detail_klasemen['score_lawan'][$key].'" class="form-control" required>
				</div>
			</div>
			';
			$i++;
		}

	}
}

?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Kelola Klasemen</title>
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap/bootstrap.min.css">
	</head>
	<body>

		<header>
	      <nav class="navbar navbar-expand-lg navbar-dark bg-secondary box-shadow">
	        <div class="container d-flex justify-content-between">
	          	<a href="index.php" class="navbar-brand d-flex align-items-center">
	            	<strong>KLASEMEN LIVE</strong>
	          	</a>
	          	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		      		<span class="navbar-toggler-icon"></span>
		    	</button>
			  	<div class="collapse navbar-collapse" id="navbarNav">
			    	<ul class="navbar-nav ms-auto align-items-center">
			    		<li class="nav-item">
							<a class="nav-link" href="klasemen.php">Input Klasemen</a>
						</li>
						<li class="nav-item">
						    <a class="nav-link" href="logout.php">Logout</a>
					  	</li>
			    	</ul>
			  	</div>
	        </div>
	      </nav>
	    </header>

		<div class="container mt-3">

			<h1 class="text-center">Kelola Klasemen</h1>

			<!-- Awal Card Form -->
			<div class="card mt-3">
				<div class="card-header bg-dark text-white">
					Form Klasemen
				</div>
				<div class="card-body">
					<?php echo $pesan_form ?>
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group mb-2">
							<label>Nama Team</label>
							<input type="text" name="nama" value="<?php echo $nama ?>" autocomplete="off" class="form-control" placeholder="Nama Team" required>
						</div>
						<div class="form-group mb-2">
							<label>Logo Team</label>
							<?php echo $logo ?>
							<input type="file" name="logo" value="" class="form-control">
						</div>
						<div class="form-group mb-2">
							<label>Main</label>
							<input type="number" name="main" value="<?php echo $main ?>" class="form-control main" placeholder="Jumlah Main" required>
						</div>
						<div class="tampil-main">
							<?php echo $tampil_main ?>
						</div>
						<?php echo $submit_form ?>
						<a href="klasemen.php" class="btn btn-danger" name="breset">Kosongkan</a>
					</form>
				</div>
			</div>
			<!-- Akhir Card Form -->

			<!-- Awal Card Tabel -->
			<div class="card mt-3">
				<div class="card-header bg-dark text-white">
					List Klasemen
				</div>
				<div class="card-body">

					<table class="table table-bordered table-striped">
						<tr>
							<th>Team</th>
							<th>Main</th>
							<th>Menang</th>
							<th>Seri</th>
							<th>Kalah</th>
							<th>Goal</th>
							<th>Kebobolan</th>
							<th>Aksi</th>
						</tr>
						<?php
				  		foreach ($klasemen->list() as $key) {
				  		?>
					    	<tr>
						      	<td>
						        	<div class="d-flex align-items-center">
						          	<img
						            	  src="./assets/img/<?= $key['logo_team'] ?>"
						              	alt=""
						              	style="width: 45px; height: 45px"
						              	class="rounded-circle"
						              	/>
						          	<div class="ms-3">
							            <p class="fw-bold mb-1"><?= $key['nama_team'] ?></p>
							          </div>
						    	    </div>
						      	</td>
						      	<td><?= $key['main'] ?></td>
						      	<td><?= $key['menang'] ?></td>
						      	<td><?= $key['seri'] ?></td>
						      	<td><?= $key['kalah'] ?></td>
						      	<td><?= $key['goal'] ?></td>
						      	<td><?= $key['kebobolan'] ?></td>
						      	<td>
						      		<a href="?hal=edit&id=<?=$key['id']?>" onclick="return confirm('Apakah yakin ingin mengubah data ini?')" class="btn btn-primary"> Edit </a>
						      		<a href="?hal=hapus&id=<?=$key['id']?>"  onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
						      	</td>
					    	</tr>
					    <?php } ?>
					</table>
				</div>
			</div>
			<!-- Akhir Card Tabel -->

		</div>

		<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
		<script>
			$("input.main").blur(function(e){
				let jml = (e.target.value == "") ? 0 : e.target.value;

				let isi = '';
				if (jml > 0) {
					for (var i = 1; i <= jml; i++) {
						isi += `
						<div class="form-group mb-2">
							<label>Permainan ${i}</label>
							<select name="performa[]" class="w-100">
								<option value="1">Menang</option>
								<option value="2">Seri</option>
								<option value="3">Kalah</option>
							</select>
						</div>

						<div class="row col-md-12 align-center mb-4">
							<div class="form-group mb-2 col-md-6">
								<label>Score Team</label>
								<input type="number" name="score_team[]" class="form-control" required>
							</div>
							<div class="form-group mb-2 col-md-6">
								<label>Score Lawan</label>
								<input type="number" name="score_lawan[]" class="form-control" required>
							</div>
						</div>
						`
					}
				}
				$(".tampil-main").html(isi);
			}); 
		</script>
	</body>
	</html>