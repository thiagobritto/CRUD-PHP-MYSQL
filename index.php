<?php 

use \Src\DataBase\Sql;

require_once './Src/config.php';

$sql = new Sql;

$sql->selectAll('SELECT * FROM test.incidents');

var_dump($sql->getAll());