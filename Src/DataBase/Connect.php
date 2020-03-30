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
	
 /**
	* Propriedade $conn, guarda 
	* a conexão com banco
	* 
	* @access private
	* @var @static Connect::$conn
	*/

	private static $conn;

 /** 
  * Função para conectar com banco da dados
  * 
  * @access public
  * @return object
  */

	public static function conn()
	{
		try {
			if( empty( Connect::$conn ) || Connect::$conn === NULL ) {
				Connect::$conn = new \PDO( "mysql: dbname=" . MYDB . "; host=" . HOST, USER, PASS );
				Connect::$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			}
			return Connect::$conn;
		} catch ( \PDOException $e ) {

			echo json_encode([
				"message" => $e->getMessage(),
				"code" => $e->getCode(),
				"file" => $e->getFile(),
				"line" => $e->getLine()
			]);

		}
	} // end conn()
} // end class Connect
