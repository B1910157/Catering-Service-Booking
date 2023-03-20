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
			<li class="nav-item">
				<a class="nav-link" href="QuanLyMenu.php">Quản Lý Menu</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="QuanLyMonAn.php">Quản Lý Món Ăn</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="dv.php">Quản Lý Tài Khoản</a>
			</li>
		</ul>
		<!-- <div class="text-right row">
			<form method="POST" action="search.php" class="form-inline ">
				<input style="width: 300px;" class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm..." name="tukhoa" aria-label="Search">
				<button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="timkiem"><i class="fa fa-search"></i></button>
			</form>
		</div> -->
		<ul class="nav navbar-nav ml-5">
			<!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
		</ul>
		<?php

		use CT466\Project\User;
		use CT466\Project\dichvu;
		$dichvu = new dichvu($PDO);

		$user = new User($PDO);
		if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
			unset($_SESSION['id_dv']);
			// echo '<script>alert("Đăng xuất thành công.");</script>';
			echo '<script>window.location.href= "../index.php";</script>';
		}
		if (isset($_SESSION['id_dv'])) {
			$username = $_SESSION['id_dv'];
			$userData = $dichvu->find($username);
		?>

			<ul class="navbar-nav">

				<li class="nav-item">
					
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