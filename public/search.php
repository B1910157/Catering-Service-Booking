<?php
include "../bootstrap.php";
session_start();
use CT466\Project\User;

$user = new User($PDO);

use CT466\Project\LoaiMon;
use CT466\Project\MonAn;
use CT466\Project\loaitiec;
use CT466\Project\dichvu;
use CT466\Project\Menu;


$monan = new MonAn($PDO);
$loaimon = new LoaiMon($PDO);
$loaitiec = new loaitiec($PDO);
$menu = new Menu($PDO);
$dichvu = new dichvu($PDO);

$menus = $menu->allmenu();
$monans = $monan->all();

$dichvus = $dichvu->allDuyet();
$loaimons = $loaimon->all();
$loaitiecs = $loaitiec->all();

$id_loaitiec = isset($_REQUEST['id_loaitiec']) ?
	filter_var($_REQUEST['id_loaitiec'], FILTER_SANITIZE_NUMBER_INT) : -1;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiệc Lưu Động</title>
	<!-- 
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
	<link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
	<link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
	<link href="<?= BASE_URL_PATH . "css/style.css" ?>" rel=" stylesheet">
</head>

<body>
	<!-- Main Page Content -->
	<div class="container">
		<?php include('../partials/navbar.php');
		?>
		<section id="inner" class="inner-section section">
			<h2 class="title">Nội dung tìm kiếm</h2>
			Từ Khóa: <?php 
			if(isset($_POST['tukhoa'])){
				echo $_POST['tukhoa'];
				$tukhoa =  $_POST['tukhoa'];
			}else{
				$tukhoa = '';
			}
			
						?>
			<?php
			$dichvus = $dichvu->search($tukhoa);
			?>
			<div class="col-md-12 card-container">
				<?php foreach ($dichvus as $dichvu) :
					$dichvuID = $dichvu->getId();
				?>
					<div class="card-item">
						<a href="">
							<img style="width: 250px; height: 200px;" src="img/upload/<?= htmlspecialchars($dichvu->image) ?>">
						</a>

						<div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($dichvu->ten_dv) ?></div>
						<div class="text-uppercase p-3 font-weight-bold"> SDT: <?= htmlspecialchars($dichvu->sdt) ?> </div>
						<div class="text-uppercase p-3 font-weight-bold"> Tỉnh: <?= htmlspecialchars($dichvu->dv_tinh) ?> </div>


						<hr>
						<div class="card-footer">
							<a class="btn btn-primary" href="create_Menu.php?id_dv=<?php echo $dichvuID; ?>">Chọn Dịch Vụ</a>

						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php include('../partials/footer.php'); ?>
	</div>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
	<script>
		$(document).ready(function() {
			new WOW().init();
		});
	</script>
</body>

</html>