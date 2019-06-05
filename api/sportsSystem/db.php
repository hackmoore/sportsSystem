<?php
	namespace sportsSystem;

	class db{
		// Hold the class instance.
		private static $instance = null;
		private static $db;

		// The constructor is private
		// to prevent initiation with outer code.
		private function __construct(){
			static::$db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_DBSE);
		}

		// The object is created from within the class itself
		// only if the class has no instance.
		public static function getInstance(){
			if (self::$instance == null){
				self::$instance = new db();
			}
			return self::$instance;
		}

		private static function runQuery(String $sql, array $params){
			static::getInstance();

			// Safety first!
			foreach($params as $i=>$v)
				$params[$i] = static::$db->escape_string($v);

			$query = vsprintf($sql, $params);
			$result = static::$db->query($query);

			$rtn = [];
			while($row = $result->fetch_assoc())
				array_push($rtn, $row);
			return $rtn;
		}


		public static function authenticate(String $username, String $password){
			$matches = static::runQuery(
				"SELECT id, username, firstname, lastname FROM users WHERE username = '%s' AND password = '%s';",
				[$username, $password]
			);
			
			if( count($matches) === 0 )
				return false;
			else
				return $matches[0];
		}
	}