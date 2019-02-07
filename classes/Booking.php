<?php

class Booking {

	protected static $table = 'bookings';
	public const UNKNOWN = 0;
	public const CONFIRMED = 1;
	public const CANCELED = 2;
	public $id;
	public $location;
	public $email;
	public $from;
	public $to;
	public $adults;
	public $children;
	public $status;

	public function __construct()
	{
		$this->id = 0;
		$this->location = new Location();
		$this->email = "";
		$this->from = "";
		$this->to = "";
		$this->adults = 1;
		$this->children = 0;
		$this->status = self::UNKNOWN;
	}

	protected function _insert()
	{
		$sql = "INSERT INTO " . self::$table . " (location, email, date_from, date_to, adults, children, status) VALUES (:location, :email, :from, :to, :adults, :children, :status)";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':location', $this->location->id);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':from', $this->from);
		$stmt->bindParam(':to', $this->to);
		$stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
		$stmt->bindParam(':status', $this->status);
		$stmt->execute();
		$this->id = DB::instance()->lastInsertID();
	}

	protected function _update()
	{
		$sql = "UPDATE " . self::$table . " SET location = :location, email = :email, date_from = :from, date_to = :to, adults = :adults, children = :children, status = :status WHERE id = :id";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':location', $this->location->id);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':from', $this->from);
		$stmt->bindParam(':to', $this->to);
		$stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
		$stmt->bindParam(':status', $this->status);
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
		$this->location = Location::getById($row['location']);
		$this->email = $row['email'];
		$this->from = $row['date_from'];
		$this->to = $row['date_to'];
		$this->adults = $row['adults'];
		$this->children = $row['children'];
		$this->status = $row['status'];
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

	public static function getAllByLocation($location)
	{
		$sql = "SELECT * FROM " . self::$table . " WHERE location = :location";
		$stmt = DB::instance()->prepare($sql);
		$stmt->bindParam(':location', $location->id);
		return self::_execute_and_fetch_all($stmt);
	}

	public static function getAllByUser($user)
	{
		$locations = Location::getAllByUser($user);
		$items = [];
		foreach ($locations as $location) {
			$items = array_merge($items, self::getAllByLocation($location));
		}
		return $items;
	}

	public function status_text()
	{
		if ($this->status == self::CONFIRMED) {
			return 'Confirmed';
		} else if ($this->status == self::CANCELED) {
			return 'Canceled';
		} else {
			return 'Pending';
		}
	}

};
