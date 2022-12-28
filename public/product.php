<?php
include "../bootstrap.php";
session_start();
use CT275\Project\Product;
use CT275\Project\Category;
$product = new Product($PDO);
$category = new Category($PDO);
use CT275\Project\User;
$user = new User($PDO);
$products = $product->all();
$categorys = $category->all();
if (isset($_SESSION["id_user"])) {
	$user->find($_SESSION["id_user"]);
}

$id_cat = isset($_REQUEST['category_id']) ?
    filter_var($_REQUEST['category_id'], FILTER_SANITIZE_NUMBER_INT) : -1;
// if ($id_cat < 0 || !($category->find($id_cat))) {
//     redirect(BASE_URL_PATH);
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop Máy Ảnh</title>
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
            <!-- SECTION HEADING -->
            <hr>
            <h2 class="section-heading text-center wow fadeIn title" data-wow-duration="1s">SẢN PHẨM</h2>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="wow fadeIn note" data-wow-duration="2s">Đảm bảo chất lượng <i class="fa fa-check" aria-hidden="true"></i></p>
                </div>
            </div>
            <hr>
            <div class="inner-wrapper row">
                <div class="list-group m-3 col-md-2">
                    <p class="list-group-item bg-primary">DANH MỤC</p>
                    <?php foreach ($categorys as $category) :
						$categoryID = $category->getId(); ?>
						<a class="list-group-item list-group-item-action" href="product.php?category_id=<?php echo $categoryID; ?>">
							<?php htmlspecialchars($category->getId());
							echo htmlspecialchars($category->category_name) ?>
						</a>
					<?php endforeach; ?>
                </div>
                <div class="col-md-9 card-container">
                <?php foreach ($products as $product) :
                        if (isset($_GET['category_id']) && $product->category_id == $_GET['category_id']) {
                            
                        
						$productID = $product->getId();
						?>
						<div class="card-item">
							<a href="detail.php?id=<?php echo $productID; ?>">
								<img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($product->image) ?>">
							</a>

							<div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($product->name) ?></div>
							<div class="p-3 font-weight-bold"><?php $ct =  $category->find($product->category_id); echo $ct->category_name;?></div>
							<div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($product->price, 0, '', '.'); ?> VNĐ</i></div>
							<hr>
							<div class="card-footer">
								<a class="btn btn-primary" href="detail.php?id=<?php echo $productID; ?>">Xem chi tiết</a>

							</div>
						</div>
					<?php } elseif(!isset($_GET['category_id'])) { 
                        $productID = $product->getId();
						?>
						<div class="card-item">
							<a href="detail.php?id=<?php echo $productID; ?>">
								<img class="w-100" style="height: 200px;" src="img/upload/<?= htmlspecialchars($product->image) ?>">
							</a>

							<div class="text-uppercase p-3 font-weight-bold"><?= htmlspecialchars($product->name) ?></div>
							<div class="p-3 font-weight-bold"><?php $ct =  $category->find($product->category_id); echo $ct->category_name;?></div>
							<div><b>Giá:</b> <i class="text-danger"> <?php echo number_format($product->price, 0, '', '.'); ?> VNĐ</i></div>
							<hr>
							<div class="card-footer">
								<a class="btn btn-primary" href="detail.php?id=<?php echo $productID; ?>">Xem chi tiết</a>

							</div>
						</div>  
                    <?php }
                 endforeach; ?>
                </div>
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