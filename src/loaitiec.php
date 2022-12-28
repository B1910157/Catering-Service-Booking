<?php
//ok
namespace CT466\Project;

class loaitiec
{
	private $db;

	private $id_loaitiec = -1;
	public $ten_loai;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_loaitiec;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

//dien thong tin   vao csdl
	public function fill(array $data)
	{
		if (isset($data['ten_loai'])) {
			$this->ten_loai = trim($data['ten_loai']);
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
		if (!$this->ten_loai) {
			$this->errors['ten_loai'] = 'Tên loai mon không hợp lệ.';
		}
		return empty($this->errors);
	}
	//Lay du lieu tu csdl
	protected function fillFromDB(array $row)
	{
		[
		'id_loaitiec' => $this->id_loaitiec,
		'ten_loai' => $this->ten_loai
		] = $row;
		return $this;
	}
	//Hien thi tat ca danh muc
	public function all()
	{
		$loaitiecs = [];
		$stmt = $this->db->prepare('select * from loaitiec');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$loaitiec = new loaitiec($this->db);
			$loaitiec->fillFromDB($row);
			$loaitiecs[] = $loaitiec;
		} return $loaitiecs;
	} 

	
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_loaitiec >= 0) {
			$stmt = $this->db->prepare('update loaitiec set ten_loai = :ten_loai
			                            where id_loaitiec = :id_loaitiec');
			$result = $stmt->execute([
			'ten_loai' => $this->ten_loai,
			'id_loaitiec' => $this->id_loaitiec]);
		
		} else {
			$stmt = $this->db->prepare(
			'insert into  loaitiec (ten_loai)
			values (:ten_loai)');
			$result = $stmt->execute([
			'ten_loai' => $this->ten_loai
			]);
			if ($result) {
				$this->id_loaitiec = $this->db->lastInsertId();
			}
			
			//move_uploaded_file : di chuyen tep da tai len den file moi vua tao
		} return $result;
	}

	//Tim san pham tren id
	public function find($id_loaitiec)
	{
		$stmt = $this->db->prepare('select * from loaitiec where id_loaitiec = :id_loaitiec');
		$stmt->execute(['id_loaitiec' => $id_loaitiec]);
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
	public function validateToDelete()
	{
		$check = $this->db->query("select * from dattiec where id_loaitiec = '$this->id_loaitiec'")->rowCount();
		if ($check != 0) {
			return false;
		} 
		return true;
		
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from loaitiec where id_loaitiec = :id_loaitiec');
		return $stmt->execute(['id_loaitiec' => $this->id_loaitiec]);
	}


}
