<?php

/**
 *
 */

class DBConnect {
	public $db;
	
	final public function Connect($engin, $database, $host = 'localhost', $user = NULL, $pass = NULL) {
		try {
			if ($engin == 'posql') {
				require_once ROOT.VENDORS.'posql.php';
				$database_name = ROOT.DATA.'database'.DS.$database . '.db';
				//echo $database_name;
				if (!file_exists($database_name.'.php')) {
					throw new SystemException('Database not exist.',420404);
				}
				// try connect
				//$sql = SQL;
				
				$this->db = new Posql($database_name);
				//$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				if ($this->db -> isError()) {
					abort($this->db);
					throw new SystemException('Can\'t connect to Database.',420502);
				}

			}

			if ($engin == 'sqlite') {
			try {
				
				$database_name = ROOT.DATA.'database'.DS. $database . '.db';
				$this->db = new PDO($engin.':'. $database_name);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch (PDOException $e){
    			//handle PDO
    			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
			if ($engin != 'posql' && $engin != 'sqlite') {
			try {
				if ($user === NULL || $pass === NULL) {
					throw new SystemException('User and Password not filed.');
				}
				$this->db = new PDO($engin.':host=' . $host . ';dbname=' . $database, $user, $pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch (PDOException $e){
    			//handle PDO
    			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
		} catch (SystemException $e) {
			return FALSE;
		}

	}

	public function __destruct() {
		$this->db = NULL;
		unset($this->db);
	}

}
?>