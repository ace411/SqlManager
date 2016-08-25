<?php

use SqlManager\SqlManager;

require __DIR__ . '/../vendor/autoload.php';

$conn_params = [
	'db_user' => 'bots',
	'db_pass' => 'QW6XALwnpP6ZwNvG',
	'db_host' => 'localhost',
	'db_name' => 'bots'
];

$db = SqlManager::establishConnection('mysql', $conn_params);

$db->sqlQuery("
	SELECT *
	FROM blog
");
$db->executeQuery();
$data = $db->resultSet();