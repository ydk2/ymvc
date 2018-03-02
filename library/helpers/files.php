<?php
/**
* 
 * FileUtils fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Copy, Move, Upload, Download and many other helper class.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC
 * @package    YMVC System
 * @subpackage Files
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */

namespace Library\Helpers;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

class Files {
/**
 * Set file to download
 * 
 * static
 * @param {String} $file file path
 * @return {none}
 */
	public static function Download($file) {	
		$f = self::Info($file);
		if (!$f) return FALSE;
		if ($f && !$f['dir']) {
			header('Pragma: public');
			header('Content-Description: File Transfer');
			header('Content-Type:'.$f['mime']);
			header('Content-Disposition: attachment; filename='.$f['name']);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Content-Length: ' . $f['bytes']);
			ob_clean();
			flush();
			readfile($f['path']);
			exit();
		}
	}

/**
 * Remove File or directory
 * 
 * static
 * @param mixed $path 
 * @param mixed $force=FALSE 
 * @return boolean 
 */
public static function Remove($path,$force=FALSE) {
	$e=0;
	$f = self::Info($path);
	if (!$f) return FALSE;
	if($f['dir'] && $force==TRUE){
		$list = self::List($f['path']);
		if(!empty($list)){
			foreach($list as $files) {
				if($files['dir']){
					$e=self::Remove($files['path'],$force);
				} else {
					$e=(unlink($files['path']))?1:0;
				}
			}
		}
		$e=(rmdir($f['path']))?1:0;
	} else {
		$e=(unlink($f['path']))?1:0;
	}
	clearstatcache();
	return $e;
}

/**
 * Copy File or directory
 * 
 * static
 * @param mixed $source 
 * @param mixed $target 
 * @param mixed $force=FALSE 
 * @return mixed 
 */
public static function Copy($source,$target,$force=FALSE) {
	$e=0;
	$f = self::Info($source);
	$t = self::Info($target);
	if (!$f) return FALSE;
	if ($t && $force==FALSE) return FALSE;
	
	if($f['dir']){
		
		if($t){
			if(!is_dir($target)) return FALSE;
			$e = 1;
		} else {
			$e=(mkdir($target))?1:0;
		}
		
		$list = self::List($f['path']);
		if(!empty($list) && $e){
			foreach($list as $file) {
				if($file['dir']){
					$e=self::Copy($file['path'],$target.DS.$file['name'],$force);
				} else {
					$data = file_get_contents($file['path']);
					$e=(file_put_contents($target.DS.$file['name'], $data))?1:0;
				}
			}
		}

	} else {
		$data = file_get_contents($f['path']);
		$e=(file_put_contents($target.DS.$f['name'], $data))?1:0;
	}
	clearstatcache();
	return $e;
}

/**
 * Move or Reneme File or directory alias of Copy(src,dest,1)
 * 
 * static
 * @param {String} $from source filepath
 * @param {String} $where destination filepath
 * @param {boolean} $force
 * @return {integer} 0 = FALSE & 1>= TRUE
 */	
	public static function Move($from,$where,$force=FALSE){
		$e = self::Copy($from,$where,$force);
		if($e)
		$e = self::Remove($from,TRUE);
		return $e;
	}

/**
 * Convert byte value to (n)M  
 * 
 * static
 * @param {integer} size in bytes
 * @return {String} $size for sample 20Mb 
 */		
	public static function Byte2Size($filesize){
		if(is_numeric($filesize)){
			$decr = 1024;
			$step = 0;
			$prefix = array('B','K','M','G','T','P');
			while(($filesize / $decr) > 0.9999){
				$filesize = $filesize / $decr;
				$step++;
			}
			return round($filesize,2).' '.$prefix[$step];
		}
		else {
			return 'NaN';
		}
	}
	// 	pokaz size w string

/**
 * Convert (n)M to byte value 
 * 
 * static
 * @param {String} $size for sample 20Mb
 * @return {integer} size in bytes
 */		
	public static function Size2Byte ($size) {
		$incr=1024;
		$getBit = substr($size, strlen((int) $size));
		$getBit = (preg_match("/(B|b|byte)$/", strtolower($getBit)))?substr($getBit, 0,-1):$getBit;
		$lista=preg_match("/(K|M|G|T|P)$/", strtoupper($getBit), $match);
		switch ($match[0]) {
			case 'K':
				return (int) $size * $incr;
			break;
			case 'M':
				return (int) $size * pow($incr,2);
			break;
			case 'G':
				return (int) $size *  pow($incr,3);
			break;
			case 'T':
				return (int) $size *  pow($incr,4);
			break;
			case 'P':
				return (int) $size *  pow($incr,5);
			break;
			default:
				return (int) $size;
			break;
		}
	}
	

/**
 * Uploading File
 * example use Files::Upload('file',array('limit'=>'5M','uploaddir'=>__DIR__.DIRECTORY_SEPARATOR.'uploads'))
 * 
 * static
 * @param {String} $from source filepath
 * @param {Array} $message array('limit'=>'5M','uploaddir'=>'uploads')
 * @param {Integer} $code 1 encode to base64
 * @return {Array} array with uploaded file or files
 */	
	public static function Upload($from,$path,$limit='20M',$code=0) {
		$arr_out = array();
		$path = realpath($path);
		if(!file_exists($path)) return FALSE;
		if (isset($_FILES[$from])) {
			$uploaded_size = (int) $_SERVER['CONTENT_LENGTH'];
			$where = $path;
			$max = self::Size2Byte($limit);
			if($max > self::Size2Byte(ini_get('upload_max_filesize'))) {
				$max = self::Size2Byte(ini_get('upload_max_filesize'));
			}
			$files = $_FILES[$from];
			$name = $files['name'];
			$size = $files['size'];
			$type = $files['type'];
			$tmp = $files['tmp_name'];
			$error= $files['error'];
			if ($uploaded_size > $max) {
				$arr_out = 5;
			}
			else {
				if(is_array($name)){
					foreach ($name as $num => $file) {
						if ($error[$num] !== UPLOAD_ERR_OK ) {
							$arr_out[].= $error[$num];
						}
						elseif($error[$num] === UPLOAD_ERR_OK) {
							if($code === 1){
								$save=base64_encode($name[$num]);
							}
							else {
								$save = $name[$num];
							}
							if (move_uploaded_file($tmp[$num], $where.DS.$save)) {
								$arr_out[].=  self::Info($where.DS.$save);
							}
							else {
								$arr_out[].=  $error[$num];
							}
						}
					}
				}
				else {
					if ($error !== UPLOAD_ERR_OK ) {
						$arr_out[].= $error;
					}
					elseif($error === UPLOAD_ERR_OK) {
						if($code === 1){
							$save=base64_encode($name);
						}
						else {
							$save = $name;
						}
						if (move_uploaded_file($tmp, $where.DS.$save)) {
							$arr_out[].=  self::Info($where.DS.$save);
						}
						else {
							$arr_out[].=  $error;
						}
					}
				}
			}
		}
		return $arr_out;
	}

/**
 * Get free space in given path
 * 
 * static
 * @param {String} $path filepath
 * @return {String} for sample 10MB 
 */	
	public static function FreeSpace($path){
		$path = realpath($path);
		if(!file_exists($path)) return '';
		$bytes = disk_free_space($path);
		$si_prefix = array( 'B', 'K', 'M', 'G', 'T', 'E', 'Z', 'Y' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		return sprintf('%1.2f' , $bytes / pow($base,$class)) . $si_prefix[$class];
	}

	/**
	 * Glob
	 * @param mixed $path 
	 * @return mixed 
	 */
	public static function Glob($path = './*') {
		$info = array();
		$path = realpath($path);
		if(!file_exists($path)) return FALSE;
		foreach (glob("$path",GLOB_BRACE) as $file) {
			if (basename($file) != '..' && basename($file) != '.') {
				$info[basename($file)] = self::Info(realpath($file));
			}
		}
		return $info;
	}

	/**
	 * List
	 * @param mixed $dir 
	 * @return mixed 
	 */
	public static function List($dir) {
	   $info = array();
	   $f = self::Info($dir);
	   if (!$f) return FALSE;
	   if(!$f && $f['dir']) return FALSE;
	   $cdir = scandir($f['path']);
	   foreach ($cdir as $n => $file){
	      if (!in_array($file,array(".",".."))){
			$path = $dir.DS.$file;
			$info[] = self::Info($path);
	      }
	   }
	   return $info;
	}

	/**
	 * Info of file
	 * @param mixed $file 
	 * @return mixed 
	 */
	public static function Info($file) {
		$n1 = basename($file);
		$path = realpath($file);
		$n2 = basename($path);
		if($n1 != $n2) return FALSE;
		if(!file_exists($path)) return FALSE;
		$type = filetype($path);
		$owner = self::getOwner($file);
		$perms = self::getPerms($path);
		$size = filesize($path);
		clearstatcache();
		return array(
			'dir'=>is_dir($path),
			'path'=>$path,
			'name'=>basename($file),
			'type'=>$type,
			'mime'=>mime_content_type($file),
			'owner'=>$owner[0],
			'group'=>$owner[1],
			'perms'=>$perms,
			'size'=>self::FormatSize($size),
			'bytes'=>$size
		);		
	}
	
	/**
	 * FormatSize
	 * @param mixed $bytes 
	 * @param mixed $decimals 
	 * @return mixed 
	 */
	static public function FormatSize($bytes, $decimals = 2) {
		$si_prefix = array( 'B', 'K', 'M', 'G', 'T', 'E', 'Z', 'Y' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		return sprintf('%1.'.$decimals.'f' , $bytes / pow($base,$class)) . $si_prefix[$class];
	}
	
	
/**
 * ListAll
 * @param mixed $path 
 * @param mixed $limit=1000 
 * @return mixed 
 */
public static function ListAll($path = './*',$limit=1000) {
	$info=array();
	$f = self::Info($path);
	if (!$f) return FALSE;
	$dir[] = $f['path'];
	$i = 0;
	while (count($dir) !== 0) {
		if($i == $limit) break;
		$v = array_shift($dir);
		foreach (glob($v) as $item) {
			if (is_dir($item)) {
				$dir[] = $item . DS . "*";
			}
			$info[] = self::Info(realpath($item));
			if($i == $limit) break;
			$i++;
		}
	}
	return $info;
}

/**
 * Find
 * @param mixed $path 
 * @param mixed $word='' 
 * @param mixed $min=0 
 * @param mixed $limit=1000 
 * @return mixed 
 */
static public function Find($path = './*',$word='',$min=0, $limit=1000){
	$info=array();
	$path = realpath($path);
	if(!file_exists($path)) return FALSE;
	$dir[] = $path;
	$i = 0;
	$min = ($min>=0)?$min:0;
	while (count($dir) !== 0) {
		if($i == $limit) break;
		$v = array_shift($dir);
		foreach (glob($v) as $item) {
			if (is_dir($item)) {
				$dir[] = $item . DS . "*";
			}
			if (strlen($word)>$min && strpos(basename($item), $word) !== FALSE){
				$info[] = self::Info(realpath($item));
			}
			if($i == $limit) break;
			$i++;
		}
	}
	return $info;
}
/**
 * Get Owner and group of file or folder
 * 
 * static
 * @param {String} $filename filepath
 * @return {Array} array (user,group)
 */	
	public static function getOwner($filename)
	    {
		$filename=realpath($filename);
		if(file_exists($filename)){
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$username = fileowner($filename);
				$user=$username['name'];
				$groupname = filegroup($filename);
				$group=$groupname['name'];
			} else {
				$username = posix_getpwuid(fileowner($filename));
				$user=$username['name'];
				$groupname = posix_getgrgid(filegroup($filename));
				$group=$groupname['name'];
			}
			return array($user,$group);
		}
		return FALSE;
	} // getOwner


/**
 * Set Owner and group file or folder
 * 
 * static
 * @param {String} $filename filepath
 * @param {String} $user username in string
 * @param {String} $group groupname in string
 * @param {Integer} $recursive for recursive mode
 * @return {integer} 0 = FALSE & 1>= TRUE
 */			
	public static function setOwner($filename ,$user,$group,$recursive=0){
		$e=0;
		$filename = realpath($filename);
		
		if(file_exists($filename)){
			if ($recursive==1) {
				if (is_dir($filename)) {
					$e=(@chown($filename, $user))?1:0;
					$e=(@chgrp($filename, $group))?1:0;
					foreach (glob($filename.DS."*") as $value) {
						$e=self::setOwner($value,$user,$group,$recursive);
					}
				}
				else {
					$e=(@chown($filename, $user))?2:0;
					$e=(@chgrp($filename, $group))?2:0;
				}
			}
			else {
				$e=(@chown($filename, $user))?3:0;
				$e=(@chgrp($filename, $group))?3:0;
			}
			return $e;
		}
		return FALSE;
	}
	// 	setOwner

/**
 * Get permission of file or folder
 * 
 * static
 * @param {String} $filename filepath
 * @return {Integer} in oct mode
 */	
	public static function getPerms($filename)
	    {
		$filename=realpath($filename);
		if(file_exists($filename)){
			$stat = stat($filename);
			$mode = intval( substr( decoct($stat['mode']),-4));
			return $mode;
		}
		return FALSE;
	}
	// 	getPerms

/**
 * Set Permissions file or folder
 * 
 * static
 * @param {String} $filename filepath
 * @param {String} $mode dec digits like 755 or 644
 * @param {Integer} $recursive for recursive mode
 * @return {integer} 0 = FALSE & 1>= TRUE
 */	
	public static function setPerms($filename ,$mode,$recursive=0){
		$e=0;
		$filename = realpath($filename);
		
		if(file_exists($filename)){
			if ($recursive==1) {
				if (is_dir($filename)) {
					$dir = intval($mode)+111;
					$e=(@chmod($filename, octdec($dir)))?1:0;
					foreach (glob($filename.DS."*") as $value) {
						$e=self::setPerms($value, $mode, $recursive);
					}
				}
				else {
					$e=(@chmod($filename, octdec($mode)))?2:0;
				}
			}
			else {
				if (is_dir($filename)) {
				$dir = intval($mode)+111;
					$e=(@chmod($filename, octdec($dir)))?1:0;
				} else {
					$e=(@chmod($filename, octdec($mode)))?3:0;
				}
			}
			return $e;
		}
		return FALSE;
	}
	// 	setPerms
	/**
	 * NativePath
	 * @param mixed $path 
	 * @param mixed $case='none' 
	 * @return mixed 
	 */
	static public function NativePath($path,$case='none'){
		switch ($case) {
			case 'lower':
				return strtolower(str_replace(array('\\', '/'), DS , $path));
				break;
			case 'upper':
				return strtoupper(str_replace(array('\\', '/'), DS , $path));
				break;
			default:
				return str_replace(array('\\', '/'), DS , $path);
				break;
		}
	}
}
// Files
?>