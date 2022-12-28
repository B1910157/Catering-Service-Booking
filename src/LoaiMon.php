<?php
//ok
namespace CT466\Project;

class LoaiMon
{
	private $db;

	private $id_loaimon = -1;
	public $tenloaimon;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_loaimon;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

//dien thong tin   vao csdl
	public function fill(array $data)
	{
		if (isset($data['tenloaimon'])) {
			$this->tenloaimon = trim($data['tenloaimon']);
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
		if (!$this->tenloaimon) {
			$this->errors['tenloaimon'] = 'Tên loai mon không hợp lệ.';
		}
		return empty($this->errors);
	}
	//Lay du lieu tu csdl
	protected function fillFromDB(array $row)
	{
		[
		'id_loaimon' => $this->id_loaimon,
		'tenloaimon' => $this->tenloaimon
		] = $row;
		return $this;
	}
	//Hien thi tat ca danh muc
	public function all()
	{
		$loaimons = [];
		$stmt = $this->db->prepare('select * from loaimon');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$loaimon = new LoaiMon($this->db);
			$loaimon->fillFromDB($row);
			$loaimons[] = $loaimon;
		} return $loaimons;
	} 

	
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_loaimon >= 0) {
			$stmt = $this->db->prepare('update loaimon set tenloaimon = :tenloaimon
			                            where id_loaimon = :id_loaimon');
			$result = $stmt->execute([
			'tenloaimon' => $this->tenloaimon,
			'id_loaimon' => $this->id_loaimon]);
		
		} else {
			$stmt = $this->db->prepare(
			'insert into  loaimon (tenloaimon)
			values (:tenloaimon)');
			$result = $stmt->execute([
			'tenloaimon' => $this->tenloaimon
			]);
			if ($result) {
				$this->id_loaimon = $this->db->lastInsertId();
			}
			
			//move_uploaded_file : di chuyen tep da tai len den file moi vua tao
		} return $result;
	}

	//Tim san pham tren id
	public function find($id_loaimon)
	{
		$stmt = $this->db->prepare('select * from loaimon where id_loaimon = :id_loaimon');
		$stmt->execute(['id_loaimon' => $id_loaimon]);
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
		$check = $this->db->query("select * from monan where id_loaimon = '$this->id_loaimon'")->rowCount();
		if ($check != 0) {
			return false;
		} 
		return true;
		
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from loaimon where id_loaimon = :id_loaimon');
		return $stmt->execute(['id_loaimon' => $this->id_loaimon]);
	}


}
