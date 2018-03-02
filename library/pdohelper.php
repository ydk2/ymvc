<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   Framework, Database
 * @package    PDOHelper
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.12.0
 * @link       http://www.ydk2.tk
 * @since      File available since Release 1.2.0

 */

namespace Library;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOTDB')) {
    define('ROOTDB', realpath(dirname(__FILE__)));
}

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/' : 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/';
if (!defined('HOST')) {
    define('HOST', $url);
}

class PDOHelper
{
    /**
     * \PDO Object
     * 
     * @var \PDO DB
     */
    public $pdo;
    public $data;
    public $sql;
    public $plugin;
    /**
     * DB Connector
     *
     * @param string $engin
     * @param string $database
     * @param string $host
     * @param string $user
     * @param string $pass
     * @return void
     */
    
    final public function dump($var){
        ob_start();
        var_dump($var);
        return ob_get_clean();
    }

    /**
     * Inc
     * @param mixed $class 
     * @return mixed 
     */
    function Inc($class)
    {
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOTDB . $class));
        if (file_exists($filename) && is_file($filename)) {
            require_once ($filename);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Sql
     * @param mixed ... 
     * @return mixed 
     */
    public function Sql()
    {
        try {
            $args = func_get_args();
            $fn = array_shift($args);
            $sql = $this->plugin->sql[$fn];
            return ($sql)?call_user_func_array([$this->plugin,$fn],$args):NULL;
        } catch(PDOHelperException $e){
            return NULL;
        }
    }

    /**
     * Connect
     * @param mixed $engin 
     * @param mixed $database 
     * @param mixed $user 
     * @param mixed $pass 
     * @param mixed $host 
     * @return mixed 
     */
    final public function Connect($engin, $database, $user = NULL, $pass = NULL, $host = 'localhost')
    {
        try {
            $this->Inc('/PDOHelperException.php');
            $this->data = array('type' => $engin, 'database' => $database, 'host' => $host, 'user' => $user, 'pass' => $pass);

            if ($engin !== NULL) {
                if ($this->Inc('/PDOHelper/' . $engin . ".php")) {
                    $this->plugin = new $engin($this->data);
                    $this->pdo = $this->plugin->pdo;
                }
                elseif ($this->Inc('/DBplugins/defaultDBplugin.php')) {
                    $this->plugin = new defaultDBplugin($this->data);
                    $this->pdo = $this->plugin->pdo;
                }
                else {
                    throw new PDOHelperException("Plugin was not loaded", 203346);
                }
            }
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }

    }
    /**
     * \PDO Begin transaction
     *
     * @return void
     */
    public function dobegin()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * \PDO Commit transaction
     *
     * @return void
     */
    public function docommit()
    {
        return $this->pdo->commit();
    }

    /**
     * \PDO Rollback transaction
     *
     * @return void
     */
    public function dorollback()
    {
        return $this->pdo->rollback();
    }
    /**
     * \PDO Quote
     * 
     * @param string $string
     * @return string
     */
    public function quote($string)
    {
        return $this->pdo->quote($string);
    }
    /**
     * DB Lock
     * 
     * @param string $name
     * @param string $which can be WRITE or READ
     * @return void
     */
    public function Lock($name, $which = 'WRITE')
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name, $which));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * DB UnLock
     * 
     * @param string $name
     * @return void
     */
    public function UnLock($name)
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    public function Columns($table)
    {
        try {
            $rows = $this->Query($this->plugin->Sql(__FUNCTION__, $table));
            $data = array();
            if ($rows) {
                reset($rows);
                $keyname = $this->plugin->Sql(__FUNCTION__.'_data');
                while(list($key, $value) = each($rows)) {
                    array_push($data,$value[$keyname]);
                }
            }
            return $data;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * isLock
     * @param mixed $name 
     * @return mixed 
     */
    public function isLock($name)
    {
        try {
            $query = $this->pdo->query($this->plugin->Sql(__FUNCTION__, $name));
            $rows = $query->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * SBegin
     * @param mixed $name 
     * @return mixed 
     */
    public function SBegin($name = 'T1')
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * SCommit
     * @param mixed $name 
     * @return mixed 
     */
    public function SCommit($name = 'T1')
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * SRelease
     * @param mixed $name 
     * @return mixed 
     */
    public function SRelease($name = 'T1')
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * SRollback
     * @param mixed $name 
     * @return mixed 
     */
    public function SRollback($name = 'T1')
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $name));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Begin
     * @return mixed 
     */
    public function Begin()
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * Commit
     * @return mixed 
     */
    public function Commit()
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }
    /**
     * Release
     * @return mixed 
     */
    public function Release()
    {
        try {
            //$add = $this -> db -> exec($this->plugin->Sql(__FUNCTION__));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Rollback
     * @return mixed 
     */
    public function Rollback()
    {
        try {
            $add = $this->pdo->exec($this->plugin->Sql(__FUNCTION__));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Query
     * @param mixed $sql 
     * @return mixed 
     */
    public function Query($sql)
    {
        try {
            $query = $this->pdo->query($sql);
            $rows = $query->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Prepare
     * @param mixed $sql 
     * @param mixed $values 
     * @return mixed 
     */
    public function Prepare($sql, $values = array())
    {
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute($values);
            $rows = $query->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }	// end get pages
            return false;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Exec
     * @param mixed $sql 
     * @return mixed 
     */
    public function Exec($sql)
    {
        try {
            $chk = $this->pdo->exec($sql);
            return $chk;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * createTable
     * @param mixed $table 
     * @param mixed $columns 
     * @param mixed $addid 
     * @param mixed $id=NULL 
     * @return mixed 
     */
    public function createTable($table, $columns, $addid = FALSE, $id='id', $type='INTEGER')
    {

        if (is_array($columns)) {
            $string = implode(",", $columns);
        }
        else {
            $string = $columns;
        }
        try {
            if ($addid) {
                $chk = $this->pdo->exec($this->plugin->Sql(__FUNCTION__ . 'id', $table, $string, $id, $type));
            }
            else {
                $chk = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $table, $string));
            }
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * dropTable
     * @param mixed $table 
     * @return mixed 
     */
    public function dropTable($table)
    {
        try {
            $chk = $this->pdo->exec($this->plugin->Sql(__FUNCTION__, $table));
            return TRUE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * listTables
     * @return mixed 
     */
    public function listTables()
    {
        try {
            $check = $this->pdo->query($this->plugin->Sql(__FUNCTION__));
            $rows = $check->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Count
     * @param mixed $table 
     * @param mixed $sql 
     * @param mixed $values 
     * @return mixed 
     */
    public function Count($table, $sql = '', $values = array())
    {
        try {
            $count = $this->pdo->prepare('SELECT count(*) FROM ' . $table . ' ' . $sql);
            $count->execute($values);
            $check = $count->fetchColumn();
            if (is_string($check) && intval($check) > 0) {
                return intval($check);
            }
            else {
                return false;
            }
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Delete
     * @param mixed $table 
     * @param mixed $sql 
     * @param mixed $values 
     * @return mixed 
     */
    public function Delete($table, $sql, $values = array())
    {
        try {
            $del = $this->pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . $sql);
            $del->execute($values);
            $check = $del->rowCount();
            if ($check > 0) {
                return $check;
            }
            else {
                return false;
            }
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Insert
     * @param mixed $table 
     * @param mixed $data 
     * @param mixed $query 
     * @return mixed 
     */
    public function Insert($table, $data, $query = '')
    {

        try {
            $chk = 0;
            $keys = array();
            $values = array_values($data);
            $string = [];
            reset($data);
            while (list($key, $value) = each($data)) {
                $string[] = "?";
                $keys[] = $key;
            }

            $add = $this->pdo->prepare("INSERT INTO " . $table . " (" . implode(",", $keys) . ") VALUES (" . implode(",", $string) . ")" . $query . ";");

            $add->execute($values);

            $chk = $add->rowCount();
            if ($chk > 0) {
                return $chk;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * InsertIF
     * @param mixed $table 
     * @param mixed $data 
     * @param mixed $query 
     * @param mixed $items 
     * @return mixed 
     */
    public function InsertIF($table, $data, $query = '', $items = array())
    {
        $if = $this->Count($table, $query, $items);
        if ($if == 0) {
            return $this->Insert($table, $data);
        }
        return FALSE;
    }

    /**
     * InsertIfNot
     * @param mixed $table 
     * @param mixed $data 
     * @param mixed $query 
     * @param mixed $items 
     * @return mixed 
     */
    public function InsertIfNot($table, $data, $query = '', $items = array())
    {
        $if = $this->Count($table, $query, $items);
        if (!$if) {
            return $this->Insert($table, $data);
        }
        return FALSE;
    }

    /**
     * InsertUpdate
     * @param mixed $table 
     * @param mixed $data 
     * @param mixed $query 
     * @param mixed $items 
     * @return mixed 
     */
    public function InsertUpdate($table, $data, $query = '', $items = array())
    {
        $if = $this->InsertIF($table, $data, $query, $items);
        if ($if) {
            return TRUE;
        }
        else {
            return $this->Update($table, $data, $query, $items);
        }
        return FALSE;
    }

    /**
     * Update
     * @param mixed $table 
     * @param mixed $data 
     * @param mixed $query 
     * @param mixed $items 
     * @return mixed 
     */
    public function Update($table, $data, $query = '', $items = array())
    { // ".$query[]."
        try {
            $chk = 0;
            $keys = array();
            $values = array();
            $string = '';
            reset($data);
            while (list($key, $value) = each($data)) {
                $string .= "$key=?,";
                $values[] = $value;
            }
            $add = $this->pdo->prepare("UPDATE " . $table . " SET " . substr($string, 0, strlen($string) - 1) . " " . $query);
            for ($i = 0; $i < count($items); $i++) {
                $values[] = $items[$i];
            }
            $add->execute($values);
            $chk = $add->rowCount();
            if ($chk > 0) {
                return $chk;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * Select
     * @param mixed $table 
     * @param mixed $from 
     * @return mixed 
     */
    public function Select($table, $from = array('*'), $query = '', $values = array())
    {
        try {
            $rows = FALSE;
            $keys = array();
            $query = $this->pdo->prepare("SELECT " . implode(',', $from) . " FROM " . $table . " " . $query);
            $query->execute($values);
            $rows = $query->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch (\PDOException $e) {
            if (defined('DBDEBUG'))
                echo $this->dump($e);
            return FALSE;
        }
    }

    /**
     * DeleteIFId
     * @param mixed $table 
     * @param mixed $id 
     * @return mixed 
     */
    public function DeleteIFId($table, $id)
    {
        $del = $this->pdo->prepare('DELETE FROM ' . $table . ' WHERE id=?');
        $del->execute(array($id));
        $check = $del->rowCount();
        if ($check > 0) {
            return $check;
        }
        else {
            return 0;
        }
    }

    /**
     * TSQuery
     * @param mixed $query 
     * @return mixed 
     */
    public function TSQuery($query = '')
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Query($query);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return $insert;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSPrepare
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSPrepare($query = '', $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Prepare($query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return $insert;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSExec
     * @param mixed $query 
     * @return mixed 
     */
    public function TSExec($query = '')
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->TQuery($query);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return $insert;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSCount
     * @param mixed $table 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSCount($table, $query = '', $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Count($table, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return $insert;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSSelect
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSSelect($table, $elements = array('*'), $query = '', $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Select($table, $elements, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return $insert;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSInsertIF
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSInsertIF($table, $elements, $query = "", $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->InsertIF($table, $elements, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }
    public function TSInsertIFNot($table, $elements, $query = "", $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->InsertIfNot($table, $elements, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSInsertUpdate
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSInsertUpdate($table, $elements, $query = "", $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->InsertUpdate($table, $elements, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSInsert
     * @param mixed $table 
     * @param mixed $elements 
     * @return mixed 
     */
    public function TSInsert($table, $elements)
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Insert($table, $elements);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSUpdate
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSUpdate($table, $elements, $query = "", $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Update($table, $elements, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSDelete
     * @param mixed $table 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TSDelete($table, $query = "", $values = array())
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->Delete($table, $query, $values);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSDeleteIFId
     * @param mixed $table 
     * @param mixed $id 
     * @return mixed 
     */
    public function TSDeleteIFId($table, $id)
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->DeleteIFId($table, $id);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSCreateTable
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $addid 
     * @param mixed $id=NULL 
     * @return mixed 
     */
    public function TSCreateTable($table, $elements, $addid = FALSE, $id='id', $type='INTEGER')
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->createTable($table, $elements, $addid, $id, $type);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TSDropTable
     * @param mixed $table 
     * @return mixed 
     */
    public function TSDropTable($table)
    {
        $savepoint = base64_encode(microtime());
        $this->SBegin($savepoint);

        $insert = $this->dropTable($table);

        if ($insert) {
            $this->SCommit();
            $this->SRelease($savepoint);
            return TRUE;
        }
        else {
            $this->SRollback($savepoint);
            return FALSE;
        }
    }

    /**
     * TQuery
     * @param mixed $query 
     * @return mixed 
     */
    public function TQuery($query = '')
    {
        $this->Begin();

        $insert = $this->Query($query);

        if ($insert) {
            $this->Commit();
            return $insert;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TPrepare
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TPrepare($query = '', $values = array())
    {
        $this->Begin();

        $insert = $this->Prepare($query, $values);

        if ($insert) {
            $this->Commit();
            return $insert;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TExec
     * @param mixed $query 
     * @return mixed 
     */
    public function TExec($query = '')
    {
        $this->Begin();

        $insert = $this->TQuery($query);

        if ($insert) {
            $this->Commit();
            return $insert;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TCount
     * @param mixed $table 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TCount($table, $query = '', $values = array())
    {
        $this->Begin();

        $insert = $this->Count($table, $query, $values);

        if ($insert) {
            $this->Commit();
            return $insert;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TSelect
     * @param mixed $table 
     * @param mixed $elements
     * @param mixed $query
     * @param mixed $values 
     * @return mixed 
     */
    public function TSelect($table, $elements = array('*'), $query = '', $values = array())
    {
        $this->Begin();

        $insert = $this->Select($table, $elements, $query, $values);

        if ($insert) {
            $this->Commit();
            return $insert;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TInsertIF
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TInsertIF($table, $elements, $query = "", $values = array())
    {
        $this->Begin();

        $insert = $this->InsertIF($table, $elements, $query, $values);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }
    /**
     * TInsertIFNot
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TInsertIFNot($table, $elements, $query = "", $values = array())
    {
        $this->Begin();

        $insert = $this->InsertIfNot($table, $elements, $query, $values);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TInsertUpdate
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TInsertUpdate($table, $elements, $query = "", $values = array())
    {
        $this->Begin();

        $insert = $this->InsertUpdate($table, $elements, $query, $values);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TInsert
     * @param mixed $table 
     * @param mixed $elements 
     * @return mixed 
     */
    public function TInsert($table, $elements)
    {
        $this->Begin();

        $insert = $this->Insert($table, $elements);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TUpdate
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TUpdate($table, $elements, $query = "", $values = array())
    {
        $this->Begin();

        $insert = $this->Update($table, $elements, $query, $values);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TDelete
     * @param mixed $table 
     * @param mixed $query 
     * @param mixed $values 
     * @return mixed 
     */
    public function TDelete($table, $query = "", $values = array())
    {
        $this->Begin();

        $insert = $this->Delete($table, $query, $values);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TDeleteIFId
     * @param mixed $table 
     * @param mixed $id 
     * @return mixed 
     */
    public function TDeleteIFId($table, $id)
    {
        $this->Begin();

        $insert = $this->DeleteIFId($table, $id);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TCreateTable
     * @param mixed $table 
     * @param mixed $elements 
     * @param mixed $addid 
     * @param mixed $id=NULL 
     * @return mixed 
     */
    public function TCreateTable($table, $elements, $addid = FALSE, $id='id', $type='INTEGER')
    {
        $this->Begin();

        $insert = $this->createTable($table, $elements, $addid, $id, $type);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * TDropTable
     * @param mixed $table 
     * @return mixed 
     */
    public function TDropTable($table)
    {
        $this->Begin();

        $insert = $this->dropTable($table);

        if ($insert) {
            $this->Commit();
            return TRUE;
        }
        else {
            $this->Rollback();
            return FALSE;
        }
    }

    /**
     * __destruct
     * @return mixed 
     */
    public function __destruct()
    {
        $this->pdo = NULL;
        unset($this->pdo);
    }

    /**
     * GetFreeId
     * @param mixed $tmp 
     * @return mixed 
     */
    function GetFreeId($tmp)
    {
        if (!empty($tmp)) {
            $this->sortby($tmp, 'id');
            foreach ($tmp as $pos => $val) {
                $i = $pos + 1;
                if ($i > $val['id']) {
                    return $i;
                }
            }
            return $i;
        }
    }


    /**
     * createTableRotate
     * @param mixed $table 
     * @param mixed $gprx 
     * @return mixed 
     */
    public function createTableRotate($table, $gprx)
    {
        $data = $this->data;
        if ($data['type'] == 'sqlsrv') {
            $this->sql[''] = "IF OBJECT_ID ('$table', 'U') IS NOT NULL" .
                "DROP TABLE  $table;" .
                "CREATE TABLE  $table (" .
                "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1)," .
                "name varchar(255)," .
                "value TEXT DEFAULT ''," .
                "idx INTEGER DEFAULT 0," .
                "gprx varchar(255) DEFAULT '$gprx');";
        }
        elseif ($data['type'] == 'pgsql') {
            $this->sql[''] = "DROP TABLE IF EXISTS $table;" .
                "CREATE SEQUENCE " . $table . "_id_seq;" .
                "CREATE TABLE IF NOT EXISTS test (" .
                "id INTEGER NOT NULL PRIMARY KEY," .
                "name varchar(255) NOT NULL," .
                "value TEXT DEFAULT ''," .
                "idx INTEGER NOT NULL," .
                "gprx varchar(255)  NOT NULL DEFAULT '$gprx');" .
                "ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('" . $table . "_id_seq');";
        }
        elseif ($data['type'] == 'mysql') {
            $this->sql[''] = "DROP TABLE IF EXISTS $table;" .
                "CREATE TABLE IF NOT EXISTS $table (" .
                "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT," .
                "name varchar(255) NOT NULL," .
                "value TEXT," .
                "idx int(99) DEFAULT 1," .
                "gprx varchar(255) NOT NULL DEFAULT '$gprx');";
        }
        elseif ($data['type'] == 'sqlite') {
            $this->sql[''] = "DROP TABLE IF EXISTS $table;" .
                "CREATE TABLE IF NOT EXISTS $table (" .
                "id INTEGER NOT NULL PRIMARY KEY," .
                "name varchar(255) NOT NULL," .
                "value TEXT DEFAULT ''," .
                "idx int(99) DEFAULT 1," .
                "gprx varchar(255) NOT NULL DEFAULT '$gprx');";
        }
        try {
            $add = $this->pdo->exec($this->sql['createTableRotate']);
            return TRUE;
        } catch (\PDOException $e) {
            return FALSE;
        }
    }


    /**
     * Sort array by key
     * @param Array $array
     * @param String $subkey
     * @param bool $sort_ascending
     */
    function sortby(&$array, $subkey = "", $sort_ascending = TRUE)
    {
        if (count($array))
            $temp_array[key($array)] = array_shift($array);
        foreach ($array as $key => $val) {
            $offset = 0;
            $found = false;
            foreach ($temp_array as $tmp_key => $tmp_val) {
                if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
                    $temp_array = array_merge((array)array_slice($temp_array, 0, $offset), array($key => $val), array_slice($temp_array, $offset));
                    $found = true;
                }
                $offset++;
            }
            if (!$found) $temp_array = array_merge($temp_array, array($key => $val));
        }
        if ($sort_ascending) $array = array_reverse($temp_array);
        else $array = $temp_array;
    }

    /**
     * fromKeyQuery
     * @param mixed $array 
     * @return mixed 
     */
    public function fromKeyQuery($array = array())
    {
        $retval = '';
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $retval .= " $key=?, ";
            }
        }
        return rtrim($retval, ', ');
    }

    /**
     * fromValQuery
     * @param mixed $array 
     * @return mixed 
     */
    public function fromValQuery($array = array())
    {
        $retval = '';
        if (!empty($array)) {
            foreach ($array as $value) {
                $retval .= " $value=?, ";
            }
        }
        return rtrim($retval, ', ');
    }
}
?>