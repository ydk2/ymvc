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
 * @subpackage FileUtils
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */
class FileUtils {
/**
 * Set file to download
 * 
 * static
 * @param {String} $file file path
 * @return {none}
 */
	public static function Download($file) {
		if (file_exists($file)) {
			header('Pragma: public');
			header('Content-Description: File Transfer');
			header('Content-Type:'.mime_content_type($file));
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit();
		}
	}
/**
 * Delete File or directory
 * 
 * static
 * @param {String} $what file path
 * @return {integer} 0 = FALSE & 1>= TRUE
 */
	public static function Delete($what) {
		$e=0;
		if (!file_exists($what)) {
			return 0;
		}
		if(is_dir($what)){
			foreach(glob($what . '/*') as $files) {
				if(is_dir($files))
						$e=self::Delete($files);
				else
						$e=(unlink($files))?2:0;
			}
			$e=(rmdir($what))?2:0;
		}
		else {
			$e=(unlink($what))?2:0;
		}
		clearstatcache();
		return $e;
	}

/**
 * Copy File or directory
 * 
 * static
 * @param {String} $from source filepath
 * @param {String} $where destination filepath
 * @param {Integer} $mode 1 works like move
 * @return {integer} 0 = FALSE & 1>= TRUE
 */	
	public static function Copy($from,$where,$mode=0)
		{
		$e=0;
		if (!file_exists($from)) {
			return 0;
		}
		if (file_exists($where)) {
			return 0;
		}
		if (is_dir($from)) {
			$e=(mkdir($where))?3:0;
			$files = scandir($from);
			foreach ($files as $file){
				if ($file != "." && $file != ".." && is_dir($file)) {
					$e=self::Copy("$from/$file", "$where/$file");
				}
				elseif(!is_dir($file)) {
					$data = file_get_contents("$from/$file");
					$e=(file_put_contents("$where/$file", $data))?1:0;
				}
			}
		}
		elseif(is_file($from)) {
			$data = file_get_contents($from);
			$e=(file_put_contents($where, $data))?2:0;
		}
		if ($mode===1) {
			$e=(self::Delete($from))?1:0;
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
 * @return {integer} 0 = FALSE & 1>= TRUE
 */	
	public static function Move($from,$where)
		{
		return self::Copy($from,$where,1);
	}

/**
 * Convert byte value to (n)Mb  
 * 
 * static
 * @param {integer} size in bytes
 * @return {String} $size for sample 20Mb 
 */		
	public static function Byte2Size($filesize){
		if(is_numeric($filesize)){
			$decr = 1024;
			$step = 0;
			$prefix = array('b','Kb','Mb','Gb','Tb','Pb');
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
 * Convert (n)Mb to byte value 
 * 
 * static
 * @param {String} $size for sample 20Mb
 * @return {integer} size in bytes
 */		
	public static function Size2Byte ($size) {
		$incr=1024;
		$getBit = substr($size, strlen((int) $size));
		$getBit = (preg_match("/(b|byte)$/", strtolower($getBit)))?substr($getBit, 0,-1):$getBit;
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
 * example use getUploaded('file',array('limit'=>'5M','uploaddir'=>__DIR__.DIRECTORY_SEPARATOR.'uploads'))
 * 
 * static
 * @param {String} $from source filepath
 * @param {Array} $message array('limit'=>'5M','uploaddir'=>'uploads')
 * @param {Integer} $code 1 encode to base64
 * @return {Array} array with uploaded file or files
 */	
		public static function getUploaded($from,$path,$limit,$code=0) {
		$arr_out = array();
		if (isset($_FILES[$from])) {
			$uploaded_size = (int) $_SERVER['CONTENT_LENGTH'];
			$where = $path;
			$max = self::Size2Byte($limit);
			if($max > self::Size2Byte(ini_get('upload_max_filesize'))) {
				$max = self::Size2Byte(ini_get('upload_max_filesize'));
			}
			$max = $max;
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
							if (move_uploaded_file($tmp[$num], $where.DIRECTORY_SEPARATOR.$save)) {
								$arr_out[].=  $file;
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
						if (move_uploaded_file($tmp, $where.DIRECTORY_SEPARATOR.$save)) {
							$arr_out[].=  $name;
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
	public static function freeinDir($path){
		$bytes = disk_free_space($path);
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		return sprintf('%1.2f' , $bytes / pow($base,$class)) . $si_prefix[$class];
	}
/**
 * Get all entries in directory
 * 
 * static
 * @param {String} $path filepath
 * @return {Array} array of 'filename' as array(
 *        'path' => string fullpath
 *        'type' => string 'file'
 *        'owner' => string 'user''
 *        'group' => string 'group' (length=5)
 *        'perms' => int 777)
 *							
 */		
	public static function inDir($path = '') {
		$info = array();
		$path = realpath($path);
		$p = "{" . $path . "/*," . $path . "/.*}";
		foreach (glob("$p",GLOB_BRACE) as $file) {
			if (basename($file) != '..' && basename($file) != '.') {
				$type = filetype(realpath($file));
				$owner = self::getOwner(realpath($file));
				$perms = self::getPerms(realpath($file));
				$info[]['path'] = realpath($file)."";
			}
		}
		return $info;
	}

/**
 * Get all entries in directory recursively
 * 
 * static
 * @param {String} $path filepath
 * @return {Array} array of 'dirpaths' as array(
 *        'path' => string fullpath
 *        'type' => string 'file'
 *        'owner' => string 'user''
 *        'group' => string 'group' (length=5)
 *        'perms' => int 777)
 *							
 */	
public static function AllinDir($path = '') {
	$info=array();
	$path = realpath($path);
	$dir[] = $path;
	while (count($dir) != 0) {
		$v = array_shift($dir);
		foreach (glob($v) as $item) {
			if (is_dir($item)) {
				$dir[] = $item . "/*";
				$type = filetype(realpath($item));
				$owner = self::getOwner(realpath($item));
				$perms = self::getPerms(realpath($item));
			}
			else {
				$type = filetype(realpath($item));
				$owner = self::getOwner(realpath($item));
				$perms = self::getPerms(realpath($item));
				$info[dirname(realpath($item))][] = array('path'=>realpath($item),'type'=>$type,'owner'=>$owner[0],'group'=>$owner[1],'perms'=>$perms);
			}
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
			$username = posix_getpwuid(fileowner($filename));
			$user=$username['name'];
			$groupname = posix_getgrgid(filegroup($filename));
			$group=$groupname['name'];
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
					foreach (glob($filename."/*") as $value) {
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
					foreach (glob($filename."/*") as $value) {
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
}
// FileUtils
?>