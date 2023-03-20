<?php
// include __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../bootstrap.php";
session_start();


use CT466\Project\MonAn;
use CT466\Project\chitiet;

$monan = new MonAn($PDO);

$chitiet = new chitiet($PDO);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// echo '<pre>';
	// print_r($_POST);
	$id_mon = $_POST['id'];
	$id_menu = $_POST['idmenu'];

	if (isset($_SESSION['id_dv'])) {
		$id_dv =$_SESSION['id_dv'];

		$kq = $chitiet->find2($id_dv, $id_menu, $id_mon);
		$findmenu = $chitiet->findMenu($id_menu);

		echo $chitiet->getId();
		$id = $chitiet->getId();
		// }
		if (($kq)) {
			// echo "Món này đã có trong menu!!!";
			echo '<script>alert("Món này đã có trong menu của bạn. Vui lòng chọn món khác!!! "); javascript:history.go(-1)</script>';
		} else {
			// echo "thêm thành công";
			{
				$array1 = [];
				$array1['id_dv'] = $_SESSION['id_dv'];
				$array1['id_menu'] = $id_menu;
				$array1['id_mon'] = $id_mon;
				$chitiet->insert_menu($array1);
				echo '<script>alert("Thêm món vào menu thành công."); javascript:history.go(-1)</script>';
				// echo "<pre>";
				// print_r($array1);

			}
		}
	}
}
