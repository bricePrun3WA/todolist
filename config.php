<?php
	$pdoHost = 'host=localhost';
	$pdoDb = 'dbname=todolist';
	$pdoUser = 'root';
	$pdoPwd = '';
	
	$db = new PDO(
		'mysql:'.$pdoHost
		.';'.$pdoDb,
		$pdoUser,
		$pdoPwd
	);
?>