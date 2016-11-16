<?php 
/**
 * chmod i jego form
 * !!! uporządkować formularz i przesyłane dane !!!
 */
class permissions {
	
	function __construct() {}
	
	public function set($what ,$mode,$recursive=0){
	$e=0;
	if (!file_exists($what)) {
		return 1;
	}
	if ($recursive==1) {
	if (is_dir($what)) {
		$e=(@chmod($what, octdec($mode)))?0:2;
		foreach (glob($what."/*") as $value) {
			$this->set($value, $mode);
		}
	} else {
		$e=(@chmod($what, octdec($mode)))?0:3;
	}
	} else {
		$e=(@chmod($what, octdec($mode)))?0:3;
	}
	return $e;
	} // chmod_r
	public function get($value = '') {
            $perms = fileperms($value);

            if (($perms & 0xC000) == 0xC000) {
                // Socket
                $info['type'] = 's';
            } elseif (($perms & 0xA000) == 0xA000) {
                // Symbolic Link
                $info['type'] = 'l';
            } elseif (($perms & 0x8000) == 0x8000) {
                // Regular
                $info['type'] = '-';
            } elseif (($perms & 0x6000) == 0x6000) {
                // Block special
                $info['type'] = 'b';
            } elseif (($perms & 0x4000) == 0x4000) {
                // Directory
                $info['type'] = 'd';
            } elseif (($perms & 0x2000) == 0x2000) {
                // Character special
                $info['type'] = 'c';
            } elseif (($perms & 0x1000) == 0x1000) {
                // FIFO pipe
                $info['type'] = 'p';
            } else {
                // Unknown
                $info['type'] = 'u';
            }
 
            // Owner
            $info['owner']['r'] = (($perms & 0x0100) ? TRUE : FALSE);
            $info['owner']['w'] = (($perms & 0x0080) ? TRUE : FALSE);
            $info['owner']['x'] = (($perms & 0x0040) ? (($perms & 0x0800) ? FALSE:TRUE) : (($perms & 0x0800) ? FALSE : FALSE));

            // Group
            $info['group']['r'] = (($perms & 0x0020) ? TRUE : FALSE);
            $info['group']['w'] = (($perms & 0x0010) ? TRUE : FALSE);
            $info['group']['x'] = (($perms & 0x0008) ? (($perms & 0x0400) ? FALSE:TRUE) : (($perms & 0x0400) ? FALSE : FALSE));

            // World
            $info['any']['r'] = (($perms & 0x0004) ? TRUE : FALSE);
            $info['any']['w'] = (($perms & 0x0002) ? TRUE : FALSE);
            $info['any']['x'] = (($perms & 0x0001) ? (($perms & 0x0200) ? FALSE:TRUE) : (($perms & 0x0200) ? FALSE : FALSE));

            return $info;
    }
} // class

?>