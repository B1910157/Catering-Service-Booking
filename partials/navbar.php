<?php
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="index.php">
		<img src="img/bgn.jpg" alt="" style="width:100px;">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Trang chủ </a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">
					Dịch Vụ
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="showDV.php">Tất cả dịch vụ</a>
					<div class="dropdown-divider"></div>
					<?php foreach ($dichvus as $dichvu) :
						$dichvuID = $dichvu->getId(); ?>
						<a class="dropdown-item" href="create_Menu.php?id_dv=<?php echo $dichvuID; ?>">
							<?php htmlspecialchars($dichvu->getId());
							echo htmlspecialchars($dichvu->ten_dv) ?>
						</a>
					<?php endforeach; ?>

				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="lienhe.php">Liên Hệ</a>
			</li>
		</ul>
		<div class="text-right row">
			<form method="POST" action="search.php" class="form-inline ">
				<input style="width: 300px;" class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." name="tukhoa" aria-label="Search">
				<button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="timkiem"><i class="fa fa-search"></i></button>
			</form>

			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					
					<a class="nav-link dropdown-toggle " id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">
					</a>
					
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						
						<a href="thongtincanhan.php" class="">Thông tin cá nhân</a>
						<div class="dropdown-divider"></div>
						<a href="lichSu.php" class="">Lịch sử</a>
					</div>
				</li>
			</ul>




		</div>
		<ul class="nav navbar-nav ml-5">
			<!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
		</ul>
		<?php

		use CT466\Project\User;

		$user = new User($PDO);
		if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
			unset($_SESSION['id_user']);
			// echo '<script>alert("Đăng xuất thành công.");</script>';
			echo '<script>window.location.href= "index.php";</script>';
		}
		if (isset($_SESSION['id_user'])) {
			$username = $_SESSION['id_user'];
			$userData = $user->find($username);
		?>

			<ul class="navbar-nav">

				<li class="nav-item">
					<i style="color: red;"><?php echo "Xin chào, " . $userData->username; ?></i>
					<a class="nav-link" href="index.php?dangxuat=1" onclick="return confirm('Xác nhận đăng xuất?')">Đăng xuất</a>
				</li>
			</ul>

		<?php
		} else {
		?>

			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="indexRes.php">Đăng ký </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="indexLogin.php">Đăng nhập</a>
				</li>
			</ul>
		<?php
		}
		?>



	</div>
</nav>