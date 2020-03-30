<?php 

namespace Src\DataBase;

/**
 * abstract Class MethodModify 
 * gerencias os setting and gettings
 * 
 * @author Thiago Britto
 * @copyright MIT 2020, Thiago Britto
 * @version 1.0
 * @package \Src\DataBase\MethodModify;
 */

abstract class MethodModify
{
 /**
  * Guarda dados de yabelas do 
  * banco de forma privada
  * 
  * @access private
	* @var array $params
	*/

	private $params=[];

 /**
  * Função especial do PHP 
  * 
  * @access public
  * @param string $name, array $params
	* @return mixed
	*/

	public function __call( string $name, array $params )
	{
		$action = substr( trim( $name ) , 0, 3 );
		$actionName = substr( trim( $name ) , 3, strlen( $name ) );
		switch ( $action )
		{
			case 'set':
				$this->params[$actionName] = $params[0];
				break;
			case 'get':
				return $this->params[$actionName] ?? [];
				break;
			default:
				return [];
				break;
		}
	} // end __call()

 /**
  * A Função recebe dados em foma de aray para 
  * serem tratados pela function __call()  
  * 
  * @access protected
  * @param array $params
	* @return void
	*/

	protected function setData( array $params )
	{
		foreach ( $params as $key => $value )
		{
			$this->{ "set" . $key }( $value );
		}
	} // end setData()

 /**
  * A Função retorna os dados 
  * já encapsulados pela classe  
  * 
  * @access public
  * @param int $opt
	* @return array/object
	*/

	public function getAll( int $opt=\PDO::FETCH_ASSOC )
	{
		if( $opt === \PDO::FETCH_OBJ )
		{
			return ( object ) $this->params;
		} elseif ( $opt === \PDO::FETCH_ASSOC ) {
			return ( array ) $this->params;
		}

	} // end getAll()

 /**
  * Função agrega funcionalidades 
  * a Sql::query()
  * 
  * @access protected
  * @param string $query, array $params
	* @return boolean
	*/

	protected function setParams( object $stmt, array $params )
	{
		if( $params && !empty($params) && isset($params) )
		{
			foreach ( $params as $key => $value ) 
			{
				$stmt->bindValue( $key, $value, \PDO::PARAM_STR );
			}
			return $stmt->execute();
		} else {
			return false;
		}
	} // end setParams()

	/**
  * Função agrega funcionalidades 
  * a Sql::query()
	* 
  * @access protected
  * @param string $query
	* @return boolean
	*/

	protected function queryVerify( string $query )
	{
		if( strripos( $query, 'PDATE' ) || strripos( $query, 'ELETE' ) )
		{
			if( !strripos( $query, 'WHERE' ) )
			{
				throw new \Exception("Error em: '{$query}', sentimos a falta de um 'WHERE'", 0);
				return false;
				exit;
			}
		}
	} // end qheryVerify()

} // end class MethodModify
