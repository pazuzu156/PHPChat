<?php namespace Core;

use \PDO;
use \PDOException;

class Database
{
	/**
	 * Database instance
	 * 
	 * @var \Core\Database
	 */
	private static $_instance = null;
	
	/**
	 * PDO instance
	 *
	 * @var \PDO
	 */
	private $_pdo;
	
	/**
	 * PDO Query
	 *
	 * @var mixed
	 */
	private $_query;
	
	/**
	 * Query errors
	 *
	 * @var boolean
	 */
	private $_error = false;
	
	/**
	 * Query results
	 *
	 * @var 
	 */
	private $_results;
	
	/**
	 * Result count
	 *
	 * @var integer
	 */
	private $_count = 0;
	
	/**
	 * Config instance
	 * 
	 * @var \Core\Config
	 */
	private $_config;
	
	private function __construct()
	{
		$this->_config = Config::from('database');
		try
		{
			$this->_pdo = new PDO("mysql:host={$this->_config->get('hostname')};dbname={$this->_config->get('database')}",
				$this->_config->get('user'), $this->_config->get('password'));
		}
		catch(PDOException $ex)
		{
			throw new \Exception($ex->getMessage());
		}
	}
	
	/**
	 * Initializes new DB class and DB connection
	 * 
	 * @return \Core\Database
	 */
	public static function init()
	{
		if(!isset(self::$_instance))
			self::$_instance = new Database;
		
		return self::$_instance;
	}
	
	/**
	 * Performs PDO query
	 * 
	 * @param string $sql
	 * @param array $params
	 * @return \Core\Database
	 */
	public function query($sql, $params=array())
	{
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql))
		{
			if(count($params))
			{
				$x = 1;
				foreach($params as $param)
				{
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			
			if($this->_query->execute())
			{
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}
			else
			{
				$this->_error = true;
			}
		}
		
		return $this;
	}
	
	/**
	 * Performs an action
	 * 
	 * @param string $action
	 * @param string $table
	 * @param array $where
	 * @return mixed
	 */
	public function action($action, $table, $where=array(), $order='ASC')
	{
		if(count($where) === 3)
		{
			$operators = array('=', '>', '<', '>=', '<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators))
			{
				$sql = "$action FROM $table WHERE $field $operator ? ORDER BY id $order";
				if(!$this->query($sql, array($value))->error())
				{
					return $this;
				}
			}
		}
		else
		{
			$sql = "$action FROM $table ORDER BY id $order";
			if(!$this->query($sql)->error())
				return $this;
		}
		
		return false;
	}
	
	/**
	 * Deletes row from the table
	 * 
	 * @param string $table
	 * @param string $where
	 * @return \Core\Database
	 */
	public function delete($table, $where)
	{
		return $this->action("DELETE ", $table, $where);
	}

	public function get($table, $where=array())
	{
		return $this->action("SELECT * ", $table, $where);
	}
	
	/**
	 * Insers a row into the table
	 * 
	 * @param string $table
	 * @param array $fields
	 * @return boolean
	 */
	public function insert($table, $fields=array())
	{
		if(count($fields))
		{
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			
			foreach($fields as $field)
			{
				$values .= "?";
				if($x < count($fields))
				{
					$values .= ', ';
				}
				$x++;
			}
			
			$sql = "INSERT INTO $table (`".implode('`, `', $keys)."`) VALUES ($values)";
			
			if(!$this->query($sql, $fields)->error())
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Updates a row in the table
	 * 
	 * @param string $table
	 * @param string $id
	 * @param array $fields
	 * @return boolean
	 */
	public function update($table, $id, $fields)
	{
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value)
		{
			$set .= "$name = ?";
			if($x < count($fields))
			{
				$set .= ', ';
			}
			$x++;
		}
		
		$sql = "UPDATE $table SET $set WHERE id = $id";
		
		if(!$this->query($sql, $fields)->error())
		{
			return true;
		}
		
		return false;
	}

	public function truncate($table)
	{
		$sql = "TRUNCATE TABLE $table";

		if(!$this->query($sql)->error())
		{
			return true;
		}

		return false;
	}
	
	/**
	 * Gets the row count
	 * 
	 * @return integer
	 */
	public function count()
	{
		return $this->_count;
	}
	
	/**
	 * Gets the results
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function results($index = '')
	{
		if(is_numeric($index))
			return $this->_results[$index];
		else
			return $this->_results;
	}
	
	/**
	 * Gets the first result
	 * 
	 * @return mixed
	 */
	public function first()
	{
		return $this->results(0);
	}
	
	/**
	 * Returns DB error
	 * 
	 * @return boolean
	 */
	public function error()
	{
		return $this->_error;
	}
}