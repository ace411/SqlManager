<?php

/**
 * Simple PDO connection class for PHP
 * Supports mysql and sqlite
 *
 * @package SqlManager
 * @author Lochemem Bruno Michael
 * @link https://github.com/ace411/SqlManager
 * 
 */

namespace SqlManager;

use PDO;

class SqlManager
{
	private $username; 
	private $password; 
	private $host; 
	private $dbname;
	private $db_details;
	private $db;
	private $stmt;
	private $conn_stmt;
	private static $instance = null;

	private function __construct($database, $params)
	{
		if(!is_array($params)){
			throw new Exception("Please specify an array");
		}else {
			switch($database){
				case 'mysql':
					$this->db_type = 'mysql';
					$this->username = $params['db_user'];
					$this->password = $params['db_pass'];
					$this->host = $params['db_host'];
					$this->dbname = $params['db_name'];
					$this->conn_stmt = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";	
					break;

				case 'sqlite':
					$this->db_type = 'sqlite';
					$this->username = $params['db_user'];
					$this->password = $params['db_pass'];
					$this->db_details = $params['file'];
					$this->conn_stmt = "sqlite:{$this->db_details}";
					break;

				default:
					throw new Exception("Database not supported");
					break;		
			}
		}
	}

	private function connectToSql()
	{
		$options = array(
		        	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', 
		        	PDO::ATTR_PERSISTENT => true
	    	);
		try {
			$this->db = new PDO($this->conn_stmt,	$this->username, $this->password, $options); 
		}catch(PDOException $ex){
		    throw new Exception("Cannot connect to the SQL database");
		}
	}

	public static function establishConnection($database, $params)
	{
		if(self::$instance === null){
			self::$instance = new SqlManager($database, $params);
			self::$instance->connectToSql();
		}
		return self::$instance;
	}

	public function __clone()
	{
		throw new Exception("You cannot clone this class");
	}

	public function __wakeup()
	{
		
	}

	public function showDrivers()
	{
		return PDO::getAvailableDrivers();
	}

	public function sqlQuery($query)
	{
		$this->stmt = $this->db->prepare($query);
	}

	public function paramBind($param, $value, $type=null)
	{
		if (is_null($type)) {
			switch (true) {
			    case is_int($value):
			        $type = PDO::PARAM_INT;
			        break;
			    case is_bool($value):
			        $type = PDO::PARAM_BOOL;
			        break;
			    case is_null($value):
			        $type = PDO::PARAM_NULL;
			        break;
			    default:
			        $type = PDO::PARAM_STR;
			}
	    }
	    $this->stmt->bindValue($param, $value, $type);
	}

	public function executeQuery()
	{
		return $this->stmt->execute();
	}

	public function resultSet()
	{
		$this->stmt->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function singleResult()
	{
		$this->stmt->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function singleRow()
	{
		$this->stmt->execute();
		return $this->stmt->fetch();
	}
	
	public function beginTransaction()
	{    
	    return $this->db->beginTransaction();
	}

	public function verifyTransaction()
	{
		return $this->db->inTransaction();
	}

	public function endTransaction()
	{	    
	    return $this->db->commit();
	}

	public function checkTransaction()
	{
		if(PDO::inTransaction() === true){
			return "In transaction";
		}else {
			return 'Not in transaction';
		}
	}

	public function cancelTransaction()
	{	    
	    return $this->db->rollBack();
	}

	public function debugDumpParams()
	{	    
	    return $this->stmt->debugDumpParams();
	}

	public function totalRows()
	{
		return $this->stmt->rowCount();
	}

	public function singleColumn()
	{
		return $this->stmt->fetchColumn();
	}

	public function lastId()
	{
		return $this->stmt->lastInsertId();
	}
}
