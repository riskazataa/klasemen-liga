<?php
include './controller/Klasemen_Controller.php';

$menu_input_barang = '
	<li class="nav-item">
	    <a class="nav-link" href="login.php">Login</a>
  	</li>';
session_start();
if (isset($_SESSION['id'])) {
	$menu_input_barang = '
	<li class="nav-item">
		<a class="nav-link" href="klasemen.php">Input Klasemen</a>
	</li>
	<li class="nav-item">
	    <a class="nav-link" href="logout.php">Logout</a>
  	</li>';
}

$klasemen = new Klasemen_Controller();
$klasemen = $klasemen->list();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Klasemen Live</title>
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
		    		<?php echo $menu_input_barang ?>
		    	</ul>
		  	</div>
        </div>
      </nav>
    </header>

    <div class="container-fluid mt-3">
    	<table class="table align-middle mb-0 bg-">
		  	<thead class="bg-light">
		    	<tr>
		      		<th width="5%">Pos</th>
		      		<th width="28%">Tim</th>
		      		<th width="5%">PD</th>
		      		<th width="5%">M</th>
		      		<th width="5%">S</th>
		      		<th width="5%">K</th>
		      		<th width="5%">GM</th>
		      		<th width="5%">GK</th>
		      		<th width="7%">SG (+/-)</th>
		      		<th width="5%">P</th>
		      		<th width="25%">Performa</th>
		    	</tr>
		  	</thead>
		  	<tbody>
	  		<?php
	  		$no = 1;
	  		foreach ($klasemen as $key) {
	  		?>
		    	<tr>
		    		<td><?php echo $no++ ?></td>
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
			      	<td><?= $key['selisih'] ?></td>
			      	<td><?= $key['poin'] ?></td>
			      	<td>
			      		<?php foreach ($key['performa'] as $key2 => $val) {
			      		    if ($val == 'M') {
			      		    	echo '<button class="btn btn-score btn-small btn-dark" data-bs-toggle="modal" data-bs-target="#scoreModal" data-score-team="'.$key['score_team'][$key2].'" data-score-lawan="'.$key['score_lawan'][$key2].'">Score</button> <button style="width: 40px; height: 40px" class="mb-1 btn btn-small btn-success">M</button> ';
			      		    } else if ($val == 'I') {
			      		    	echo '<button class="btn btn-score btn-small btn-dark" data-bs-toggle="modal" data-bs-target="#scoreModal" data-score-team="'.$key['score_team'][$key2].'" data-score-lawan="'.$key['score_lawan'][$key2].'">Score</button> <button style="width: 40px; height: 40px" class="mb-1 btn btn-small btn-secondary">I</button> ';
			      		    } else {
			      		    	echo '<button class="btn btn-score btn-small btn-dark" data-bs-toggle="modal" data-bs-target="#scoreModal" data-score-team="'.$key['score_team'][$key2].'" data-score-lawan="'.$key['score_lawan'][$key2].'">Score</button> <button style="width: 40px; height: 40px" class="mb-1 btn btn-small btn-danger">K</button> ';
			      		    }
			      		} ?>
			      	</td>
		    	</tr>
		    <?php } ?>
		  	</tbody>
		</table>
    </div>

	<div class="container-fluid mt-3 mb-3 bg-white">

	    	
				
	    			<h2 class="card-title">Keterangan Tabel:</h2>
	    			<p class="card-text">Pos = Ranking </p>
					<p class="card-text">PD = Pertandingan yang telah dimainkan</p>
					<p class="card-text">M = Menang</p>
					<p class="card-text">S = Seri </p>
					<p class="card-text">K = Kalah</p>
					<p class="card-text">GM = Gol Memasukan (gol kegawang lawan) </p>
					<p class="card-text">GK = Gol Kemasukan </p>
					<p class="card-text">SG = Selisih Gol</p>
					<p class="card-text">P = Poin</p>
	    		</div>
	    	</div>
    	</div>
    </div>


    <div class="modal fade" id="scoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content bg-secondary text-white p-3">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Score Pertandingan</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-md-12 bg-success p-2">
			      	<p>Score Team: <span class="score-team">0</span></p>
	      		</div>
	      		<div class="col-md-12 bg-warning p-2">
			      	<p>Score Lawan: <span class="score-lawan">0</span></p>
	      		</div>
	      	</div>
	      </div>
	    </div>
	  </div>
	</div>


	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
	<script>
		$('.btn-score').click(function (e) {
			e.preventDefault()
			$('.score-team').text($(this).data('score-team'));
			$('.score-lawan').text($(this).data('score-lawan'));
		})

	</script>
</body>
</html>