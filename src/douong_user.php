<?php
//ok
namespace CT466\Project;

class douong_user
{
	private $db;

	private $id_douong_user = -1;
	public $id_dv;
    public $id_user;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_douong_user;
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
		'id_douong_user' => $this->id_douong_user,
		'id_dv' => $this->id_dv,
        'id_user' => $this->id_user,

		] = $row;
		return $this;
	}
	//Hien thi tat ca danh muc
	public function all($id_user, $id_dv)
	{
		$douong_users = [];
		$stmt = $this->db->prepare('select * from douong_user where id_user = :id_user and id_dv = :id_dv');
		$stmt->execute([
			
			'id_user' => $id_user,
			'id_dv' => $id_dv
		]);
		while ($row = $stmt->fetch()) {
			$douong_user = new douong_user($this->db);
			$douong_user->fillFromDB($row);
			$douong_users[] = $douong_user;
		} return $douong_users;
	} 

	public function LS($id_user, $id_dv, $id_douong)
	{
		$douong_users = [];
		$stmt = $this->db->prepare(
		'select * from douong_user join dattiec on douong_user.id_douong_user = dattiec.id_douong where id_douong_user = :id_douong_user and douong_user.id_user = :id_user and douong_user.id_dv = :id_dv ');
		$stmt->execute([
			'id_douong_user' => $id_douong,
			'id_user' => $id_user,
			'id_dv' => $id_dv
		]);
		while ($row = $stmt->fetch()) {
			$douong_user = new douong_user($this->db);
			$douong_user->fillFromDB($row);
			$douong_users[] = $douong_user;
		} return $douong_users;
	} 

	public function finddouong()
	{
		$stmt = $this->db->prepare('select * from douong_user join chitietdouong where id_douong_user = :id_douong_user');
		$stmt->execute(['id_douong_user' => $this->id_douong_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}

	
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_douong_user >= 0) {
			$stmt = $this->db->prepare('update douong_user set id_dv = :id_dv, id_user = :id_user
			                            where id_douong_user = :id_douong_user');
			$result = $stmt->execute([
			'id_dv' => $this->id_dv,
            'id_user' => $this->id_user,
			'id_douong_user' => $this->id_douong_user]);
		
		} else {
			$stmt = $this->db->prepare(
			'insert into  douong_user (id_dv, id_user)
			values (:id_dv, :id_user)');
			$result = $stmt->execute([
			'id_dv' => $this->id_dv,
            'id_user' => $this->id_user
			]);
			if ($result) {
				$this->id_douong_user = $this->db->lastInsertId();
			}
			
			//move_uploaded_file : di chuyen tep da tai len den file moi vua tao
		} return $result;
	}

	//Tim san pham tren id
	public function find($id_douong_user)
	{
		$stmt = $this->db->prepare('select * from douong_user where id_douong_user = :id_douong_user');
		$stmt->execute(['id_douong_user' => $id_douong_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	} 
	public function findOfUser($id_user)
	{
		$stmt = $this->db->prepare('select * from douong_user where id_user = :id_user');
		$stmt->execute(['id_user' => $id_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	} 
	public function findUserAndDV($id_user, $id_dv)
	{
		$stmt = $this->db->prepare('select * from douong_user where id_user = :id_user and id_dv = :id_dv');
		$stmt->execute(['id_user' => $id_user, 'id_dv' => $id_dv]);
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
	// 	$check = $this->db->query("select * from monan where id_douong_user = '$this->id_douong_user'")->rowCount();
	// 	if ($check != 0) {
	// 		return false;
	// 	} 
	// 	return true;
		
	// }
	public function delete()
	{
		$stmt = $this->db->prepare('delete from douong_user where id_douong_user = :id_douong_user');
		return $stmt->execute(['id_douong_user' => $this->id_douong_user]);
	}


}
