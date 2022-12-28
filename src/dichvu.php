<?php

namespace CT466\Project;

class dichvu
{

    private $db;
    private $id_dv = -1;

    public $ten_dv;
    public $email;
    public $password;
    public $sdt;

    public $dv_diachi;
    public $dv_phuong;
    public $dv_quan;
    public $dv_tinh;
    public $trangthai;

    public $ngaytao;

    private $errors = [];

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getId()
    {
        return $this->id_dv;
    }

    //Them du lieu vao csdl tu input cua nguoi dung nhap vao
    public function fill(array $data)
    {
        if (isset($data['ten_dv'])) {
            $this->ten_dv = trim($data['ten_dv']);
        }
        if (isset($data['email'])) {
            $this->email = trim($data['email']);
        }
        if (isset($data['password'])) {
            $this->password = trim($data['password']);
        }
        if (isset($data['sdt'])) {
            $this->sdt = trim($data['sdt']);
        }
        if (isset($data['dv_diachi'])) {
            $this->dv_diachi = trim($data['dv_diachi']);
        }
        if (isset($data['dv_phuong'])) {
            $this->dv_phuong = trim($data['dv_phuong']);
        }
        if (isset($data['dv_quan'])) {
            $this->dv_quan = trim($data['dv_quan']);
        }
        if (isset($data['dv_tinh'])) {
            $this->dv_tinh = trim($data['dv_tinh']);
        }

        return $this;
    }

    public function getValidationErrors()
    {
        return $this->errors;
    }

    public function validate()
    {
        if (!$this->ten_dv) {
            $this->errors['ten_dv'] = 'Tên dịch vụ không hợp lệ.';
        }

        if (!$this->email) {
            $this->errors['email'] = 'Email khong hop lệ.';
        }
        if (strlen($this->password) < 5) {
            $this->errors['password'] = 'Mật khẩu phải hơn 5 ký tự.';
        } elseif (!$this->password) {
            $this->errors['password'] = 'Mật khẩu không hợp lệ.';
        }
        if (!$this->sdt) {
            $this->errors['sdt'] = 'SDT khong hop le.';
        }
        if (!$this->dv_diachi) {
            $this->errors['dv_diachi'] = 'Lỗi địa chỉ.';
        }
        if (!$this->dv_phuong) {
            $this->errors['dv_phuong'] = 'Lỗi địa chỉ.';
        }
        if (!$this->dv_quan) {
            $this->errors['dv_quan'] = 'Lỗi địa chỉ.';
        }
        if (!$this->dv_tinh) {
            $this->errors['dv_tinh'] = 'Lỗi địa chỉ.';
        }
        return empty($this->errors);
    }

