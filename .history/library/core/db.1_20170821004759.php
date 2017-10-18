<?php


        Lock
        if ($data['type']=='sqlsrv') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="LOCK TABLE $name $which;";
        }

        UnLock
        if ($data['type']=='sqlsrv') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="UNLOCK TABLES;";
        }
        

        islock
        if ($data['type']=='sqlsrv') {
            $this->sql['']="SELECT \n".
                "OBJECT_NAME(".$name.".OBJECT_ID) AS TableName \n".
                "FROM \n".
                "sys.dm_tran_locks l \n".
                "JOIN sys.partitions ".$name." ON l.resource_associated_entity_id = ".$name.".hobt_id";
            $this->sql[''] = "SELECT * FROM ".$name." WITH(XLOCK,ROWLOCK,READCOMMITTED);";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="SHOW OPEN TABLES  WHERE `Table` LIKE '%".$name."%' AND  `Database` LIKE '%".$data['name']."%' AND In_use > 0 OR Name_locked > 0;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="PRAGMA lock_status;";
        }
        
        SBegin
        if ($data['type']=='sqlsrv') {
            $this->sql['']="BEGIN TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="BEGIN; SAVEPOINT $name;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="SET autocommit = 0; START TRANSACTION; SAVEPOINT $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="BEGIN; SAVEPOINT $name;";
        }
        
        SCommit
        if ($data['type']=='sqlsrv') {
            $this->sql['']="COMMIT TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="COMMIT;";
        }
        
        SRelease
        if ($data['type']=='sqlsrv') {
            $this->sql['']="";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="RELEASE $name;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="RELEASE SAVEPOINT $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="RELEASE $name;";
        }
        
        SRollback
        if ($data['type']=='sqlsrv') {
            $this->sql['']="ROLLBACK TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="ROLLBACK TO SAVEPOINT $name;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="ROLLBACK TO $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="ROLLBACK TO $name;";
        }
        
        Begin
        if ($data['type']=='sqlsrv') {
            $this->sql['']="BEGIN TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="BEGIN;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="SET autocommit = 0; START TRANSACTION;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="BEGIN;";
        }
        
        Commit
        if ($data['type']=='sqlsrv') {
            $this->sql['']="COMMIT TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="COMMIT;";
        }
        
        Release
        if ($data['type']=='sqlsrv') {
            $this->sql['']="";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="";
        }
        
        Rollback
        if ($data['type']=='sqlsrv') {
            $this->sql['']="ROLLBACK TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="ROLLBACK;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="ROLLBACK;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="ROLLBACK;";
        }
        
        createTable        
        if ($data['type']=='sqlsrv') {
            if($addid){
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NULL".
            "CREATE TABLE  $table (".
            "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
            $string.
            ");";
            } else {
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NULL".
            "CREATE TABLE  $table (".
            $string.
            ");";
            }
        } elseif ($data['type']=='pgsql') {
            if($addid){
            $this->sql['']="CREATE SEQUENCE ".$table."_id_seq;".
            "CREATE TABLE IF NOT EXISTS test (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $string.
            ");".
            "ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('".$table."_id_seq');";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS test (".
            $string.
            ");";
            }
        } elseif ($data['type']=='mysql') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
            $string.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            $string.
            ");";
            }
        } elseif ($data['type']=='sqlite') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $string.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            $string.
            ");";
            }
        }
        
        dropTable
        if ($data['type']=='sqlsrv') {
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NOT NULL".
            "DROP TABLE  $table;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="DROP TABLE IF EXISTS "."$table;";
        }
        
        listTables
            if ($data['type']=='sqlsrv') {
                $this->sql['']="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='dbName';";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='dbName';";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="SELECT name FROM sqlite_master WHERE type='table';";
        }
        

?>