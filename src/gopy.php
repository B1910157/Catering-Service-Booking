<?php
//ok
namespace CT466\Project;

class gopy
{
	private $db;

	private $id_gopy = -1;
	
	public $nguoigopy; 
	public $email;
	public $noidung;
   
	private $errors = [];

	public function getId()
	{
		return $this->id_gopy;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['nguoigopy'])) {
			$this->nguoigopy = trim($data['nguoigopy']);
		}
		

		if (isset($data['email'])) {
			$this->email = trim($data['email']);
		}

		if (isset($data['noidung'])) {
			$this->noidung = trim($data['noidung']);
		}
       

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->nguoigopy) {
			$this->errors['nguoigopy'] = 'nguoigopy hop le.';
		}
		if (!$this->email) {
			$this->errors['email'] = 'email hop le.';
		}

		if (!$this->noidung) {
			$this->errors['noidung'] = 'noidung không hợp lệ.';
		}

		
		return empty($this->errors);
	}

	//Lay du lieu tu csdl table 
	protected function fillFromDB(array $row)
	{
		[
			'id_gopy' => $this->id_gopy,
			'nguoigopy' => $this->nguoigopy,
			'email' => $this->email,
			'noidung' => $this->noidung,
			
			
		] = $row;
		return $this;
	}

	//Hien thi tat ca mon an
	public function all()
	{
		$gopys = [];
		$stmt = $this->db->prepare('select * from gopy');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$gopy = new gopy($this->db);
			$gopy->fillFromDB($row);
			$gopys[] = $gopy;
		}
		return $gopys;
	}
	
	
	

	//Tim san pham tren id
	public function find($id_gopy)
	{
		$stmt = $this->db->prepare('select * from gopy where id_gopy = :id_gopy');
		$stmt->execute(['id_gopy' => $id_gopy]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} else return null;
	}
	
	public function insert(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insert2();
		}
		return false;
	}
	public function insert2() {
		$sql = "insert into gopy (nguoigopy, email,noidung) values (:nguoigopy, :email, :noidung)";
    	$query = $this->db->prepare($sql);
    	$result = $query->execute([
			'nguoigopy' => $this-> nguoigopy,
        	'email' => $this-> email,
        	'noidung' =>$this->noidung
        	
    	]);
    	if ($result) {
				$this->id_gopy = $this->db->lastInsertId();
			}
			return $result;
	}
	

	
	public function delete()
	{
		$stmt = $this->db->prepare('delete from gopy where id_gopy = :id_gopy');
		return $stmt->execute(['id_gopy' => $this->id_gopy]);
	}

}