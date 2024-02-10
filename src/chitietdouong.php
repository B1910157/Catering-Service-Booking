<?php

namespace CT466\Project;

class chitietdouong
{
	private $db;

	private $id_ctdu = -1;
    public $id_douong_user;
	// public $id_dv;
    // public $id_douong;

    public $id_douong;
	public $soluong;
    // public $gia_douong;
	
	private $errors = [];

	public function getId()
	{
		return $this->id_ctdu;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['id_douong_user'])) {
			$this->id_douong_user = trim($data['id_douong_user']);
		}
       
        if (isset($data['id_douong'])) {
			$this->id_douong = trim($data['id_douong']);
		}
		if (isset($data['soluong'])) {
			$this->soluong = trim($data['soluong']);
		}
        // if (isset($data['gia_douong'])) {
		// 	$this->gia_douong = preg_replace('/\D+/', '', $data['gia_douong']);
		// }
		

		return $this;
	}
    
	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->id_douong_user) {
			$this->errors['id_douong_user'] = 'id_douong_user không hợp lệ.';
		}
		

        if (!$this->id_douong) {
			$this->errors['id_douong'] = 'id mon không hợp lệ.';
		}
		if (!$this->soluong) {
			$this->errors['soluong'] = 'soluong không hợp lệ.';
		}
        // if (!$this->gia_douong) {
		// 	$this->errors['gia_douong'] = 'gia douong không hợp lệ.';
		// }
		
		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
            'id_ctdu' => $this->id_ctdu,
			'id_douong_user' => $this->id_douong_user,
            'id_douong'=> $this->id_douong,
			'soluong' => $this->soluong
		] = $row;
		return $this;
	}
   
	//Hien thi tat ca douong
	public function alldouong()
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from chitietdouong');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$douong = new chitietdouong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		}
		return $douongs;
	}
    //Hien thi tat ca douong gom ca mon an
    public function all()
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from douong_user m inner join chitietdouong ct on m.id_douong_user = ct.id_douong_user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$douong = new chitietdouong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		} return $douongs;
	} 

	//hien thi douong theo id douong
	// public function all1($id_douong)
	// {
	// 	$douongs = [];
	// 	$stmt = $this->db->prepare('select * from  douongchitiet where id_douong = :id_douong');
	// 	$stmt->execute([
	// 		'id_douong'=>$id_douong
	// 	]);
	// 	while ($row = $stmt->fetch()) {
	// 		$douong = new chitietdouong($this->db);
	// 		$douong->fillFromDB($row);
	// 		$douongs[] = $douong;
	// 	} return $douongs;
	// } 

    //hien thi tung douong theo id 
    public function showdouong($id_douong_user)
	{
		$douongs = [];
		$stmt = $this->db->prepare('select * from douong_user m inner join chitietdouong ct on m.id_douong_user = ct.id_douong_user where m.id_douong_user = :id_douong_user');
		$stmt->execute(['id_douong_user' => $id_douong_user]);
		while ($row = $stmt->fetch()) {
			$douong = new chitietdouong($this->db);
			$douong->fillFromDB($row);
			$douongs[] = $douong;
		} return $douongs;
	} 
	  //hien thi tung douong theo dich vu
	//   public function showdouong_DV($id_dv,$id_douong_user)
	//   {
	// 	  $douongs = [];
	// 	  $stmt = $this->db->prepare('select * from douong_user m inner join chitietdouong ct on m.id_douong_user = ct.id_douong_user where m.id_dv = :id_dv and m.id_douong_user = :id_douong_user');
	// 	  $stmt->execute([
	// 		'id_dv' => $id_dv,
	// 		'id_douong_user' => $id_douong_user
	// 		]
	// 	);
	// 	  while ($row = $stmt->fetch()) {
	// 		  $douong = new chitiet($this->db);
	// 		  $douong->fillFromDB($row);
	// 		  $douongs[] = $douong;
	// 	  } return $douongs;
	//   } 

    // public function getdouong($id_douong) {
	// 	$stmt = $this->db->prepare('select * from douong m inner join douongchitiet ct on m.id_douong = ct.id_douong where ct.id_douong = :id_douong');
	// 	$stmt->execute(['id_douong' => $id_douong]);
	// 	 if ($row = $stmt->fetch()) {
	// 		$this->fillFromDB($row);
	// 		return $this;
	// 	} return null;
	// }

    
	
	

	//Cap nhat hoac insert vao table
	public function save()
	{
		$result = false;
		if ($this->id_ctdu >= 0) {
			$stmt = $this->db->prepare('update chitietdouong set 
            
			id_douong = :id_douong,
			soluong = :soluong,
			where id_ctdu = :id_ctdu');
			$result = $stmt->execute([
				
				'id_douong' => $this->id_douong,
				'soluong' => $this->soluong,
                
				
				'id_ctdu' => $this->id_ctdu
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into chitietdouong (id_douong_user, id_douong, soluong)
			values (:id_douong_user, :id_douong, :soluong)'
			);
			$result = $stmt->execute([
				'id_douong_user' => $this->id_douong_user,
				'id_douong' => $this->id_douong,
				'soluong' => $this->soluong
				
			]);
			if ($result) {
				$this->id_ctdu = $this->db->lastInsertId();
			}
			
		}
		return $result;
	}

	//tim douong
	public function finddouong($id_douong_user)
	{
		$stmt = $this->db->prepare('select * from douong_user m inner join chitietdouong ct on m.id_douong_user = ct.id_douong_user where m.id_douong_user = :id_douong_user');
		$stmt->execute(['id_douong_user' => $id_douong_user]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}
	// public function findMon($id_douong)
	// {
	// 	$stmt = $this->db->prepare('select * from douongchitiet where id_douong = :id_douong');
	// 	$stmt->execute(['id_douong' => $id_douong]);
	// 	if ($row = $stmt->fetch()) {
	// 		$this->fillFromDB($row);
	// 		return $this;
	// 	} return null;
	// }


    //tim douong va mon trong douong cua 1 dv
	//Neu ton tai thi mon nay da co trong menu
    public function find2($id_user, $id_dv, $id_douong, $id_douong_user)
	{
		$stmt = $this->db->prepare('select * from douong_user m inner join chitietdouong ct on m.id_douong_user = ct.id_douong_user where m.id_user = :id_user and m.id_dv = :id_dv and ct.id_douong = :id_douong and ct.id_douong_user = :id_douong_user');
		$stmt->execute([
			'id_user' => $id_user,
			'id_dv' => $id_dv,
			'id_douong' => $id_douong,
			'id_douong_user' => $id_douong_user
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
	// 	$stmt = $this->db->prepare('delete from douong where id_douong = :id_douong');
	// 	return $stmt->execute(['id_douong' => $this->id_douong]);
	// }

	public function delete_mon($id_douong_user, $id_douong)
	{
		$stmt = $this->db->prepare('delete from chitietdouong where id_douong_user = :id_douong_user and id_douong = :id_douong');
		return $stmt->execute(['id_douong_user' => $id_douong_user,
								'id_douong' => $id_douong
					
							]);
	}

    // public function delete_detail()
	// {
	// 	$stmt = $this->db->prepare('delete from douongchitiet where id_douong = :id_douong and id_douong = :id_douong');
	// 	return $stmt->execute([
	// 		'id_douong' => $this->getId(),
	// 		'id_douong' => $this->id_douong]);
	// }



	
    

	public function insert_douong(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert_douong2();
		}
		return false;
	}
	public function insert_douong2() {
		$sql = "insert into chitietdouong ( id_douong_user,id_douong, soluong) values (:id_douong_user, :id_douong, :soluong)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
        	'id_douong_user' => $this-> id_douong_user,
        	'id_douong' =>$this->id_douong,
			'soluong' => $this->soluong
    	]);
    	if ($result) {
				$this->id_ctdu = $this->db->lastInsertId();
			}
			return $result;
	}
	public function update_douong(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->update_douong2();
		}
		return false;
	}


	//Cap nhan lai gio hang
	public function update_douong2()
	{
		$sql = "update chitietdouong set soluong = :soluong where (id_ctdu = :id_ctdu and id_douong = :id_douong)";
		$query = $this->db->prepare($sql);
		$result = $query->execute([
			'id_ctdu' => $this->getId(),
			'soluong' => $this->soluong,
			'id_douong' => $this->id_douong
		]);
		if ($result) {
			$this->id_ctdu = $this->db->lastInsertId();
		}
		return $result;
	}

	public function update_souong_douong(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->update_souong_douong2();
		}
		return false;
	}


	//Cap nhan lai gio hang
	public function update_souong_douong2()
	{
		$sql = "update chitietdouong set soluong = :soluong where (id_douong_user = :id_douong_user and id_douong = :id_douong)";
		$query = $this->db->prepare($sql);
		$result = $query->execute([
			'id_douong_user' => $this->id_douong_user,
			'soluong' => $this->soluong,
			'id_douong' => $this->id_douong
		]);
		if ($result) {
			$this->id_ctdu = $this->db->lastInsertId();
		}
		return $result;
	}

	

   

}