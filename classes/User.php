<?php

// User model
class User {

	protected static $table = 'users';
	public $id;
	public $username;
	public $password;

	public function __construct()
	{
		$this->id = 0;
		$this->username = "";
		$this->password = "";
	}

	protected function _insert()
	{
		$sql = "INSERT INTO " . self::$table . " (username, password) VALUES (:username, :password)";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
		$stmt->execute();
		$this->id = DB::instance()->lastInsertID();
	}

	protected function _update()
	{
		$sql = "UPDATE " . self::$table . " SET username = :username, password = :password WHERE id = :id";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
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
		$this->username = $row['username'];
		$this->password = $row['password'];
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

	public static function getByUsername($username)
	{
		$sql = "SELECT * FROM " . self::$table . " WHERE username = :username";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':username', $username);
		return self::_execute_and_fetch($stmt);
	}

	public static function getAll()
	{
		$sql = "SELECT * FROM " . self::$table;
		$stmt = DB::instance()->prepare($sql);
		return self::_execute_and_fetch_all($stmt);
	}

};
