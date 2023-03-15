<?php

namespace CT466\Project;

class dattiec
{
	private $db;

	private $id_dattiec = -1;
	public $id_dv;
	public $id_loaitiec;
	public $id_user;
	public $id_menu;
	public $soluongban;
	public $giodat;
	public $ngaydat;
	public $giamenu;
	public $tongtien;
	public $diachitiec;
	public $phuong;
	public $quan;
	public $tinh;
	public $trangthai;
	public $ngaythuchien;
	// public $gia_menu;

	private $errors = [];

	public function getId()
	{
		return $this->id_dattiec;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['id_dv'])) {
			$this->id_dv = trim($data['id_dv']);
		}
		if (isset($data['id_loaitiec'])) {
			$this->id_loaitiec = trim($data['id_loaitiec']);
		}
		if (isset($data['id_user'])) {
			$this->id_user = trim($data['id_user']);
		}
		if (isset($data['id_menu'])) {
			$this->id_menu = trim($data['id_menu']);
		}
		if (isset($data['soluongban'])) {
			$this->soluongban = trim($data['soluongban']);
		}
		if (isset($data['giodat'])) {
			$this->giodat = trim($data['giodat']);
		}
		if (isset($data['ngaydat'])) {
			$this->ngaydat = trim($data['ngaydat']);
		}
		if (isset($data['giamenu'])) {
			$this->giamenu = trim($data['giamenu']);
		}
		if (isset($data['tongtien'])) {
			$this->tongtien = trim($data['tongtien']);
		}
		if (isset($data['diachitiec'])) {
			$this->diachitiec = trim($data['diachitiec']);
		}
		if (isset($data['phuong'])) {
			$this->phuong = trim($data['phuong']);
		}
		if (isset($data['quan'])) {
			$this->quan = trim($data['quan']);
		}
		if (isset($data['tinh'])) {
			$this->tinh = trim($data['tinh']);
		}
		if (isset($data['trangthai'])) {
			$this->trangthai = trim($data['trangthai']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->id_dv) {
			$this->errors['id_dv'] = 'id loại tiệc không hợp lệ.';
		}

		if (!$this->id_loaitiec) {
			$this->errors['id_loaitiec'] = 'id loại tiệc không hợp lệ.';
		}

		if (!$this->id_user) {
			$this->errors['id_user'] = 'id user không hợp lệ.';
		}
		if (!$this->id_menu) {
			$this->errors['id_menu'] = 'id menu không hợp lệ.';
		}
		if (!$this->soluongban) {
			$this->errors['soluongban'] = 'Chỉ phục vụ trên 10 bàn.';
		}
		if (!$this->giodat) {
			$this->errors['giodat'] = 'Giờ đặt không hợp lệ.';
		}
		if (!$this->ngaydat) {
			$this->errors['ngaydat'] = 'Ngày đặt không hợp lệ.';
		}
		if (!$this->giamenu < 0) {
			$this->errors['giamenu'] = 'giá menu không hợp lệ.';
		}
		if (!$this->tongtien < 0) {
			$this->errors['tongtien'] = 'tổng tiền không hợp lệ.';
		}
		if (!$this->diachitiec) {
			$this->errors['diachitiec'] = 'dia chi tiec không hợp lệ.';
		}
		if (!$this->phuong) {
			$this->errors['phuong'] = 'Phuong/Xa không hợp lệ.';
		}
		if (!$this->quan) {
			$this->errors['quan'] = 'Quan/Huyen không hợp lệ.';
		}
		if (!$this->tinh) {
			$this->errors['tinh'] = 'Tinh/Thanh Pho không hợp lệ.';
		}

		if (!$this->trangthai < 0) {
			$this->errors['trangthai'] = 'trang thái không hợp lệ.';
		}

		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
			'id_dattiec' => $this->id_dattiec,
			'id_dv' => $this->id_dv,
			'id_loaitiec' => $this->id_loaitiec,
			'id_user' => $this->id_user,
			'id_menu' => $this->id_menu,
			'soluongban' => $this->soluongban,
			'giodat' => $this->giodat,
			'ngaydat' => $this->ngaydat,
			'giamenu' => $this->giamenu,
			'tongtien' => $this->tongtien,
			'diachitiec' => $this->diachitiec,
			'phuong' => $this->phuong,
			'quan' => $this->quan,
			'tinh' => $this->tinh,
			'trangthai' => $this->trangthai,
			'ngaythuchien' => $this->ngaythuchien

		] = $row;
		return $this;
	}


	//tim don dat hang cua 1 user dua tren usser_id
	public function getUser($id_user)
	{
		$dattiecs = [];
		$stmt = $this->db->prepare('select * from dattiec where id_user = :id_user order by ngaythuchien DESC');
		$stmt->execute(['id_user' => $id_user]);
		while ($row = $stmt->fetch()) {
			$dattiec = new dattiec($this->db);
			$dattiec->fillFromDB($row);
			$dattiecs[] = $dattiec;
		}
		return $dattiecs;
	}

	//Hien thi tat ca menu
	public function all()
	{
		$dattiecs = [];
		$stmt = $this->db->prepare('select * from dattiec');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$dattiec = new dattiec($this->db);
			$dattiec->fillFromDB($row);
			$dattiecs[] = $dattiec;
		}
		return $dattiecs;
	}

	
	public function all_DV_ChuaDuyet($id_dv)
	{
		$dattiecs = [];
		$stmt = $this->db->prepare('select * from dattiec where id_dv = :id_dv and trangthai=0');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$dattiec = new dattiec($this->db);
			$dattiec->fillFromDB($row);
			$dattiecs[] = $dattiec;
		}
		return $dattiecs;
	}

	public function all_DV_DaDuyet($id_dv)
	{
		$dattiecs = [];
		$stmt = $this->db->prepare('select * from dattiec where id_dv = :id_dv and trangthai=1');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$dattiec = new dattiec($this->db);
			$dattiec->fillFromDB($row);
			$dattiecs[] = $dattiec;
		}
		return $dattiecs;
	}
	public function all_DV_DaHuy($id_dv)
	{
		$dattiecs = [];
		$stmt = $this->db->prepare('select * from dattiec where id_dv = :id_dv and trangthai=2 or trangthai=3');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$dattiec = new dattiec($this->db);
			$dattiec->fillFromDB($row);
			$dattiecs[] = $dattiec;
		}
		return $dattiecs;
	}

	public function findDV($id_dv)
	{
		$stmt = $this->db->prepare('select * from dattiec m  join dichvu ct on m.id_dv = ct.id_dv where m.id_dv = :id_dv');
		$stmt->execute(['id_dv' => $id_dv]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}








	public function insertDattiec(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert();
		}
		return false;
	}

	public function insert()
	{
	
		$stmt = $this->db->prepare(
			'insert into dattiec (id_dv, id_loaitiec, id_user, id_menu, soluongban, giodat, ngaydat, giamenu, tongtien, diachitiec,phuong, quan, tinh, trangthai, ngaythuchien)
			values (:id_dv, :id_loaitiec, :id_user, :id_menu, :soluongban, :giodat, :ngaydat, :giamenu, :tongtien, :diachitiec, :phuong, :quan, :tinh ,0, now())'
		);
		$dattiec = $stmt->execute([
			'id_dv' => $this->id_dv,
			'id_loaitiec' => $this->id_loaitiec,
			'id_user' => $this->id_user,
			'id_menu' => $this->id_menu,
			'soluongban' => $this->soluongban,
			'giodat' => $this->giodat,
			'ngaydat' => $this->ngaydat,
			'giamenu' => $this->giamenu,
			'tongtien' => $this->tongtien,
			'diachitiec' => $this->diachitiec,
			'phuong' => $this->phuong,
			'quan' => $this->quan,
			'tinh' => $this->tinh

		]);

		if ($dattiec) {
			$this->id_dattiec = $this->db->lastInsertId();
		}
		return $dattiec;
	}


	

	//Hien thi tat ca menu gom ca mon an
	// public function all()
	// {
	// 	$menus = [];
	// 	$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu');
	// 	$stmt->execute();
	// 	while ($row = $stmt->fetch()) {
	// 		$menu = new chitiet($this->db);
	// 		$menu->fillFromDB($row);
	// 		$menus[] = $menu;
	// 	} return $menus;
	// } 
	// public function all1($id_menu)
	// {
	// 	$menus = [];
	// 	$stmt = $this->db->prepare('select * from  menuchitiet where id_menu = :id_menu');
	// 	$stmt->execute([
	// 		'id_menu'=>$id_menu
	// 	]);
	// 	while ($row = $stmt->fetch()) {
	// 		$menu = new chitiet($this->db);
	// 		$menu->fillFromDB($row);
	// 		$menus[] = $menu;
	// 	} return $menus;
	// } 

	//hien thi tung menu theo id 
	// public function showmenu($id_menu)
	// {
	// 	$menus = [];
	// 	$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu');
	// 	$stmt->execute(['id_menu' => $id_menu]);
	// 	while ($row = $stmt->fetch()) {
	// 		$menu = new chitiet($this->db);
	// 		$menu->fillFromDB($row);
	// 		$menus[] = $menu;
	// 	} return $menus;
	// } 

	// public function getMenu($id_mon) {
	// 	$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where ct.id_mon = :id_mon');
	// 	$stmt->execute(['id_mon' => $id_mon]);
	// 	 if ($row = $stmt->fetch()) {
	// 		$this->fillFromDB($row);
	// 		return $this;
	// 	} return null;
	// }





	public function duyet($id_dattiec){
		$stmt = $this->db->prepare('update dattiec set trangthai = 1 where id_dattiec = :id_dattiec');

		$rs = $stmt->execute([
			'id_dattiec'=>$id_dattiec
		]);
	}

	public function huy($id_dattiec){
		$stmt = $this->db->prepare('update dattiec set trangthai = 2 where id_dattiec = :id_dattiec');

		$rs = $stmt->execute([
			'id_dattiec'=>$id_dattiec
		]);
	}
	public function khachHuy($id_dattiec){
		$stmt = $this->db->prepare('update dattiec set trangthai = 3 where id_dattiec = :id_dattiec');

		$rs = $stmt->execute([
			'id_dattiec'=>$id_dattiec
		]);
	}


	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_dattiec >= 0) {
			$stmt = $this->db->prepare('update dattiec set 
			id_dv = :id_dv,
            id_loaitiec = :id_loaitiec,
			id_menu = :id_menu,
			soluongban = :soluongban,
			giodat = :giodat,
			ngaydat = :ngaydat,
			giamenu = :giamenu,
			tongtien = :tongtien,
			diachitiec = :diachitiec,
			phuong = :phuong,
			quan = :quan,
			tinh = :tinh


			where id_dattiec = :id_dattiec');
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
				'id_loaitiec' => $this->id_loaitiec,
				'id_menu' => $this->id_menu,
				'soluongban' => $this->soluongban,
				'giodat' => $this->giodat,
				'ngaydat' => $this->ngaydat,
				'giamenu' => $this->giamenu,
				'tongtien' => $this->tongtien,
				'diachitiec' => $this->diachitiec,
				'phuong' => $this->phuong,
				'quan' => $this->quan,
				'tinh' => $this->tinh,



				'id_dattiec' => $this->id_dattiec
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into dattiec (id_dv, id_loaitiec, id_user, id_menu, soluongban, giodat, ngaydat, giamenu, tongtien, diachitiec,phuong, quan, tinh, trangthai, ngaythuchien)
				values (:id_dv ,:id_loaitiec, :id_user, :id_menu, :soluongban, :giodat, :ngaydat, :giamenu, :tongtien, :diachitiec, :phuong, :quan, :tinh ,0, now())'
			);
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
				'id_loaitiec' => $this->id_loaitiec,
				'id_user' => $this->id_user,
				'id_menu' => $this->id_menu,
				'soluongban' => $this->soluongban,
				'giodat' => $this->giodat,
				'ngaydat' => $this->ngaydat,
				'giamenu' => $this->giamenu,
				'tongtien' => $this->tongtien,
				'diachitiec' => $this->diachitiec,
				'phuong' => $this->phuong,
				'quan' => $this->quan,
				'tinh' => $this->tinh


			]);
			if ($result) {
				$this->id_dattiec = $this->db->lastInsertId();
			}
		}
		return $result;
	}

	//tim menu
	public function findMenu($id_menu)
	{
		$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu');
		$stmt->execute(['id_menu' => $id_menu]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function findMon($id_mon)
	{
		$stmt = $this->db->prepare('select * from menuchitiet where id_mon = :id_mon');
		$stmt->execute(['id_mon' => $id_mon]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	//tim menu va mon trong menu
	public function find2($id_menu, $id_mon)
	{
		$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu and ct.id_mon = :id_mon');
		$stmt->execute(['id_menu' => $id_menu, 'id_mon' => $id_mon]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}




	public function update(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}

	public function delete()
	{
		$stmt = $this->db->prepare('delete from menu where id_menu = :id_menu');
		return $stmt->execute(['id_menu' => $this->id_menu]);
	}

	public function delete_mon($id_menu, $id_mon)
	{
		$stmt = $this->db->prepare('delete from menuchitiet where id_menu = :id_menu and id_mon = :id_mon');
		return $stmt->execute([
			'id_menu' => $id_menu,
			'id_mon' => $id_mon

		]);
	}

	public function delete_detail()
	{
		$stmt = $this->db->prepare('delete from menuchitiet where id_menu = :id_menu and id_mon = :id_mon');
		return $stmt->execute([
			'id_menu' => $this->getId(),
			'id_mon' => $this->id_mon
		]);
	}
	//Dem tong so luot dat tiec
	public function count_tongLuot(){
		$sql = "SELECT * from dattiec";
	    $query = $this->db->prepare($sql);
	    $query->execute([
	       
	    ]);
	    return $query->rowCount();
	    //  return  $query->fetch();
	}
	//Dem so luot dat tiec tung dich vu
	public function count_luotDat_theoDV($id_dv){
		$sql = "SELECT * from dattiec where id_dv = :id_dv";
	    $query = $this->db->prepare($sql);
	    $query->execute([
	       'id_dv'=>$id_dv
	    ]);
	    return $query->rowCount();
	    //  return  $query->fetch();
	}






	public function insert_menu(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_menu2();
		}
		return false;
	}
	public function insert_menu2()
	{
		$sql = "insert into menuchitiet (id_menu,id_mon) values (:id_menu, :id_mon)";
		$query = $this->db->prepare($sql);
		$result = $query->execute([

			'id_menu' => $this->id_menu,
			'id_mon' => $this->id_mon

		]);
		if ($result) {
			$this->id = $this->db->lastInsertId();
		}
		return $result;
	}
}
