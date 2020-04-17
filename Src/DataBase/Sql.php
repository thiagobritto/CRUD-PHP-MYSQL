<?php 

namespace Src\DataBase;

/**
* Class para consulta ao banco de dados
* 
* @author Thiago Britto
* @copyright MIT 2020, Thiago Britto
* @version 1.2
* @package \Src\DataBase\Sql;
*/

class Sql extends MethodModify
{
	/** @var \PDO */
	private $conn;
	/** @var \PDOStatiment */
	private $stmt;
	/** @var string */
	private $fetch = 'fetch';

	public function __construct()
	{
		$this->conn = Connect::conn();
	}

	private function setQuery( string $querySql )
	{
		$this->stmt = $this->conn->prepare( $querySql );
	}

	private function setDataKeyValue( array $dataKeyValue )
	{
		foreach ( $dataKeyValue as $key => $value ) 
		{
			$this->stmt->bindValue( $key, $value );
		}
	}

	private function verifyQuerySql( string $querySql )
	{
		if ( !preg_match( '/WHERE/i',  $querySql ) )
		{
			if ( !preg_match( '/INTO/i',  $querySql ) )
			{
				throw new \Exception("Error statement not found, WHERE or INTO");
				return false;
				exit;
			}
		}
	}

	public function select( string $querySql, array $dataKeyValue=[] )
	{
		$this->setQuery( $querySql );
		$this->setDataKeyValue( $dataKeyValue );
		$this->stmt->execute();
		$this->setData( $this->stmt->{$this->fetch}( \PDO::FETCH_ASSOC ) );
	}

	public function selectAll( string $querySql, array $dataKeyValue=[] )
	{
		$this->fetch = "fetchAll";
		$this->select( $querySql, $dataKeyValue );
	}

	public function query( string $querySql, array $dataKeyValue )
	{
		$this->verifyQuerySql( $querySql );
		$this->setQuery( $querySql );
		$this->setDataKeyValue( $dataKeyValue );
		$this->stmt->execute();
		return $this->stmt->rowCount();
	}
}
