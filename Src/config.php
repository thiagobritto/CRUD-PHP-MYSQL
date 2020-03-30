<?php

/* Session init */
session_start();

/* Const database config */
define( "MYDB", "test" );
define( "HOST", "localhost" );
define( "USER", "root" );
define( "PASS", "" );

/* Definindo chaver de criptografia */
define( 'SECERT_IV', pack( 'a16', 'exemplo-1' ) );
define( 'SECERT',		 pack( 'a16', 'ezemplo-2' ) );

/* Const separador de diretorio */
define( "DS", DIRECTORY_SEPARATOR );

/* Raiz do servidor ex: 'C:/xampp/htdocs/site' */ 
define( 'ROOT', $_SERVER['DOCUMENT_ROOT'] );

/* Seu Dominio ex: 'http://localhost.com' */ 
define( 'SITE', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'] );

/* Functions para tratamento de errors */
function error_handler( $code, $message, $file, $line )
{
	echo json_encode([
		"code" => $code,
		"message" => $message,
		"line" => $line,
		"file" => $file
	]);
}
set_error_handler( "error_handler" );
error_reporting( E_ALL & ~E_NOTICE );

/* Autoload psr-4 composer */
//require_once ROOT . '/vendor/autoload.php';

/* Autoload psr-4 composer */
spl_autoload_register( function( $myClass ){
	$path = './' . $myClass . '.php';
	if( file_exists( $path ) )
	{
		require_once $path;
	}
});