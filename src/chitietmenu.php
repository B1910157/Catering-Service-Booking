<?php

namespace CT466\Project;

class chitietmenu
{
	private $db;

	private $id_ctmn = -1;
    public $id_menu_user;
	// public $id_dv;
    // public $id_menu;
    public $id_mon;
    // public $gia_menu;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_ctmn;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['id_menu_user'])) {
			$this->id_menu_user = trim($data['id_menu_user']);
		}
       
        if (isset($data['id_mon'])) {
			$this->id_mon = trim($data['id_mon']);
		}
        // if (isset($data['gia_menu'])) {
		// 	$this->gia_menu = preg_replace('/\D+/', '', $data['gia_menu']);
		// }
		

		return $this;
	}
	
	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->id_menu_user) {
			$this->errors['id_menu_user'] = 'id_menu_user không hợp lệ.';
		}
		

        if (!$this->id_mon) {
			$this->errors['id_mon'] = 'id mon không hợp lệ.';
		}
        // if (!$this->gia_menu) {
		// 	$this->errors['gia_menu'] = 'gia menu không hợp lệ.';
		// }
		
		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
            'id_ctmn' => $this->id_ctmn,
			'id_menu_user' => $this->id_menu_user,
            'id_mon'=> $this->id_mon
		] = $row;
		return $this;
	}
   
	//Hien thi tat ca menu
	public function allmenu()
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from chitietmenu');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$menu = new chitietmenu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		}
		return $menus;
	}
    //Hien thi tat ca menu gom ca mon an
    public function all()
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu_user m inner join chitietmenu ct on m.id_menu_user = ct.id_menu_user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$menu = new chitietmenu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 

	//hien thi menu theo id menu
	// public function all1($id_menu)
	// {
	// 	$menus = [];
	// 	$stmt = $this->db->prepare('select * from  menuchitiet where id_menu = :id_menu');
	// 	$stmt->execute([
	// 		'id_menu'=>$id_menu
	// 	]);
	// 	while ($row = $stmt->fetch()) {
	// 		$menu = new chitietmenu($this->db);
	// 		$menu->fillFromDB($row);
	// 		$menus[] = $menu;
	// 	} return $menus;
	// } 

    //hien thi tung menu theo id 
    public function showmenu($id_menu_user)
	{
		$menus = [];
		$stmt = $this->db->prepare('select * from menu_user m inner join chitietmenu ct on m.id_menu_user = ct.id_menu_user where m.id_menu_user = :id_menu_user');
		$stmt->execute(['id_menu_user' => $id_menu_user]);
		while ($row = $stmt->fetch()) {
			$menu = new chitietmenu($this->db);
			$menu->fillFromDB($row);
			$menus[] = $menu;
		} return $menus;
	} 
	  //hien thi tung menu theo dich vu
	//   public function showmenu_DV($id_dv,$id_menu_user)
	//   {
	// 	  $menus = [];
	// 	  $stmt = $this->db->prepare('select * from menu_user m inner join chitietmenu ct on m.id_menu_user = ct.id_menu_user where m.id_dv = :id_dv and m.id_menu_user = :id_menu_user');
	// 	  $stmt->execute([
	// 		'id_dv' => $id_dv,
	// 		'id_menu_user' => $id_menu_user
	// 		]
	// 	);
	// 	  while ($row = $stmt->fetch()) {
	// 		  $menu = new chitiet($this->db);
	// 		  $menu->fillFromDB($row);
	// 		  $menus[] = $menu;
	// 	  } return $menus;
	//   } 

    // public function getMenu($id_mon) {
	// 	$stmt = $this->db->prepare('select * from menu m inner join menuchitiet ct on m.id_menu = ct.id_menu where ct.id_mon = :id_mon');
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
		if ($this->id_ctmn >= 0) {
			$stmt = $this->db->prepare('update chitietmenu set 
            id_menu_user = :id_menu_user, 
			id_mon = :id_mon
			where id_ctmn = :id_ctmn');
			$result = $stmt->execute([
				'id_menu_user' => $this->id_menu_user,
				'id_mon' => $this->id_mon,
                
				
				'id_ctmn' => $this->id_ctmn
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into chitietmenu (id_usermenu, id_mon)
			values (:id_usermenu, :id_mon)'
			);
			$result = $stmt->execute([
				'id_menu_user' => $this->id_menu_user,
				'id_mon' => $this->id_mon
				
			]);
			if ($result) {
				$this->id_ctmn = $this->db->lastInsertId();
			}
			
		}
		return $result;
	}

	//tim menu
	public function findMenu($id_menu_user)
	{
		$stmt = $this->db->prepare('select * from menu_user m inner join chitietmenu ct on m.id_menu_user = ct.id_menu_user where m.id_menu_user = :id_menu_user');
		$stmt->execute(['id_menu_user' => $id_menu_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}
	// public function findMon($id_mon)
	// {
	// 	$stmt = $this->db->prepare('select * from menuchitiet where id_mon = :id_mon');
	// 	$stmt->execute(['id_mon' => $id_mon]);
	// 	if ($row = $stmt->fetch()) {
	// 		$this->fillFromDB($row);
	// 		return $this;
	// 	} return null;
	// }


    //tim menu va mon trong menu cua 1 dv
    public function find2($id_menu_user,$id_mon)
	{
		$stmt = $this->db->prepare('select * from menu_user m inner join chitietmenu ct on m.id_menu_user = ct.id_menu_user where m.id_menu_user = :id_menu_user and ct.id_mon = :id_mon');
		$stmt->execute([
			'id_menu_user' => $id_menu_user,
			'id_mon' => $id_mon
		]);
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

	// public function delete()
	// {
	// 	$stmt = $this->db->prepare('delete from menu where id_menu = :id_menu');
	// 	return $stmt->execute(['id_menu' => $this->id_menu]);
	// }

	public function delete_mon($id_menu_user, $id_mon)
	{
		$stmt = $this->db->prepare('delete from chitietmenu where id_menu_user = :id_menu_user and id_mon = :id_mon');
		return $stmt->execute(['id_menu_user' => $id_menu_user,
								'id_mon' => $id_mon
					
							]);
	}

    // public function delete_detail()
	// {
	// 	$stmt = $this->db->prepare('delete from menuchitiet where id_menu = :id_menu and id_mon = :id_mon');
	// 	return $stmt->execute([
	// 		'id_menu' => $this->getId(),
	// 		'id_mon' => $this->id_mon]);
	// }



	
    

	public function insert_menu(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_menu2();
		}
		return false;
	}
	public function insert_menu2() {
		$sql = "insert into chitietmenu ( id_menu_user,id_mon) values (:id_menu_user, :id_mon)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
        	'id_menu_user' => $this-> id_menu_user,
        	'id_mon' =>$this->id_mon
    	]);
    	if ($result) {
				$this->id_ctmn = $this->db->lastInsertId();
			}
			return $result;
	}

	

   

}