<?php 
namespace CT466\Project;

class User {

	private $db;
	private $id_user = -1;
	public $admin;
	public $fullname;
	public $username;
	public $password;
	public $diachi;
	public $phuong;
	public $quan;
	public $tinh;
	public $sdt;
	public $email;
	public $created_day;
	
	private $errors = [];

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function getId()
	{
		return $this->id_user;
	}

	//Them du lieu vao csdl tu input cua nguoi dung nhap vao
	public function fill(array $data)
	{
		if (isset($data['fullname'])) {
			$this->fullname = trim($data['fullname']);
		}
		if (isset($data['username'])) {
			$this->username = trim($data['username']);
		}
		if (isset($data['password'])) {
			$this->password = trim($data['password']);
		}
		if (isset($data['diachi'])) {
			$this->diachi = trim($data['diachi']);
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

		if (isset($data['sdt'])) {
			$this->sdt = trim($data['sdt']);
		}
		if (isset($data['email'])) {
			$this->email = trim($data['email']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->fullname) {
			$this->errors['fullname'] = 'Tên người dùng không hợp lệ.';
		}

		if (!$this->username) {
			$this->errors['username'] = 'Tên đăng nhập không hợp lệ.';
		} elseif (strlen($this->username) < 2) {
			$this->errors['username'] = 'Tên đăng nhập phải hơn 2 ký tự.';
		}

		if (strlen($this->password) < 5) {
			$this->errors['password'] = 'Mật khẩu phải hơn 5 ký tự.';
		}elseif (!$this->password) {
			$this->errors['password'] = 'Mật khẩu không hợp lệ.';
		}

		if (!$this->diachi) {
			$this->errors['diachi'] = 'Lỗi địa chỉ.';
		}
		if (!$this->phuong) {
			$this->errors['phuong'] = 'Lỗi địa chỉ.';
		}
		if (!$this->quan) {
			$this->errors['quan'] = 'Lỗi địa chỉ.';
		}
		if (!$this->tinh) {
			$this->errors['tinh'] = 'Lỗi địa chỉ.';
		}

		if (!$this->sdt) {
			$this->errors['sdt'] = 'SDT khong hop le.';
		}

		if (!$this->email) {
			$this->errors['email'] = 'Email khong hop lệ.';
		}

		return empty($this->errors);
	}

	//Lay tat ca du lieu tu bang users
	public function all()
	{
		$users = [];
		$stmt = $this->db->prepare('select * from users');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user = new User($this->db);
			$user->fillFromDB($row);
			$users[] = $user;
		} return $users;
	}

	//Lay nguoi dung
	public function getUser()
	{
		$users = [];
		$stmt = $this->db->prepare('select * from users where admin = 0');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user = new User($this->db);
			$user->fillFromDB($row);
			$users[] = $user;
		}
		return $users;
	}

	//Lay du lieu tu csdl
	protected function fillFromDB(array $row)
	{
		[
		'id_user' => $this->id_user,
		'admin' => $this->admin,
		'fullname' => $this->fullname,
		'username' => $this->username,
		'password' => $this->password,
		'diachi' => $this->diachi,
		'phuong' => $this->phuong,
		'quan' => $this->quan,
		'tinh' => $this->tinh,
		'sdt' => $this->sdt,
		'email' => $this->email,
		'ngaytao' => $this->created_day
		
		] = $row;
		return $this;
	} 
//Tim nguoi dung
	public function find($id_user)
	{
		$stmt = $this->db->prepare('select * from users where id_user = :id_user');
		$stmt->execute(['id_user' => $id_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}

	//Tim kiem username, kiem tra neu co ton tai username trong csdl thi thông bao 
	// da ton tai va yeu cau chon 1 username khac de dang nhap
	public function findUsername($var)
	{
		$stmt = $this->db->prepare('select * from users where binary username = :var');
		$stmt->execute(['var' => $var]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}



//
//Cap nhat hoac them du lieu (Neu id ton tai thi cap nhat nguoi dung dua tren id,
// Neu id khong ton tai <= 0 thi them du lieu moi)
	public function save()
	{
		$result = false;
		if ($this->id_user > 0) {
			$stmt = $this->db->prepare('update users set fullname = :fullname,
			username = :username, password = :password, diachi = :diachi ,phuong = :phuong, quan = :quan, tinh = :tinh, sdt = :sdt, email = :email
			where id_user = :id_user');
			$result = $stmt->execute([
			'fullname' => $this->fullname,
			'username' => $this->username,
			'password' => $this->password,
			'diachi' => $this->diachi,
			'phuong' => $this->phuong,
			'quan' => $this->quan,
			'tinh' => $this->tinh,
			'sdt' => $this->sdt,
			'email' => $this->email,
			'id_user' => $this->id_user]);
		} else {
			$stmt = $this->db->prepare(
			'insert into users (fullname, username, password, diachi, phuong, quan, tinh, sdt, email, ngaytao)
			values (:fullname, :username, :password, :diachi, :phuong, :quan, :tinh, :sdt, :email, now())');
			$result = $stmt->execute([
			'fullname' => $this->fullname,
			'username' => $this->username,
			'password' => $this->password,
			'diachi' => $this->diachi,
			'phuong' => $this->phuong,
			'quan' => $this->quan,
			'tinh' => $this->tinh,
			'sdt' => $this->sdt,
			'email' => $this->email
		
		]);
			if ($result) {
				$this->id_user = $this->db->lastInsertId();
			}
		} return $result;
	}
//
//Cap nhat hoac them du lieu du lieu
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
		$stmt = $this->db->prepare('delete from users where id_user = :id_user');
		return $stmt->execute(['id_user' => $this->id_user]);
	}
	//Dem nguoi dung
	public function countUser(){
		$sql = "SELECT * from users where admin = 0";
	    $query = $this->db->prepare($sql);
	    $query->execute([
	       
	    ]);
	    return $query->rowCount();
	    //  return  $query->fetch();
	}
	//Kiem tra dang nhap
	//Ham tra ve so dong sau khi thuc hien cau lenh 
	public function checkpoint($username,$password){
		$sql = "SELECT * from users where username =:u and password =:p";
	    $query = $this->db->prepare($sql);
	    $query->execute([
	        'u' => $username,
	        'p' => $password
	    ]);
	    return $query->rowCount();
	    //  return  $query->fetch();
	}
	//Kiem tra dang nhap
	//Ham tra ve mang du lieu username va password
	public function checkpoint2($username,$password){
		$sql = "SELECT * from users where username =:u and password =:p";
	    $query = $this->db->prepare($sql);
	    $query->execute([
	        'u' => $username,
	        'p' => $password
	    ]);
	    // return $row = $query->rowCount();
	     return $query->fetch();
	}
}
 

 ?>