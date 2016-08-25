# SqlManager
Simple PDO connection class for PHP

##Requirements

-PHP 5.5 or higher

-MySQL or SQLite

##Description

PDO is a convenient way to access databases in PHP and has support for popular databases. This simple package harnesses PDO capabilities
to simplify database interactions.

##Samples

__Simple select query__

```php
use SqlManager\SqlManager;

require __DIR__ . '/../vendor/autoload.php';

//set the required connection parameters
$conn_params = [
	'db_user' => 'chemem',
	'db_pass' => '4QeDMG1XY',
	'db_host' => 'localhost',
	'db_name' => 'sql_manager'
];

//connect to a mysql database
$db = SqlManager::establishConnection('mysql', $conn_params);

//sql SELECT query
$db->sqlQuery("
	SELECT *
	FROM sql_entries
");
$db->executeQuery();
//results of the query returned as an associative array
$data = $db->resultSet();

```

Please check out the tests directory for more code samples

##Dealing with problems

Endeavor to create an issue on GitHub when the need arises or send an email to lochbm@gmail.com
