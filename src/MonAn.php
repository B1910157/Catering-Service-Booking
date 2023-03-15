<?php
//ok
namespace CT466\Project;

class MonAn
{
	private $db;

	private $id_mon = -1;
	public $id_dv;
	public $id_loaimon; 
	public $tenmon; 
	public $gia_mon;
	public $image;
	private $errors = [];

	public function getId()
	{
		return $this->id_mon;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data, $file)
	{
		if (isset($data['id_dv'])) {
			$this->id_dv = trim($data['id_dv']);
		}
		if (isset($data['id_loaimon'])) {
			$this->id_loaimon = trim($data['id_loaimon']);
		}

		if (isset($data['tenmon'])) {
			$this->tenmon = trim($data['tenmon']);
		}

		if (isset($data['gia_mon'])) {
			$this->gia_mon = trim($data['gia_mon']);
		}
		if (isset($file)) {
			//Lay ten cua anh duoc submit 
			$this->image = ($file['image']['name']);
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
			$this->errors['id_dv'] = 'Loai mon khong hop le.';
		}
		if (!$this->id_loaimon) {
			$this->errors['id_loaimon'] = 'Loai mon khong hop le.';
		}

		if (!$this->tenmon) {
			$this->errors['tenmon'] = 'Ten mon không hợp lệ.';
		}

		if (!$this->gia_mon) {
			$this->errors['gia_mon'] = 'Gia không hợp lệ.';
		}

		if (!$this->image) {
			$this->errors['image'] = 'Ảnh sản phẩm không hợp lệ.';
		}
		

		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
			'id_mon' => $this->id_mon,
			'id_dv' => $this->id_dv,
			'tenmon' => $this->tenmon,
			'id_loaimon' => $this->id_loaimon,
			'gia_mon' => $this->gia_mon,
			'image' => $this->image
			
		] = $row;
		return $this;
	}

	//Hien thi tat ca mon an
	public function all()
	{
		$monans = [];
		$stmt = $this->db->prepare('select * from monan');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$monan = new MonAn($this->db);
			$monan->fillFromDB($row);
			$monans[] = $monan;
		}
		return $monans;
	}
	//Hien thi tat ca mon an cua DV
	public function all_DV($id_dv)
	{
		$monans = [];
		$stmt = $this->db->prepare('select * from monan where id_dv = :id_dv');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$monan = new MonAn($this->db);
			$monan->fillFromDB($row);
			$monans[] = $monan;
		}
		return $monans;
	}
	
	

	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_mon >= 0) {
			$stmt = $this->db->prepare('update monan set id_loaimon = :id_loaimon,
			tenmon = :tenmon, gia_mon = :gia_mon, image = :image
			where id_mon = :id_mon');
			$result = $stmt->execute([
				'id_loaimon' => $this->id_loaimon,
				'tenmon' => $this->tenmon,
				'gia_mon' => $this->gia_mon,
				'image' => $this->image,
				'id_mon' => $this->id_mon
			]);
			$imgname = $this->image;
			move_uploaded_file($_FILES['image']['tmp_name'], 'C:/xampp/apps/qldt/public/img/upload/' . $imgname);
		} else {
			$stmt = $this->db->prepare(
				'insert into monan (id_dv, id_loaimon, tenmon, gia_mon, image)
			values (:id_dv, :id_loaimon, :tenmon, :gia_mon, :image)'
			);
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
				'id_loaimon' => $this->id_loaimon,
				'tenmon' => $this->tenmon,
				'gia_mon' => $this->gia_mon,
				'image' => $this->image
				
			]);
			if ($result) {
				$this->id_mon = $this->db->lastInsertId();
			}
			$imgname = $this->image;
			move_uploaded_file($_FILES['image']['tmp_name'], 'C:/xampp/apps/qldt/public/img/upload/' . $imgname);
		}
		return $result;
	}

	//Tim san pham tren id
	public function find($id_mon)
	{
		$stmt = $this->db->prepare('select * from monan where id_mon = :id_mon');
		$stmt->execute(['id_mon' => $id_mon]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
	
	public function findMonDV1($id_dv)
	{
		$stmt = $this->db->prepare('select * from monan where id_dv =:id_dv ');
		$stmt->execute([
			'id_dv' => $id_dv
			
		]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
	//Tim mon an cua 1 dv
	public function findMonDV($id_dv)
	{
		$monans = [];
		$stmt = $this->db->prepare('select * from monan where id_dv =:id_dv');
		$stmt->execute([
			'id_dv' =>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$monan = new MonAn($this->db);
			$monan->fillFromDB($row);
			$monans[] = $monan;
		}
		return $monans;
	}


	

	public function update(array $data, $file)
	{
		$this->fill($data, $file);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}

	public function delete()
	{
		$stmt = $this->db->prepare('delete from monan where id_mon = :id_mon');
		return $stmt->execute(['id_mon' => $this->id_mon]);
	}

}