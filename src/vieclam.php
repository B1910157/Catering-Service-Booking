<?php

namespace CT466\Project;

class vieclam{
    private $db;
	private $id_vl = -1;
	public $id_dv;
	// public $id_user;
	public $soluongve;
    // public $vedabook;
	public $giave;
    public $ngaylam;
    public $giolam;
	public $diachi;
    public $yeucau;
	private $errors = [];

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function getId()
	{
		return $this->id_vl;
	}

    public function fill(array $data)
	{
		if (isset($data['id_dv'])) {
			$this->id_dv = trim($data['id_dv']);
		}
		// if (isset($data['id_user'])) {
		// 	$this->id_user = trim($data['id_user']);
		// }
		if (isset($data['soluongve'])) {
			$this->soluongve = trim($data['soluongve']);
		}
		
		if (isset($data['giave'])) {
			$this->giave = trim($data['giave']);
		}
		if (isset($data['ngaylam'])) {
			$this->ngaylam = trim($data['ngaylam']);
		}
		if (isset($data['giolam'])) {
			$this->giolam = trim($data['giolam']);
		}

		if (isset($data['diachi'])) {
			$this->diachi = trim($data['diachi']);
		}
        if (isset($data['yeucau'])) {
			$this->yeucau = trim($data['yeucau']);
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
			$this->errors['id_dv'] = 'id dv không hợp lệ.';
		}

		// if (!$this->id_user) {
		// 	$this->errors['id_user'] = 'id user không hợp lệ.';
		// } 
		if (!$this->soluongve) {
			$this->errors['soluongve'] = 'Lỗi soluongve.';
		}
		// if (!$this->vedabook) {
		// 	$this->errors['vedabook'] = 'Lỗi vedabook.';
		// }
		if (!$this->giave) {
			$this->errors['giave'] = 'Lỗi giave.';
		}
		if (!$this->ngaylam) {
			$this->errors['ngaylam'] = 'ngaylam khong hop le.';
		}

		if (!$this->giolam) {
			$this->errors['giolam'] = 'loi gio lam.';
		}

		if (!$this->diachi) {
			$this->errors['diachi'] = 'diachi khong hop le.';
		}
        if (!$this->yeucau) {
			$this->errors['yeucau'] = 'yeucau khong hop le.';
		}

		return empty($this->errors);
	}
    protected function fillFromDB(array $row)
	{
		[
		'id_vl' => $this->id_vl,
		'id_dv' => $this->id_dv,
		// 'id_user' => $this->id_user,
		'soluongve' => $this->soluongve,
		// 'vedabook' => $this->vedabook,
		'giave' => $this->giave,
		'ngaylam' => $this->ngaylam,
		'giolam' => $this->giolam,
		'diachi' => $this->diachi,
        'yeucau' =>$this->yeucau
		
		] = $row;
		return $this;
	} 
    public function all()
	{
		$vieclams = [];
		$stmt = $this->db->prepare('select * from vieclam');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$vieclam = new vieclam($this->db);
			$vieclam->fillFromDB($row);
			$vieclams[] = $vieclam;
		} return $vieclams;
	}
    public function find($id_vl)
	{
		$vieclams = [];
		$stmt = $this->db->prepare('select * from vieclam inner join chitietvl on vieclam.id_vl = chitietvl.id_vl where vieclam.id_vl = :id_vl');
		$stmt->execute(['id_vl' => $id_vl]);
		while ($row = $stmt->fetch()) {
			$vieclam = new vieclam($this->db);
			$vieclam->fillFromDB($row);
			$vieclams[] = $vieclam;
		} return $vieclams;
	} 
	public function findVL($id_vl)
	{
		$stmt = $this->db->prepare('select * from vieclam where id_vl = :id_vl');
		$stmt->execute(['id_vl' => $id_vl]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
    //hien thi tung menu theo id 
    public function get_DV($id_dv)
	{
		$vieclams = [];
		$stmt = $this->db->prepare('select * from dichvu inner join vieclam on dichvu.id_dv = vieclam.id_dv where dichvu.id_dv = :id_dv');
		$stmt->execute(['id_dv' => $id_dv]);
		while ($row = $stmt->fetch()) {
			$vieclam = new vieclam($this->db);
			$vieclam->fillFromDB($row);
			$vieclams[] = $vieclam;
		} return $vieclams;
	} 
    public function get_User($id_user)
	{
		$vieclams = [];
		$stmt = $this->db->prepare('select * from users inner join vieclam on users.id_user = vieclam.id_user where vieclam.id_user = :id_user');
		$stmt->execute(['id_user' => $id_user]);
		while ($row = $stmt->fetch()) {
			$vieclam = new vieclam($this->db);
			$vieclam->fillFromDB($row);
			$vieclams[] = $vieclam;
		} return $vieclams;
	} 

    //Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_vl >= 0) {
			$stmt = $this->db->prepare('update vieclam set 
			
            soluongve = :soluongve,
			giave = :giave,
            ngaylam = :ngaylam,
            giolam = :giolam,
            diachi = :diachi,
            yeucau = :yeucau

			where id_vl = :id_vl');
			$result = $stmt->execute([
				'soluongve' => $this->soluongve,
				'giave' => $this->giave,
                'ngaylam' => $this->ngaylam,
                'giolam' => $this->giolam,
                'diachi' => $this->diachi,
                'yeucau' => $this->yeucau,
				'id_vl' => $this->id_vl
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into vieclam (id_dv,soluongve, giave, ngaylam, giolam, diachi, yeucau)
			values (:id_dv, :soluongve, :giave, :ngaylam, :giolam, :diachi, :yeucau)'
			);
			$result = $stmt->execute([
				'id_dv' => $this->id_dv,
                'soluongve' => $this->soluongve,
				'giave' => $this->giave,
                'ngaylam' => $this->ngaylam,
                'giolam' =>$this->giolam,
                'diachi' =>$this->diachi, 
                'yeucau' =>$this->yeucau
				
			]);
			if ($result) {
				$this->id_vl = $this->db->lastInsertId();
			}
			
		}
		return $result;
	}

    public function get_Soluongbook(){

    }




}