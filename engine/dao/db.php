<?php

/**
 * Class DB_DB главный клас для соединения с базой
 */
class DAO_DB{
	/**
	 * @var PDO екземпляр
	 */
	protected $db;
	/**
	 * @var null или екземпляр себя
	 */
	private static $init = null;

	/**
	 * DAO_DB constructor.
	 * Подключаемся к базе с помощью PDO
	 */
	private function __construct(){
		$str = 'mysql:host='.Config::$DB['host'].';dbname='.Config::$DB['dbname'];
		$this->db = new PDO($str, Config::$DB['user'], Config::$DB['pass']);
	}

	/**
	 * Запрещаем клонирование
	 */
	private function __clone(){}

	/**
	 * @return DAO_DB singleton
	 */
	public static function init(){
		if (self::$init == null){
			self::$init = new self();
		}

		return self::$init;
	}

	public function getDB(){
		return $this->db;
	}

	/**
	 * @param string $str строка запроса на выборку даных
	 * @return array все строки по запросу(асоциативный масив)
	 */
	public function selectRows($str){
		return $this->db->query($str)->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param string $str строка запроса на выборку даных
	 * @return array массив из полей строки (асоциативный масив)
	 */
	public function selectOneRow($str){
		return $this->db->query($str)->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @param string $str строка запроса на выборку даных
	 * @param string $field поле которое надо получить
	 * @return string значение поля
	 */
	public function selectField($str, $field){
		$result = $this->selectOneRow($str);

		return $result[$field];
	}

	/**
	 * @param string $str запрос на добавление в бд
	 * @return int ид последней вставленой строки
	 */
	public function insert($str){
		$this->db->exec($str);

		return $this->db->lastInsertId();
	}

	/**
	 * @param string $str запрос на обновление данных
	 * @return int количество обновленных строк
	 */
	public function update($str){
		return $this->db->exec($str);
	}

	/**
	 * @param string $str запрос на удаление данных
	 * @return int количество затронутых строк
	 */
	public function delete($str){
		return $this->db->exec($str);
	}
}