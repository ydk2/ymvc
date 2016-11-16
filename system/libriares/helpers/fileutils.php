<?php


/**
* klasa pobierania pliku :)
*/
class FileUtils {
	public static function Download($file) {
		//$		file = ($file==NULL)?$_GET['pobierz']:$file;
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
	public static function Delete($what) {
		$e=0;
		if (!file_exists($what)) {
			return 1;
		}
		if(is_dir($what)){
			foreach(glob($what . '/*') as $files) {
				if(is_dir($files))
										self::Delete($files);
				else
										$e=(unlink($files))?0:2;
			}
			$e=(rmdir($what))?0:2;
		}
		else {
			$e=(unlink($what))?0:2;
		}
		clearstatcache();
		return $e;
	}
	
	public static function Copy($from,$where,$mode=0)
				{
		$e=0;
		if (!file_exists($from)) {
			return 1;
		}
		if (file_exists($where)) {
			return 2;
		}
		if (is_dir($from)) {
			$e=(mkdir($where))?0:3;
			$files = scandir($from);
			foreach ($files as $file){
				if ($file != "." && $file != "..") {
					self::Copy("$from/$file", "$where/$file");
				}
				else {
					$data = file_get_contents("$from/$file");
					$e=(file_put_contents("$where/$file", $data))?0:4;
				}
			}
		}
		elseif(is_file($from)) {
			$data = file_get_contents($from);
			$e=(file_put_contents($where, $data))?0:4;
		}
		if ($mode===1) {
			$e=(self::Delete($from))?0:5;
		}
		clearstatcache();
		return $e;
	}
	public static function Move($from,$where)
				{
		return self::Copy($from,$where,1);
	}
	
	public static function Byte2Size($filesize){
		if(is_numeric($filesize)){
			$decr = 1024;
			$step = 0;
			$prefix = array('Byte','KB','MB','GB','TB','PB');
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
	
	public static function getUploaded($from,$where=null,$message=array(),$code=0) {
		$uploaded_size = (int) $_SERVER['CONTENT_LENGTH'];
		$where = ($where == NULL)?$message['uploaddir']:$where;
		$max = self::Size2Byte($message['limit']);
		if($max > self::Size2Byte(ini_get('upload_max_filesize'))) {
			$max = self::Size2Byte(ini_get('upload_max_filesize'));
		}
		$uploaded_size = $uploaded_size;
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
		return $arr_out;
	}
	public static function disk_free($path){
		$bytes = disk_free_space($path);
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
		return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . ' ';
	}
}
// FileUtils
?>