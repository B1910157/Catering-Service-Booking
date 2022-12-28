<?php

namespace CT466\Project;

class Menu
{
	private $db;

	private $id_menu = -1;
	
    public $id_mon;
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
        // if (isset($data['id_mon'])) {
		// 	$this->id_mon = trim($data['id_mon']);
		// }
        // if (isset($data['gia_menu'])) {
		// 	$this->gia_menu = preg_replace('/\D+/', '', $data['gia_menu']);
		// }
		if (isset($data['tenmenu'])) {
			$this->tenmenu = trim($data['tenmenu']);
		}

		return $this;
	}
	public function fill1(array $data)
	{
        if (isset($data['id_mon'])) {
			$this->id_mon = trim($data['id_mon']);
		}
        // if (isset($data['gia_menu'])) {
		// 	$this->gia_menu = preg_replace('/\D+/', '', $data['gia_menu']);
		// }
		// if (isset($data['tenmenu'])) {
		// 	$this->tenmenu = trim($data['tenmenu']);
		// }

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		
        if (!$this->id_mon) {
			$this->errors['id_mon'] = 'id monkhông hợp lệ.';
		}
        // if (!$this->gia_menu) {
		// 	$this->errors['gia_menu'] = 'gia menu không hợp lệ.';
		// }
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
			'tenmenu' => $this->tenmenu,
            // 'gia_menu'=> $this->gia_menu,
            'id_mon'=> $this->id_mon
		] = $row;
		return $this;
	}
    protected function fillFromDB1(array $row)
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
			$menu->fillFromDB1($row);
			$menus[] = $menu;
		}
		return $menus;
	}
    //Hien thi tat ca menu gom ca mon an
    public function all()
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu m inner join chitietmenu ct on m.id_menu = ct.id_menu');
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
		$stmt = $this->db->prepare('select * from menu m inner join chitietmenu ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu');
		$stmt->execute(['id_menu' => $id_menu]);
		while ($row = $stmt->fetch()) {
			$menu = new Menu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 

    // public function getMenu($id_mon) {
	// 	$stmt = $this->db->prepare('select * from menu m inner join chitietmenu ct on m.id_menu = ct.id_menu where ct.id_mon = :id_mon');
	// 	$stmt->execute(['id_mon' => $id_mon]);
	// 	 if ($row = $stmt->fetch()) {
	// 		$this->fillFromDB($row);
	// 		return $this;
	// 	} return null;
	// }

    
	
	

	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_menu >= 0) {
			$stmt = $this->db->prepare('update chitietmenu set 
			id_mon = :id_mon
			where id_menu = :id_menu');
			$result = $stmt->execute([
				
				'id_mon' => $this->id_mon,
				
				'id_menu' => $this->id_menu
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into chitietmenu (id_mon)
			values (:id_mon)'
			);
			$result = $stmt->execute([
				'id_mon' => $this->id_mon
				
			]);
			if ($result) {
				$this->id_menu = $this->db->lastInsertId();
			}
			
		}
		return $result;
	}

	//tim menu
	public function findMenu($id_menu)
	{
		$stmt = $this->db->prepare('select * from menu m inner join chitietmenu ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu');
		$stmt->execute(['id_menu' => $id_menu]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}
    //tim menu va mon trong menu
    public function find2($id_menu,$id_mon)
	{
		$stmt = $this->db->prepare('select * from menu m inner join chitietmenu ct on m.id_menu = ct.id_menu where m.id_menu = :id_menu and ct.id_mon = :id_mon');
		$stmt->execute(['id_menu' => $id_menu,'id_mon' => $id_mon]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
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

    public function delete_detail()
	{
		$stmt = $this->db->prepare('delete from chitietmenu where id_menu = :id_menu and id_mon = :id_mon');
		return $stmt->execute([
			'id_menu' => $this->getId(),
			'id_mon' => $this->id_mon]);
	}



	
    public function insert_menu(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_menu1();
		} return false;
	}

	public function insert_menu1() {
		$sql = "insert into chitietmenu (id_menu,id_mon) values (:id_menu, :id_mon)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
        	'id_menu' => $this->getId(),
        	'id_mon' => $this->id_mon
        	
    	]);
    	if ($result) {
				$this->id = $this->db->lastInsertId();
			}
			return $result;
	}



	public function insertmenu(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_menu2();
		} return false;
	}
	public function insert_menu2($id_menu, $id_mon) {
		$sql = "insert into menuchitiet (id_menu,id_mon) values (:id_menu, :id_mon)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
        	'id_menu' => $this->$id_menu,
        	'id_mon' => $this->$id_mon
        	
    	]);
    	if ($result) {
				$this->id = $this->db->lastInsertId();
			}
			return $result;
	}

   

}