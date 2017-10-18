<?php

/*
 * is simple connector helper with few most used functions
 */

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', realpath(dirname(__FILE__)));
}

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/' : 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/';
if (!defined('HOST')) {
    define('HOST', $url);
}
define('DBDEBUG',1);

require_once ROOT.DS.'Library'.DS.'db.php';

$d = new \Library\DB;
        // for sqlite "localhost" can be relaced with path to database
$d->Connect('mysql', 'database', 'root', '8378', 'localhost');

var_dump($d->db); // << PDO Object


$d->createTable('tested', array(
    'name VARCHAR(255)',
    'string VARCHAR(255)'

));

$d->TInsertIF('tested', ['name' => 'info', 'string' => 'text']);
        // same as
$d->Begin();
$d->InsertIF('tested', ['name' => 'info', 'string' => 'text']);
$d->Commit(); // or $d->Rollback(); on error

$a = $d->db->query('SELECT * FROM tested'); // call PDO fn
var_dump($a);

$d->Tupdate('tested', ['string' => 'changed'], 'where name=?', ['info']);

$d->Tinsertupdate('tested', ['string' => 'other'], 'where name=?', ['none']); // insert if not found or update exists

$q = $d->Select('tested', ['*'], 'WHERE name = ?', ['info']);

var_dump($q);

$d->Query('SELECT * FROM tested'); // like prepare, exec is shotrcut to PDO fn

$d->dropTable('tested');
?> 