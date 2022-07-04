<?php
require_once 'Mysql.php';

class Klasemen_Controller extends Mysql {

    function __construct() {
    	$this->dbConnect();
    }
  
    function list(){
    	$data = [];

    	$klasemen = $this->query("SELECT * FROM data_klasemen ORDER BY (3*menang+seri) DESC, (goal-kebobolan) DESC");
    	while ($key = mysqli_fetch_array($klasemen)) {

    		$performa = [];
    		foreach (explode(',', $key['performa']) as $val) {
    			if ($val == 1) {
	    			$status = 'M';
    			} else if ($val == 2) {
    				$status = 'I';
    			} else {
    				$status = 'K';
    			}
    		    $performa[] = $status;
    		}

    		$score_team = [];
    		foreach (explode('|', $key['score']) as $val) {
    		    $score_team[] = explode('-', $val)[0];
    		}

    		$score_lawan = [];
    		foreach (explode('|', $key['score']) as $val) {
    		    $score_lawan[] = explode('-', $val)[1];
    		}

    		$data[] = [
    			'id' => $key['id'],
    			'nama_team' => $key['nama_team'],
    			'logo_team' => $key['logo_team'],
    			'main' => $key['main'],
    			'menang' => $key['menang'],
    			'seri' => $key['seri'],
    			'kalah' => $key['kalah'],
    			'goal' => $key['goal'],
    			'kebobolan' => $key['kebobolan'],
    			'selisih' => $key['goal'] - $key['kebobolan'],
    			'poin' => (3*$key['menang']+$key['seri']),
    			'performa' => $performa,
    			'score_team' => $score_team,
    			'score_lawan' => $score_lawan
    		];
    	}

		output:
		return $data;
    }

    function tambah($params){
    	$pesan_form = '';

    	$score_team = (isset($params['score_team'])) ? $params['score_team'] : [];
    	$score_lawan = (isset($params['score_lawan'])) ? $params['score_lawan'] : [];

    	$score_final = '';
    	$count = 1;
    	$goal = 0;
    	$kebobolan = 0;
    	foreach ($score_team as $key => $val) {
    		if ($val < 0) {
    			$pesan_form = '<p class="text-danger">Score tidak boleh kurang dari 0!</p>';
				goto output;
    		}
    		if ($score_lawan[$key] < 0) {
    			$pesan_form = '<p class="text-danger">Score tidak boleh kurang dari 0!</p>';
				goto output;
    		}

    		if ($count < count($score_team)) {
	    		$score_final .= $val.'-'.$score_lawan[$key].'|';
    		} else {
	    		$score_final .= $val.'-'.$score_lawan[$key];
    		}
    		$goal += $val;
    		$kebobolan += $score_lawan[$key];
    		$count++;
    	}

		$nama = $params['nama'];
		$logo = $params['logo'];
		$main = $params['main'];
		$performa = (isset($params['performa'])) ? $params['performa'] : [];

		$seluruh_performa = implode(',', $performa);
		$menang = count(array_keys($performa, 1));
		$seri = count(array_keys($performa, 2));
		$kalah = count(array_keys($performa, 3));

		if (empty($nama) || empty($main) || empty($goal) || empty($kebobolan) || empty($logo['name'])) {
			$pesan_form = '<p class="text-danger">Mohon isi seluruh data!</p>';
		} else{

			if ($main <= 0) {
				$pesan_form = '<p class="text-danger">Main tidak boleh 0 atau kurang!</p>';
				goto output;
			}

			$file_tmp = $logo['tmp_name'];
			$logo_img = $logo['name'];
			$x = explode('.', $logo_img);
			$ekstensi = strtolower(end($x));
			$nama_logo = uniqid().'.'.$ekstensi;

			$tambah = $this->query("INSERT INTO data_klasemen(nama_team, logo_team, main, menang, seri, kalah, goal, kebobolan, performa, score) VALUES ('$nama', '$nama_logo', '$main', '$menang', '$seri', '$kalah', '$goal', '$kebobolan', '$seluruh_performa', '$score_final')");
			if(!$tambah){
				$pesan_form = '<p class="text-danger">Gagal menambahkan klasemen!</p>';
			} else {
				move_uploaded_file($file_tmp, './assets/img/'.$nama_logo);
				$pesan_form = '<p class="text-success">Berhasil menambahkan klasemen!</p>';
			}

		}

		output:
		return $pesan_form;
    }

