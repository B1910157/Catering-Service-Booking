<?php

namespace CT466\Project;

class Menu
{
	private $db;

	private $id_menu = -1;
	
   public $id_dv;
    
	public $tenmenu; 
	// public $giamenu;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_menu;
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
		if (isset($data['tenmenu'])) {
			$this->tenmenu = trim($data['tenmenu']);
		}
		// if (isset($data['giamenu'])) {
		// 	$this->giamenu = trim($data['giamenu']);
		// }

		return $this;
	}
	

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->id_dv) {
			$this->errors['id_dv'] = 'Dich vu không hợp lệ.';
		}
		if (!$this->tenmenu) {
			$this->errors['tenmenu'] = 'Ten menu không hợp lệ.';
		}
		// if (!$this->giamenu) {
		// 	$this->errors['giamenu'] = 'gia menu không hợp lệ.';
		// }

		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
			'id_menu' => $this->id_menu,
			'id_dv' => $this->id_dv,
			'tenmenu' => $this->tenmenu
			
            // 'gia_menu'=> $this->gia_menu,
          
		] = $row;
		return $this;
	}
    
	//Hien thi tat ca menu
	public function allmenu()
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		}
		return $menus;
	}
	//Hien thi menu tung dich vu
	public function allmenu_DV($id_dv)
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu where id_dv = :id_dv');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		}
		return $menus;
	}
    //Hien thi tat ca menu gom ca mon an
    public function all()
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 

	//hien thi tung menu cua dich vu 
    public function showmenu($id_menu)
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu where id_menu = :id_menu');
		$stmt->execute([
			
			'id_menu' => $id_menu
		]);
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 
    //hien thi tung menu cua dich vu 
    public function showmenu_DV($id_dv, $id_menu)
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu where id_dv = :id_dv and id_menu = :id_menu');
		$stmt->execute([
			'id_dv' => $id_dv,
			'id_menu' => $id_menu
		]);
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_menu >= 0) {
			$stmt = $this->db->prepare('update menu set 
			tenmenu = :tenmenu
			where id_menu = :id_menu');
			$result = $stmt->execute([
				
				'tenmenu' => $this->tenmenu,
				
				
				'id_menu' => $this->id_menu
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into menu (id_dv, tenmenu)
			values (:id_dv, :tenmenu)'
			);
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
				'tenmenu' => $this->tenmenu
			]);
			if ($result) {
				$this->id_menu = $this->db->lastInsertId();
			}
			
		}
		return $result;
	}
	//Cap nhat ten menu
	public function update(array $data)
	{
		//basename : tra ve ten tep tu mot duong dan
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		} return false; 
	}

	//tim menu
	public function findMenu($id_menu)
	{
		$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu');
		$stmt->execute(['id_menu' => $id_menu]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}
   


	//Kiem tra rang buoc khoa ngoai khi xoa
	//Neu danh muc muon xoa co ton tai san pham thi danh muc nat khong duoc xoa
	public function validateToDelete()
	{
		$checkmenu = $this->db->query("select * from dattiec where id_menu = '$this->id_menu'")->rowCount();
		if ($checkmenu != 0) {
			return false;
		} 
		return true;
		
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from menu where id_menu = :id_menu');
		return $stmt->execute(['id_menu' => $this->id_menu]);
	}




	// public function insertMenu(array $data)
	// {
	// 	$this->fill($data);
	// 	if ($this->validate()) {
	// 		return $this->insertOrder2();
	// 	} return false;
	// }
	// ///Them san pham vao gio hang
	// public function insertOrder2(){
	// 	$giamenu = 0;
	// 	$result = $this->db->prepare('select m.*, ct.id_mon, ma.gia_mon  from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu inner join monan ma on ct.id_mon= ma.id_mon where m.id_menu = :id_menu ');
	// 	$result->execute(['id_menu' => $this->id_menu]);
	// 	// $cart = $result->fetch();
	// 	foreach ($result as $menu) {
	// 		$giamenu = $giamenu + $menu['gia'];
	// 		// echo $giamenu;
	// 		// print_r($cart);
	// 	}
	// 	$stmt = $this->db->prepare(
	// 	'insert into menu (id_dv, tenmenu, giamenu)
	// 	values (:id_dv, :tenmenu, :giamenu');
	// 	$order = $stmt->execute([
	// 	'id_dv' => $this->id_dv,
	// 	'tenmenu' => $this->tenmenu,
	// 	'giamenu' => $giamenu
	// 	]);
	// 	// $sql = $this->db->prepare('delete from chitietgiohang where cart_id = :cart_id');
	// 	// $delcart = $sql->execute(['cart_id' => $this->cart_id]);
	// 	// $sql = $this->db->prepare('delete from giohang where cart_id = :cart_id');
	// 	// $delcart2 = $sql->execute(['cart_id' => $this->cart_id]);
	// 	if ($order) {
	// 		$this->id_menu = $this->db->lastInsertId();
	// 	}
	// return $order;
	// }






}