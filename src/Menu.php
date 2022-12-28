<?php

namespace CT466\Project;

class Menu
{
	private $db;

	private $id_menu = -1;
	
   
    // public $gia_menu;
	public $tenmenu; 
	
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
        
		if (isset($data['tenmenu'])) {
			$this->tenmenu = trim($data['tenmenu']);
		}

		return $this;
	}
	

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		
		if (!$this->tenmenu) {
			$this->errors['tenmenu'] = 'Ten menu không hợp lệ.';
		}

		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
			'id_menu' => $this->id_menu,
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

    //hien thi tung menu theo id 
    public function showmenu($id_menu)
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu where id_menu = :id_menu');
		$stmt->execute(['id_menu' => $id_menu]);
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
				'insert into menu (tenmenu)
			values (:tenmenu)'
			);
			$result = $stmt->execute([
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

}