    function edit($params, $id){
    	$pesan_form = '';

    	$score_team = (isset($params['score_team'])) ? $params['score_team'] : [];
    	$score_lawan = (isset($params['score_lawan'])) ? $params['score_lawan'] : [];

    	$score_final = '';
    	$count = 1;
		$goal =  0;
		$kebobolan = 0;
    	foreach ($score_team as $key => $val) {
    		if ($val < 0) {
    			$pesan_form = '<p class="text-danger">Score tidak boleh kurang dari 0!</p>';
				goto output;
    		}
    		if ($score_lawan[$key] < 0) {
    			$pesan_form = '<p class="text-danger">Score tidak boleh kurang dari 0!</p>';
				goto output;
    		}

    		if ($count < count($score_team)) {
	    		$score_final .= $val.'-'.$score_lawan[$key].'|';
    		} else {
	    		$score_final .= $val.'-'.$score_lawan[$key];
    		}
    		$goal += $val;
    		$kebobolan += $score_lawan[$key];
    		$count++;
    	}

		$nama = $params['nama'];
		$logo = $params['logo'];
		$main = $params['main'];
		$performa = (isset($params['performa'])) ? $params['performa'] : [];

		$seluruh_performa = implode(',', $performa);
		$menang = count(array_keys($performa, 1));
		$seri = count(array_keys($performa, 2));
		$kalah = count(array_keys($performa, 3));

		if (empty($nama) || empty($main) || empty($goal) || empty($kebobolan)) {
			$pesan_form = '<p class="text-danger">Mohon isi seluruh data!</p>';
		} else{

			if ($main <= 0) {
				$pesan_form = '<p class="text-danger">Main tidak boleh 0 atau kurang!</p>';
				goto output;
			}

			$edit = $this->query("UPDATE data_klasemen SET nama_team = '$nama', main = '$main', menang = '$menang', seri = '$seri', kalah = '$kalah', goal = '$goal', kebobolan = '$kebobolan', performa = '$seluruh_performa', score = '$score_final' WHERE id = '$id'");
			if(!$edit){
				$pesan_form = '<p class="text-danger">klasemen gagal diperbarui!</p>';
			} else {

				if (!empty($logo['name'])) {
					$logo_lama = mysqli_fetch_assoc($this->query("SELECT * FROM data_klasemen WHERE id = '$id'"))['logo_team'];

					$file_tmp = $logo['tmp_name'];
					$logo_img = $logo['name'];
					$x = explode('.', $logo_img);
					$ekstensi = strtolower(end($x));
					$nama_logo = uniqid().'.'.$ekstensi;

					$edit_logo = $this->query("UPDATE data_klasemen SET logo_team = '$nama_logo' WHERE id = '$id'");
					if ($edit_logo) {
						unlink('assets/img/'.$logo_lama);
						move_uploaded_file($file_tmp, './assets/img/'.$nama_logo);
					}
				}

				$pesan_form = '<p class="text-success">Klasemen berhasil diperbarui!</p>';
			}

		}

		output:
		return $pesan_form;
    }

    function hapus($id) {
		$cek = $this->query("SELECT * FROM data_klasemen WHERE id = '$id'");
		if (mysqli_num_rows($cek) <= 0) {
			header("location:klasemen.php");
		}
		$cek = mysqli_fetch_assoc($cek);

		$pesan_form = '';
    	$hapus = $this->query("DELETE FROM data_klasemen WHERE id = '$id'");
		if($hapus){
			unlink('assets/img/'.$cek['logo_team']);
			$pesan_form = '<p class="text-success">Klasemen berhasil dihapus!</p>';
		}


		return $pesan_form;
    }

    function detail($id) {
    	$detail = $this->query("SELECT * FROM data_klasemen WHERE id = '$id'");
		if (mysqli_num_rows($detail) > 0) {
			$detail = mysqli_fetch_assoc($detail);


    		$score_team = [];
    		foreach (explode('|', $detail['score']) as $val) {
    		    $score_team[] = explode('-', $val)[0];
    		}

    		$score_lawan = [];
    		foreach (explode('|', $detail['score']) as $val) {
    		    $score_lawan[] = explode('-', $val)[1];
    		}

			$data = [
				'id' => $detail['id'],
    			'nama_team' => $detail['nama_team'],
    			'logo_team' => $detail['logo_team'],
    			'main' => $detail['main'],
    			'menang' => $detail['menang'],
    			'seri' => $detail['seri'],
    			'kalah' => $detail['kalah'],
    			'goal' => $detail['goal'],
    			'kebobolan' => $detail['kebobolan'],
    			'performa' => $detail['performa'],
    			'score_team' => $score_team,
    			'score_lawan' => $score_lawan
			];
		} else {
			header("location:klasemen.php");
		}

		return $data;
    }
}
?>
