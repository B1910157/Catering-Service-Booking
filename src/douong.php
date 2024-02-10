<?php
//ok
namespace CT466\Project;

class douong
{
	private $db;

	private $id_douong = -1;
	public $id_dv;
	 
	public $tendouong; 
	public $giadouong;
	public $image;
    public $dvt;
	private $errors = [];

	public function getId()
	{
		return $this->id_douong;
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
		

		if (isset($data['tendouong'])) {
			$this->tendouong = trim($data['tendouong']);
		}

		if (isset($data['giadouong'])) {
			$this->giadouong = trim($data['giadouong']);
		}
        if (isset($data['dvt'])) {
			$this->dvt = trim($data['dvt']);
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
			$this->errors['id_dv'] = 'id_dv hop le.';
		}
		if (!$this->dvt) {
			$this->errors['dvt'] = 'dvt hop le.';
		}

		if (!$this->tendouong) {
			$this->errors['tendouong'] = 'Ten do uong không hợp lệ.';
		}

		if (!$this->giadouong) {
			$this->errors['giadouong'] = 'Gia không hợp lệ.';
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
			'id_douong' => $this->id_douong,
			'id_dv' => $this->id_dv,
			'tendouong' => $this->tendouong,
			'dvt' => $this->dvt,
			'giadouong' => $this->giadouong,
			'image' => $this->image
			
		] = $row;
		return $this;
	}

	//Hien thi tat ca mon an
	public function all()
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from douong');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$douong = new douong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		}
		return $douongs;
	}
	//Hien thi tat ca do uong cua DV
	public function all_DV($id_dv)
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from douong where id_dv = :id_dv');
		$stmt->execute([
			'id_dv'=>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$douong = new douong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		}
		return $douongs;
	}
	
	

	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_douong >= 0) {
			$stmt = $this->db->prepare('update douong set dvt = :dvt,
			tendouong = :tendouong, giadouong = :giadouong, image = :image
			where id_douong = :id_douong');
			$result = $stmt->execute([
				'dvt' => $this->dvt,
				'tendouong' => $this->tendouong,
				'giadouong' => $this->giadouong,
				'image' => $this->image,
				'id_douong' => $this->id_douong
			]);
			$imgname = $this->image;
			move_uploaded_file($_FILES['image']['tmp_name'], 'C:/xampp/apps/qldt/public/img/upload/' . $imgname);
		} else {
			$stmt = $this->db->prepare(
				'insert into douong (id_dv, dvt, tendouong, giadouong, image)
			values (:id_dv, :dvt, :tendouong, :giadouong, :image)'
			);
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
				'dvt' => $this->dvt,
				'tendouong' => $this->tendouong,
				'giadouong' => $this->giadouong,
				'image' => $this->image
				
			]);
			if ($result) {
				$this->id_douong = $this->db->lastInsertId();
			}
			$imgname = $this->image;
			move_uploaded_file($_FILES['image']['tmp_name'], 'C:/xampp/apps/qldt/public/img/upload/' . $imgname);
		}
		return $result;
	}

	//Tim san pham tren id
	public function find($id_douong)
	{
		$stmt = $this->db->prepare('select * from douong where id_douong = :id_douong');
		$stmt->execute(['id_douong' => $id_douong]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
	
	public function findDV1($id_dv)
	{
		$stmt = $this->db->prepare('select * from douong where id_dv =:id_dv ');
		$stmt->execute([
			'id_dv' => $id_dv
			
		]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
	//Tim mon an cua 1 dv
	public function findDoUongDV($id_dv)
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from douong where id_dv =:id_dv');
		$stmt->execute([
			'id_dv' =>$id_dv
		]);
		while ($row = $stmt->fetch()) {
			$douong = new douong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		}
		return $douongs;
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
		$stmt = $this->db->prepare('delete from douong where id_douong = :id_douong');
		return $stmt->execute(['id_douong' => $this->id_douong]);
	}

}