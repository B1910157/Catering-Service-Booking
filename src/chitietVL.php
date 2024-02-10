<?php
//ok
namespace CT466\Project;

class chitietVL
{
	private $db;

	private $id_ctvl = -1;
    public $id_vl;
	public $id_dv;
    public $id_user;
    public $soluongbook;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_ctvl;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

//dien thong tin   vao csdl
	public function fill(array $data)
	{
        if (isset($data['id_vl'])) {
			$this->id_vl = trim($data['id_vl']);
		}
		if (isset($data['id_dv'])) {
			$this->id_dv = trim($data['id_dv']);
		}
        if (isset($data['id_user'])) {
			$this->id_user = trim($data['id_user']);
		}
        if (isset($data['soluongbook'])) {
			$this->soluongbook = trim($data['soluongbook']);
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
        if (!$this->id_vl) {
			$this->errors['id_vl'] = 'id_vl không hợp lệ.';
		}
		if (!$this->id_dv) {
			$this->errors['id_dv'] = 'Dich vu không hợp lệ.';
		}
        if (!$this->id_user) {
			$this->errors['id_user'] = 'User không hợp lệ.';
		}
        if (!$this->soluongbook) {
			$this->errors['soluongbook'] = 'User không hợp lệ.';
		}
		return empty($this->errors);
	}
	//Lay du lieu tu csdl
	protected function fillFromDB(array $row)
	{
		[
		'id_ctvl' => $this->id_ctvl,
        'id_vl' =>$this->id_vl,
		'id_dv' => $this->id_dv,
        'id_user' =>$this->id_user,
        'soluongbook' =>$this->soluongbook
		] = $row;
		return $this;
	}
	//Hien thi tat ca danh muc
	public function all()
	{
		$chitietVLs = [];
		$stmt = $this->db->prepare('select * from chitietVL');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$chitietVL = new chitietVL($this->db);
			$chitietVL->fillFromDB($row);
			$chitietVLs[] = $chitietVL;
		} return $chitietVLs;
	} 

	
	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_ctvl >= 0) {
			$stmt = $this->db->prepare('update chitietvl set id_user = :id_user
			                            where id_ctvl = :id_ctvl');
			$result = $stmt->execute([
			'id_user' => $this->id_user,
			'id_ctvl' => $this->id_ctvl]);
		
		} else {
			$stmt = $this->db->prepare(
			'insert into  chitietvl (id_dv, id_user)
			values (:id_dv, id_user)');
			$result = $stmt->execute([
			'id_dv' => $this->id_dv,
            'id_user' =>$this->id_user
			]);
			if ($result) {
				$this->id_ctvl = $this->db->lastInsertId();
			}
			
			//move_uploaded_file : di chuyen tep da tai len den file moi vua tao
		} return $result;
	}

	//Tim san pham tren id
	public function find_DV($id_dv)
	{
		$stmt = $this->db->prepare('select * from chitietvl join vieclam on chitietvl.id_dv = vieclam.id_dv where id_dv = :id_dv');
		$stmt->execute(['id_dv' => $id_dv]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	} 
    public function find($id_vl)
	{
		$stmt = $this->db->prepare('select * from chitietvl join vieclam on chitietvl.id_vl = vieclam.id_vl where chitietvl.id_vl = :id_vl');
		$stmt->execute(['id_vl' => $id_vl]);
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
	
	public function delete()
	{
		$stmt = $this->db->prepare('delete from chitietvl where id_ctvl = :id_ctvl');
		return $stmt->execute(['id_ctvl' => $this->id_ctvl]);
	}


    public function insert_VL(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_VL1();
		}
		return false;
	}
	public function insert_VL1() {
		$sql = "insert into chitietvl (id_vl, id_dv, id_user, soluongbook) values (:id_vl, :id_dv, :id_user, :soluongbook)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
			'id_vl' => $this->id_vl,
            'id_dv' =>$this->id_dv,
        	'id_user' => $this-> id_user,
        	'soluongbook' =>$this->soluongbook
        	
    	]);
    	if ($result) {
				$this->id_ctvl = $this->db->lastInsertId();
			}
			return $result;
	}

	public function update_VL(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->update_VL1();
		}
		return false;
	}


	//Cap nhan lai gio hang
	public function update_VL1()
	{
		$sql = "update chitietvl set soluongbook = :soluongbook where (id_vl = :id_vl and id_user = :id_user and id_dv = :id_dv)";
		$query = $this->db->prepare($sql);
		$result = $query->execute([
			'id_vl' => $this->id_vl,
			'soluongbook' => $this->soluongbook,
			'id_user' => $this->id_user,
			'id_dv' => $this->id_dv
		]);
		if ($result) {
			$this->id_ctvl = $this->db->lastInsertId();
		}
		return $result;
	}


	public function getVL($id_vl, $id_user)
	{
		$stmt = $this->db->prepare('select * from vieclam inner join chitietvl  on vieclam.id_vl = chitietvl.id_vl where chitietvl.id_user = :id_user and chitietvl.id_vl = :id_vl');
		$stmt->execute(['id_user' => $id_user, 'id_vl' => $id_vl]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}

}
