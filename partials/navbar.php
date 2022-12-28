<?php
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="index.php">
		<img src="img/logo1.png" alt="" style="width:100px;">
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
				<a class="nav-link dropdown-toggle" href="product.php">
					Sản phẩm
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="product.php">Tất cả sản phẩm</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="">
						Tiệc cưới
					</a>
					<a class="dropdown-item" href="">
						Tiệc Sinh nhật
					</a>
					<a class="dropdown-item" href="">
						Tiệc Tân Gia
					</a>
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
			<button class="btn btn-outline-primary my-2 my-sm-0 ml-2" onclick="openCart();"><i class="fa fa-shopping-bag"></i></button>
			<script type="text/javascript">
				function openCart() {
					window.location.href = "cart.php";
				}
			</script>
		</div>
		<ul class="nav navbar-nav ml-5">
			<!-- &nbsp;&nbsp;&nbsp;&nbsp; -->
		</ul>
		<?php

		use CT466\Project\User;

		$user = new User($PDO);
		if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
			unset($_SESSION['id_user']);
		}
		if (isset($_SESSION['id_user'])) {
			$username = $_SESSION['id_user'];
			$userData = $user->find($username);
		?>

			<ul class="navbar-nav">

				<li class="nav-item">
					<i style="color: red;"><?php echo "Xin chào, " . $userData->fullname; ?></i>
					<a class="nav-link" href="index.php?dangxuat=1">Đăng xuất</a>
				</li>
			</ul>

		<?php
		} else {
		?>

			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="register.php">Đăng ký </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login.php">Đăng nhập</a>
				</li>
			</ul>
		<?php
		}
		?>



	</div>
</nav>