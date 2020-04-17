<?php 

namespace Src\DataBase;

/**
* Class de conexão com banco de dados
* 
* @author Thiage Britto
* @copyright MIT 2020, - Thiage Britto
* @version 1.0
* @package \Src\DataBase\Connect;
*/

abstract class Connect
{
	/** @var \PDO */
	private static $conn;

 	public static function conn()
 	{
		try
		{
			if( empty( Connect::$conn ) || Connect::$conn === NULL )
			{
				Connect::$conn = new \PDO( "mysql: dbname=" . MYDB . "; host=" . HOST, USER, PASS );
				Connect::$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			}
			return Connect::$conn;
		} 
		catch ( \PDOException $e ) 
		{
			return json_encode([
				"message" => $e->getMessage(),
				"code" => $e->getCode(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			]);
		}
	}
}
