<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Connector for databases PoSQL, SQLite , MySQL using PDO.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC, Database
 * @package    YMVC System
 * @subpackage DBConnect
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.11.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 1.0.0
 
 */

class DBConnect {
	public $db;
	
	final public function Connect($engin, $database, $host = 'localhost', $user = NULL, $pass = NULL) {
		try {
			if ($engin == 'posql') {
				require_once ROOT.VENDORS.'posql.php';
				$database_name = ROOT.DATA.'database'.DS.$database . '.db';
				//echo $database_name;
				if (!file_exists($database_name.'.php')) {
					throw new SystemException('Database not exist.',420404);
				}
				// try connect
				//$sql = SQL;
				
				$this->db = new Posql($database_name);
				//$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				if ($this->db -> isError()) {
					abort($this->db);
					throw new SystemException('Can\'t connect to Database.',420502);
				}

			}

			if ($engin == 'sqlite') {
			try {
				
				$database_name = ROOT.DATA.'database'.DS. $database . '.db';
				$this->db = new PDO($engin.':'. $database_name);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch (PDOException $e){
    			//handle PDO
    			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
			if ($engin == 'sqlsrv') {
			try {
				if ($user === NULL || $pass === NULL) {
					throw new SystemException('User and Password not filed.');
				}
				$this->db = new PDO($engin.':Server=' . $host . ';Database=' . $database.';ConnectionPooling=0', $user, $pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch (PDOException $e){
    			//handle PDO
    			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
			
			if ( !in_array($engin,array('posql','sqlite','sqlsrv'))) {
			try {
				if ($user === NULL || $pass === NULL) {
					throw new SystemException('User and Password not filed.');
				}
				$this->db = new PDO($engin.':host=' . $host . ';dbname=' . $database, $user, $pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$err = $this->db->errorInfo();
				if($err[0]>0){
					throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
				}

			} catch (PDOException $e){
    			//handle PDO
    			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
			}
			}
		} catch (SystemException $e) {
			return FALSE;
		}

	}

	public function __destruct() {
		$this->db = NULL;
		unset($this->db);
	}

    public function GetId($data,$idx,$name,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx'])
            return $items['id'];
        }
        return NULL;
    }

    public function GetName($data,$idx,$value,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['value']==$value && $gprx==$items['gprx'])
            return $items['name'];
        }
        return NULL;
    }

    public function GetValue($data,$idx,$name,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx'])
            return $items['value'];
        }
        return NULL;
    }

    public function GetIdx($data,$name,$value,$gprx=''){
        foreach ($data as $items) {
            if($items['name']==$name && $items['value']==$value && $gprx==$items['gprx'])
            return $items['idx'];
        }
        return NULL;
    }

    public function Getgprx($data,$name,$value,$idx){
        foreach ($data as $items) {
            if($items['name']==$name && $items['value']==$value && $idx==$items['idx'])
            return $items['gprx'];
        }
        return NULL;
    }

    public function SetName(&$data,$idx,$name,$newname,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['name']=$newname;
                return $items['name'];
            }
        }
        return NULL;
    }

    public function UnsetName(&$data,$idx,$name,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                unset($data[$i]);
            }
        }
        return NULL;
    }

    public function SetValue(&$data,$idx,$name,$newvalue,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['value']=$newvalue;
                return $items['value'];
            }
        }
        return NULL;
    }

    public function Setgprx(&$data,$idx,$name,$newgprx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['gprx']=$newgprx;
                return $items['gprx'];
            }
        }
        return NULL;
    }

    public function SetIdx(&$data,$idx,$name,$newidx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['idx']=$newidx;
                return $items['idx'];
            }
        }
        return NULL;
    }

    public function searchByName($data,$name='_name',$gprx=''){
        $aout = array();
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['gprx'])){
                if($name==$items['name'] && $gprx==$items['gprx']){
                    $item = $items['idx'];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value['idx']) && $item===$value['idx']){
                            $values[$value['name']]=$value['value'];
                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }
    public function searchByNameValue($data,$name='_name',$value='',$gprx=''){
        $aout = array();
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['value']) && isset($items['gprx'])){
                if($name==$items['name'] && $value==$items['value'] && $gprx==$items['gprx']){
                    $item = $items['idx'];
                    $outval = array();
                    foreach ($data as $values) {
                        if(isset($values['idx']) && $item===$values['idx']){
                            $values[$value['name']]=$value['value'];
                        }
                    }
                    $aout[$item]=$outval;
                }
            }
        }
        return $aout;
    }

    public function reverseItems($items,$data,$gprx=''){
        $rout = array();
        foreach ($items as $idx => $item) {
            foreach($item as $name => $value){
            $id = $this->GetId($data,$idx,$name,$gprx);
            $rout[] = array('id'=>$id,'idx'=>$idx,'name'=>$name,'value'=>$value,'gprx'=>$gprx);
            }
        }
        return $rout;
    }

    function GetFreeId($tmp,$add,$gprx){
        if (!empty($tmp)){
            $tmp += $this->reverseItems($add,$gprx);
            sksort($tmp,'id');
            foreach ($tmp as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['id']) {
                    return $i;
                }
            }
            return $i;
        }
    }

    public function array_rotate_delete_id($data,$delete,$control='id'){
        $updatein = array();
        $updateout = $data;
                foreach ($data as $i => $item) {
                    $update=array();
                    if(isset($item[$control])){
                        if($item[$control]==$delete){
                            echo $item[$control]." $i<br>";
                            unset($updateout[$i]);
                        }
                    }
                }
        return $updateout;
    }

    public function array_rotate_delete($data,$delete,$idx='idx'){
        $updatein = array();
        $updateout = $data;
                foreach ($data as $i => $item) {
                    if(isset($item[$idx])){
                        if($item[$idx]==$delete){
                            unset($updateout[$i]);
                        }
                    }
                }
        return $updateout;
    }

    public function array_rotate_update($data,$updated,$control='id'){
        $updatein = array();
        $updateout = $data;
        foreach ($updated as $entry) {
            foreach ($entry as $key => $value) {
                if(isset($value[$control])){
                    $updatein[$value[$control]] = $value;
                foreach ($data as $idx => $item) {
                    $update=array();
                    if(isset($item[$control])){
                        if($item[$control]===$updatein[$value[$control]][$control]){
                            $update=$updatein[$value[$control]];
                            $updateout[$idx] = $update;
                        }
                    }
                }
                }
            }
        }
        return $updateout;
    }

    public function array_rotate_key_value($data,$key='name',$val='value',$control='id'){
        $updateout = array();
        foreach ($data as $i => $idx) {
            foreach ($idx as $keys => $value) {
                if(isset($value[$key]) && isset($value[$val])){
                $updateout[$i][$value[$key]] = $value[$val];
                }
            }
        }
        return $updateout;
    }
    
    public function array_search_rotate($data,$search_value='',$search_name='_name',$_value='value',$_name='name',$idx='idx',$control='id'){
        $aout = array();
        foreach ($data as $i => $items) {
            if(isset($items[$_name]) && isset($items[$_value])){
                if($search_name==$items[$_name] && $search_value==$items[$_value]){
                    $item = $items[$idx];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$idx]) && $item===$value[$idx]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$idx])) $values[$value[$_name]][$idx]=$value[$idx];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];

                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }

    public function array_rotate($data,$search_name='_name',$_value='value',$_name='name',$idx='idx',$control='id'){
        $aout = array();
        foreach ($data as $i => $items) {
            if(isset($items[$_name])){
                if($search_name==$items[$_name]){
                    $item = $items[$idx];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$idx]) && $item===$value[$idx]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$idx])) $values[$value[$_name]][$idx]=$value[$idx];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];

                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }

}
?>