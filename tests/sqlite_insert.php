<?php

use SqlManager\SqlManager;

require __DIR__ . '/../vendor/autoload.php';

//connection parameters for sqlite connection
$conn_params = [
	'db_user' => 'bots',
	'db_pass' => 'QW6XALwnpP6ZwNvG',
	'file' => 'bots_PDO.sqlite'
];

//blog data to be entered into the database
$blog_data = [
	'title' => 'Article title',
	'snippet' => 'An interesting article teaser',
	'blog_text' => 'Some text to describe the title'
];

//connect to a sqlite database
$db = SqlManager::establishConnection('sqlite', $conn_params);

//SQL insert query
$db->sqlQuery("
	INSERT INTO blog (blog_title, blog_snippet, blog_text)
	VALUES (:title, :snippet, :blog_text)
");
//bind placeholder values in query to their actual data values
$db->paramBind(':title', $blog_data['title']);
$db->paramBind(':snippet', $blog_data['snippet']);
$db->paramBind(':blog_text', $blog_data['blog_text']);
$db->executeQuery();
//convey the last inserted ID to check query success
print($db->lastId());
