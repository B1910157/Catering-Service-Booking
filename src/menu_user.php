<?php
//ok
namespace CT466\Project;

class menu_user
{
	private $db;

	private $id_menu_user = -1;
	public $id_dv;
    public $id_user;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_menu_user;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

//dien thong tin   vao csdl
	public function fill(array $data)
	{
		if (isset($data['id_dv'])) {
			$this->id_dv = trim($data['id_dv']);
		}
        if (isset($data['id_user'])) {
			$this->id_user = trim($data['id_user']);
		}
		return $this;
	}
	//Xuat loi
	public function getValidationErrors()
	{
		return $this->errors;
	}

	//Kiem tra loi
	public function validate()
	{
		if (!$this->id_dv) {
			$this->errors['id_dv'] = 'id_dv không hợp lệ.';
		}
        if (!$this->id_user) {
			$this->errors['id_user'] = 'id_user không hợp lệ.';
		}
		return empty($this->errors);
	}
	//Lay du lieu tu csdl
	protected function fillFromDB(array $row)
	{
		[
		'id_menu_user' => $this->id_menu_user,
		'id_dv' => $this->id_dv,
        'id_user' => $this->id_user,

		] = $row;
		return $this;
	}
	//Hien thi tat ca danh muc
	public function all($id_user, $id_dv)
	{
		$menu_users = [];
		$stmt = $this->db->prepare('select * from menu_user where id_user = :id_user and id_dv = :id_dv');
		$stmt->execute([
			
			'id_user' => $id_user,
			'id_dv' => $id_dv
		]);
		while ($row = $stmt->fetch()) {
			$menu_user = new menu_user($this->db);
			$menu_user->fillFromDB($row);
			$menu_users[] = $menu_user;
		} return $menu_users;
	} 

	public function LS($id_dattiec, $id_user, $id_dv, $id_menu)
	{
		$menu_users = [];
		$stmt = $this->db->prepare('select * from menu_user join dattiec on menu_user.id_menu_user = dattiec.id_menu where id_menu_user = :id_menu_user and menu_user.id_user = :id_user and menu_user.id_dv = :id_dv and dattiec.id_dattiec = :id_dattiec');
		$stmt->execute([
			'id_menu_user' => $id_menu,
			'id_user' => $id_user,
			'id_dv' => $id_dv,
			'id_dattiec' => $id_dattiec
		]);
		while ($row = $stmt->fetch()) {
			$menu_user = new menu_user($this->db);
			$menu_user->fillFromDB($row);
			$menu_users[] = $menu_user;
		} return $menu_users;
	} 
	

	public function findMenu()
	{
		$stmt = $this->db->prepare('select * from menu_user join chitietmenu where id_menu_user = :id_menu_user');
		$stmt->execute(['id_menu_user' => $this->id_menu_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}

	
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_menu_user >= 0) {
			$stmt = $this->db->prepare('update menu_user set id_dv = :id_dv, id_user = :id_user
			                            where id_menu_user = :id_menu_user');
			$result = $stmt->execute([
			'id_dv' => $this->id_dv,
            'id_user' => $this->id_user,
			'id_menu_user' => $this->id_menu_user]);
		
		} else {
			$stmt = $this->db->prepare(
			'insert into  menu_user (id_dv, id_user)
			values (:id_dv, :id_user)');
			$result = $stmt->execute([
			'id_dv' => $this->id_dv,
            'id_user' => $this->id_user
			]);
			if ($result) {
				$this->id_menu_user = $this->db->lastInsertId();
			}
			
			//move_uploaded_file : di chuyen tep da tai len den file moi vua tao
		} return $result;
	}

	//Tim san pham tren id
	public function find($id_menu_user)
	{
		$stmt = $this->db->prepare('select * from menu_user where id_menu_user = :id_menu_user');
		$stmt->execute(['id_menu_user' => $id_menu_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	} 
	public function findOfUser($id_user)
	{
		$stmt = $this->db->prepare('select * from menu_user where id_user = :id_user');
		$stmt->execute(['id_user' => $id_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	} 


	//Cap nhat san pham
	public function update(array $data)
	{
		//basename : tra ve ten tep tu mot duong dan
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		} return false; 
	}
	//Kiem tra rang buoc khoa ngoai khi xoa
	//Neu danh muc muon xoa co ton tai san pham thi danh muc nat khong duoc xoa
	// public function validateToDelete()
	// {
	// 	$check = $this->db->query("select * from monan where id_menu_user = '$this->id_menu_user'")->rowCount();
	// 	if ($check != 0) {
	// 		return false;
	// 	} 
	// 	return true;
		
	// }
	public function delete()
	{
		$stmt = $this->db->prepare('delete from menu_user where id_menu_user = :id_menu_user');
		return $stmt->execute(['id_menu_user' => $this->id_menu_user]);
	}


}