    //Lay tat ca du lieu tu bang dichvu
    public function all()
    {
        $dichvus = [];
        $stmt = $this->db->prepare('select * from dichvu');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $dichvu = new dichvu($this->db);
            $dichvu->fillFromDB($row);
            $dichvus[] = $dichvu;
        }
        return $dichvus;
    }


    //Dem dich vu
    public function count_DV_ON()
    {
        $sql = "SELECT * from dichvu where trangthai = 1";
        $query = $this->db->prepare($sql);
        $query->execute([]);
        return $query->rowCount();
        //  return  $query->fetch();
    }
    //Dem dich vu
    public function count_DV_OFF()
    {
        $sql = "SELECT * from dichvu where trangthai = 0";
        $query = $this->db->prepare($sql);
        $query->execute([]);
        return $query->rowCount();
        //  return  $query->fetch();
    }
    //Lay nguoi dung
    public function GetDichVu_On()
    {
        $dichvus = [];
        $stmt = $this->db->prepare('select * from dichvu where trangthai = 1');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $dichvu = new dichvu($this->db);
            $dichvu->fillFromDB($row);
            $dichvus[] = $dichvu;
        }
        return $dichvus;
    }

    //Lay du lieu tu csdl
    protected function fillFromDB(array $row)
    {
        [
            'id_dv' => $this->id_dv,
            'ten_dv' => $this->ten_dv,
            'email' => $this->email,
            'password' => $this->password,
            'sdt' => $this->sdt,
            'dv_diachi' => $this->dv_diachi,
            'dv_phuong' => $this->dv_phuong,
            'dv_quan' => $this->dv_quan,
            'dv_tinh' => $this->dv_tinh,
            'trangthai' => $this->trangthai,
            'ngaytao' => $this->ngaytao

        ] = $row;
        return $this;
    }
    //Tim nguoi dung
    public function find($id_dv)
    {
        $stmt = $this->db->prepare('select * from dichvu where id_dv = :id_dv');
        $stmt->execute(['id_dv' => $id_dv]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }
    public function findDV($id_dv)
	{
		$stmt = $this->db->prepare('select * from dattiec m inner join dichvu ct on m.id_dv = ct.id_dv where m.id_dv = :id_dv');
		$stmt->execute(['id_dv' => $id_dv]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		} return null;
	}
    //Tim kiem email, kiem tra neu co ton tai email trong csdl thi thông bao 
    // da ton tai va yeu cau chon 1 username khac de dang nhap
    public function findEmail($e)
    {
        $stmt = $this->db->prepare('select * from dichvu where binary email = :e');
        $stmt->execute(['e' => $e]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }



    //
    //Cap nhat hoac them du lieu (Neu id ton tai thi cap nhat nguoi dung dua tren id,
    // Neu id khong ton tai <= 0 thi them du lieu moi)
    public function save()
    {
        $result = false;
        if ($this->id_dv > 0) {
            $stmt = $this->db->prepare('update dichvu set ten_dv = :ten_dv,
            email = :email,password = :password, sdt = :sdt, dv_diachi = :dv_diachi ,dv_phuong = :dv_phuong, dv_quan = :dv_quan, dv_tinh = :dv_tinh
			where id_dv = :id_dv');
            $result = $stmt->execute([
                'ten_dv' => $this->ten_dv,
                'email' => $this->email,
                'password' => $this->password,
                'sdt' => $this->sdt,
                'dv_diachi' => $this->dv_diachi,
                'dv_phuong' => $this->dv_phuong,
                'dv_quan' => $this->dv_quan,
                'dv_tinh' => $this->dv_tinh,
                'id_dv' => $this->id_dv
            ]);
        } else {
            $stmt = $this->db->prepare(
                'insert into dichvu (ten_dv,email , password,  sdt, dv_diachi, dv_phuong, dv_quan, dv_tinh, ngaytao)
			values (:ten_dv, :email, :password , :sdt, :dv_diachi, :dv_phuong, :dv_quan, :dv_tinh , now())'
            );
            $result = $stmt->execute([
                'ten_dv' => $this->ten_dv,
                'email' => $this->email,
                'password' => $this->password,
                'sdt' => $this->sdt,
                'dv_diachi' => $this->dv_diachi,
                'dv_phuong' => $this->dv_phuong,
                'dv_quan' => $this->dv_quan,
                'dv_tinh' => $this->dv_tinh


            ]);
            if ($result) {
                $this->id_dv = $this->db->lastInsertId();
            }
        }
        return $result;
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
        $stmt = $this->db->prepare('delete from dichvu where id_dv = :id_dv');
        return $stmt->execute(['id_dv' => $this->id_dv]);
    }



    //Kiem tra dang nhap
    //Ham tra ve so dong sau khi thuc hien cau lenh 
    public function checkpoint($email, $password)
    {
        $sql = "SELECT * from dichvu where email =:e and password =:p";
        $query = $this->db->prepare($sql);
        $query->execute([
            'e' => $email,
            'p' => $password
        ]);
        return $query->rowCount();
        //  return  $query->fetch();
    }
    //Kiem tra dang nhap
    //Ham tra ve mang du lieu email va password
    public function checkpoint2($email, $password)
    {
        $sql = "SELECT * from dichvu where email =:e and password =:p";
        $query = $this->db->prepare($sql);
        $query->execute([
            'e' => $email,
            'p' => $password
        ]);
        // return $row = $query->rowCount();
        return $query->fetch();
    }
}
