<?php


        Lock
        if ($data['type']=='sqlsrv') {
            $this->sql['']="LOCK TABLE ${args[1]} ${args[2]};";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="LOCK TABLE ${args[1]} ${args[2]};";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="LOCK TABLE ${args[1]} ${args[2]};";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="LOCK TABLE ${args[1]} ${args[2]};";
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
                "OBJECT_NAME(".${args[1]}.".OBJECT_ID) AS TableName \n".
                "FROM \n".
                "sys.dm_tran_locks l \n".
                "JOIN sys.partitions ".${args[1]}." ON l.resource_associated_entity_id = ".${args[1]}.".hobt_id";
            $this->sql[''] = "SELECT * FROM ".${args[1]}." WITH(XLOCK,ROWLOCK,READCOMMITTED);";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="SHOW OPEN TABLES  WHERE `Table` LIKE '%".${args[1]}."%' AND  `Database` LIKE '%".$data['name']."%' AND In_use > 0 OR Name_locked > 0;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="PRAGMA lock_status;";
        }
        
        SBegin
        if ($data['type']=='sqlsrv') {
            $this->sql['']="BEGIN TRAN ${args[1]};";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="BEGIN; SAVEPOINT ${args[1]};";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="SET autocommit = 0; START TRANSACTION; SAVEPOINT ${args[1]};";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="BEGIN; SAVEPOINT ${args[1]};";
        }
        
        SCommit
        if ($data['type']=='sqlsrv') {
            $this->sql['']="COMMIT TRAN ${args[1]};";
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
            $this->sql['']="RELEASE ${args[1]};";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="RELEASE SAVEPOINT ${args[1]};";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="RELEASE ${args[1]};";
        }
        
        SRollback
        if ($data['type']=='sqlsrv') {
            $this->sql['']="ROLLBACK TRAN ${args[1]};";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="ROLLBACK TO SAVEPOINT ${args[1]};";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="ROLLBACK TO ${args[1]};";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="ROLLBACK TO ${args[1]};";
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
            $this->sql['']="IF OBJECT_ID ('${args[1]}', 'U') IS NULL".
            "CREATE TABLE  ${args[1]} (".
            "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
            ${args[2]}.
            ");";
            } else {
            $this->sql['']="IF OBJECT_ID ('${args[1]}', 'U') IS NULL".
            "CREATE TABLE  ${args[1]} (".
            ${args[2]}.
            ");";
            }
        } elseif ($data['type']=='pgsql') {
            if($addid){
            $this->sql['']="CREATE SEQUENCE ".${args[1]}."_id_seq;".
            "CREATE TABLE IF NOT EXISTS test (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            ${args[2]}.
            ");".
            "ALTER TABLE ${args[1]} ALTER id SET DEFAULT NEXTVAL('".${args[1]}."_id_seq');";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS ${args[1]} (".
            ${args[2]}.
            ");";
            }
        } elseif ($data['type']=='mysql') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS ${args[1]} (".
            "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
            ${args[2]}.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS ${args[1]} (".
            ${args[2]}.
            ");";
            }
        } elseif ($data['type']=='sqlite') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS ${args[1]} (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            ${args[2]}.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS ${args[1]} (".
            ${args[2]}.
            ");";
            }
        }
        
        dropTable
        if ($data['type']=='sqlsrv') {
            $this->sql['']="IF OBJECT_ID ('${args[1]}', 'U') IS NOT NULL".
            "DROP TABLE  ${args[1]};";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="DROP TABLE IF EXISTS ${args[1]};";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="DROP TABLE IF EXISTS ${args[1]};";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="DROP TABLE IF EXISTS "."${args[1]};";
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