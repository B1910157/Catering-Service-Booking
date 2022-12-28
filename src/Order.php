<?php

namespace CT275\Project;

class Order
{
	private $db;

	private $id = -1;
	public $userID;
	public $cart_id;
	public $status;
	public $total_price;
	public $created_day;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function insertOrder(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->insertOrder2();
		} return false;
	}
	///Them san pham vao gio hang
	public function insertOrder2(){
		$total_price = 0;
		$result = $this->db->prepare('select gh.*,ctgh.quantity,sp.price from giohang gh inner join chitietgiohang ctgh on gh.cart_id = ctgh.cart_id inner join sanpham sp on ctgh.product_id = sp.id where gh.cart_id = :cart_id');
		$result->execute(['cart_id' => $this->cart_id]);
		// $cart = $result->fetch();
		foreach ($result as $cart) {
			$total_price = $total_price + $cart['quantity']*$cart['price'];
			// echo $total_price;
			// print_r($cart);
		}
		$stmt = $this->db->prepare(
		'insert into donhang (user_id, cart_id, total_price, status, created_day)
		values (:user_id, :cart_id, :total_price, 0, now())');
		$order = $stmt->execute([
		'user_id' => $this->userID,
		'cart_id' => $this->cart_id,
		'total_price' => $total_price
		]);
		$sql = $this->db->prepare('delete from chitietgiohang where cart_id = :cart_id');
		$delcart = $sql->execute(['cart_id' => $this->cart_id]);
		$sql = $this->db->prepare('delete from giohang where cart_id = :cart_id');
		$delcart2 = $sql->execute(['cart_id' => $this->cart_id]);
		if ($order) {
			$this->id = $this->db->lastInsertId();
		}
	return $order;
	}

	//tim don dat hang cua 1 user dua tren usser_id
	public function getOrders($id){
		$orders = [];
		$stmt = $this->db->prepare('select * from donhang where user_id = :id');
		$stmt->execute(['id' => $id]);
		while ($row = $stmt->fetch()) {
			$order = new Order($this->db);
			$order->fillFromDB($row);
			$orders[] = $order;
		} return $orders;
	}

	

	public function all(){
		$orders = [];
		$stmt = $this->db->prepare('select * from donhang order by order_id desc');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$order = new Order($this->db);
			$order->fillFromDB($row);
			$orders[] = $order;
		} return $orders;
	}

	
	//Lay du lieu tu input de dua vao  csdl
	public function fill(array $data)
	{
		if (isset($data['userID'])) {
			$this->userID = trim($data['userID']);
		}

		if (isset($data['cart_id'])) {
			$this->cart_id = trim($data['cart_id']);
		}

		if (isset($data['status'])) {
			$this->status = trim($data['status']);
		}

		if (isset($data['total_price'])) {
			$this->total_price = trim($data['total_price']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->userID) {
			$this->errors['userID'] = 'ID người dùng không hợp lệ.';
		}

		if (!$this->cart_id) {
			$this->errors['cart_id'] = 'ID giỏ hàng không hợp lệ.';
		}

		if ($this->status < 0) {
			$this->errors['status'] = 'Trạng thái không hợp lệ.';
		}

		if ($this->total_price < 0) {
			$this->errors['total_price'] = 'Tổng tiền không hợp lệ.';
		}

		return empty($this->errors);
	}
	
	//Lay du lieu ti csdl
	protected function fillFromDB(array $row)
	{
		[
		'order_id' => $this->id,
		'user_id' => $this->userID,
		'cart_id' => $this->cart_id,
		'status' => $this->status,
		'total_price' => $this->total_price,
		'created_day' => $this->created_day
		] = $row;
		return $this;
	}
 //Update orr insert
	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update donhang set status = 1
			where order_id = :order_id');
			$result = $stmt->execute([
			'order_id' => $this->id]);
		} else {
			$stmt = $this->db->prepare(
			'insert into donhang (user_id, cart_id, total_price, status, added_day, updated_day)
			values (:user_id, :cart_id, :total_price, 0, now(), now())');
			$result = $stmt->execute([
			'user_id' => $this->userID,
			'cart_id' => $this->cart_id,
			'total_price' => $this->total_price]);
			if ($result) {
				$this->id = $this->db->lastInsertId();
			}
		} return $result;
	}
//search  dua tren user_id
	public function find($id)
	{
		$orders = [];
		$stmt = $this->db->prepare('select * from donhang where user_id = :id');
		$stmt->execute(['id' => $id]);
		while ($row = $stmt->fetch()) {
			$order = new Order($this->db);
			$order->fillFromDB($row);
			$orders[] = $order;
		} return $orders;
	} 
//Tim kiem dua tren order_id
	public function find2($id)
	{
		$stmt = $this->db->prepare('select * from donhang where order_id = :id');
		$stmt->execute(['id' => $id]);
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
		} return false;
	}

	
}
