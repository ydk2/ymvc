<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Connector for databases PoSQL, SQLite , MySQL using PDO.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC, Database
 * @package    YMVC System
 * @subpackage DBConnect
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.11.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 1.0.0
 
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
			if ($engin == 'sqlsrv') {
			try {
				if ($user === NULL || $pass === NULL) {
					throw new SystemException('User and Password not filed.');
				}
				$this->db = new PDO($engin.':Server=' . $host . ';dbname=' . $database, $user, $pass);
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
			
			if ($engin != 'posql' && $engin != 'sqlite' && $engin != 'sqlsrv') {
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