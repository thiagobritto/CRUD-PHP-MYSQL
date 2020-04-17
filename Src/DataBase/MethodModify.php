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
	/** @var array */
	private $params=[];

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
	} 

	protected function setData( array $dataQuery )
	{
		foreach ( $dataQuery as $colum => $value )
		{
			$this->{ "set" . $colum }( $value );
		}
	} 

	public function getData( int $opt=\PDO::FETCH_ASSOC )
	{
		if ( $opt === \PDO::FETCH_OBJ )
		{
			return ( object ) $this->params;

		} elseif ( $opt === \PDO::FETCH_ASSOC ){

			return ( array ) $this->params;
		}
	} 
} 
