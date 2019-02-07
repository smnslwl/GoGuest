<?php

class Location {

	protected static $table = 'locations';
	public $id;
	public $user;
	public $name;
	public $latitude;
	public $longitude;
	public $price;
	public $description;

	public function __construct()
	{
		$this->id = 0;
		$this->user = new User();
		$this->name = "";
		$this->latitude = 27.700769;
		$this->longitude = 85.300140;
		$this->price = 0;
		$this->description = "";
	}

	protected function _insert()
	{
		$sql = "INSERT INTO " . self::$table . " (user, name, latitude, longitude, price, description) VALUES (:user, :name, :latitude, :longitude, :price, :description)";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':user', $this->user->id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':latitude', $this->latitude);
		$stmt->bindParam(':longitude', $this->longitude);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->execute();
		$this->id = DB::instance()->lastInsertID();
	}

	protected function _update()
	{
		$sql = "UPDATE " . self::$table . " SET user = :user, name = :name, latitude = :latitude, longitude = :longitude, price = :price, description = :description WHERE id = :id";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':user', $this->user->id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':latitude', $this->latitude);
		$stmt->bindParam(':longitude', $this->longitude);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
	}

	public function save()
	{
		if ($this->id == 0) {
			$this->_insert();
		} else {
			$this->_update();
		}
	}

	public function remove()
	{
		if ($this->id != 0) {
			$sql = "DELETE FROM " . self::$table . " WHERE id = :id";
			$stmt = DB::instance()->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			$stmt->execute();
		}
	}

	public function fill($row)
	{
		$this->id = $row['id'];
		$this->user = User::getById($row['user']);
		$this->name = $row['name'];
		$this->latitude = $row['latitude'];
		$this->longitude = $row['longitude'];
		$this->price = $row['price'];
		$this->description = $row['description'];
	}

	protected static function _execute_and_fetch($stmt)
	{
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$item = new self;
		if (!empty($rows)) {
			$item->fill($rows[0]);
		}
		return $item;
	}

	protected static function _execute_and_fetch_all($stmt)
	{
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$items = [];
		foreach ($rows as $row) {
			$item = new self;
			$item->fill($row);
			$items[] = $item;
		}
		return $items;
	}

	public static function getById($id)
	{
		$sql = "SELECT * FROM " . self::$table . " WHERE id = :id";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':id', $id);
		return self::_execute_and_fetch($stmt);
	}

	public static function getAll()
	{
		$sql = "SELECT * FROM " . self::$table;
		$stmt = DB::instance()->prepare($sql);
		return self::_execute_and_fetch_all($stmt);
	}

	public static function getAllByUser($user)
	{
		$sql = "SELECT * FROM " . self::$table . " WHERE user = :user";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':user', $user->id);
		return self::_execute_and_fetch_all($stmt);
	}

};
