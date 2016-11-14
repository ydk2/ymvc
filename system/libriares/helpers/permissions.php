<?php 
/**
 * chmod i jego form
 * !!! uporządkować formularz i przesyłane dane !!!
 */
class permissions {
	
	function __construct() {}
	
	public function set($co ,$mode,$w='nie'){
	$e=0;
	if (!file_exists($co)) {
		return 1;
	}
	if ($w=='tak') {
	if (is_dir($co)) {
		$e=(@chmod($co, octdec($mode)))?0:2;
		foreach (glob($co."/*") as $value) {
			$this->set($value, $mode);
		}
	} else {
		$e=(@chmod($co, octdec($mode)))?0:3;
	}
	} else {
		$e=(@chmod($co, octdec($mode)))?0:3;
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
            $info['owner']['r'] = (($perms & 0x0100) ? "checked=\"checked\"" : NULL);
            $info['owner']['w'] = (($perms & 0x0080) ? "checked=\"checked\"" : NULL);
            $info['owner']['x'] = (($perms & 0x0040) ? (($perms & 0x0800) ? NULL:"checked=\"checked\"") : (($perms & 0x0800) ? null : null));

            // Group
            $info['group']['r'] = (($perms & 0x0020) ? "checked=\"checked\"" : NULL);
            $info['group']['w'] = (($perms & 0x0010) ? "checked=\"checked\"" : NULL);
            $info['group']['x'] = (($perms & 0x0008) ? (($perms & 0x0400) ? NULL:"checked=\"checked\"") : (($perms & 0x0400) ? null : null));

            // World
            $info['any']['r'] = (($perms & 0x0004) ? "checked=\"checked\"" : NULL);
            $info['any']['w'] = (($perms & 0x0002) ? "checked=\"checked\"" : NULL);
            $info['any']['x'] = (($perms & 0x0001) ? (($perms & 0x0200) ? NULL:"checked=\"checked\"") : (($perms & 0x0200) ? null : null));

            return $info;
        }
	public function form()
	{
	$arr_mode=$_REQUEST['arr_mode'];
	$old=$_REQUEST['old'];
	$mode=$_REQUEST['mode'];
	$path = ($this->LINK) ? $this->TEN . $this->LINK : $this->TEN;
	$link= (is_dir($this->plik))?$this->plik:dirname($this->plik);
	$link.=DIRECTORY_SEPARATOR.$old;
    $get = $this->get($link);
	$odczyt="{$this->lang['odczyt']}";
	$zapis="{$this->lang['zapis']}";
	$exec="{$this->lang['wykonywanie']}";
	$form=array(
	"<form action=\"$path\" method=\"POST\">",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"400\" {$get['owner']['r']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"200\" {$get['owner']['w']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"100\" {$get['owner']['x']} />",
	
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"40\" {$get['group']['r']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"20\" {$get['group']['w']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"10\" {$get['group']['x']} />",
	
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"4\" {$get['any']['r']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"2\" {$get['any']['w']} />",
	"<input type=\"checkbox\" name=\"arr_mode[]\" value=\"1\" {$get['any']['x']} />",
	
	"{$this->lang['w']} {$this->lang['katalogu']}<input type=\"checkbox\" value=\"tak\" name=\"mode\" ".($get['type']=='d')?"checked=\"checked\"" : NULL."/>",
	"<input type=\"hidden\"  name=\"old\" value=\"$old\" />",
	"<input type=\"submit\" value=\"{$this->lang['zmień']}\" />\n",
	"</form>"
	);
	if (isset($old)) {
	if (!isset($arr_mode)) {
		$out="<div style=\"width:160px; border: 1px solid black; padding:3px;\">";
		$out.=$form[0];
		$out.="<b>{$this->lang['dla']} : \"$old\"</b>";
		$out.="<div>$form[1]$form[4]$form[7] $odczyt</div>";
		$out.="<div>$form[2]$form[5]$form[8] $zapis</div>";
		$out.="<div>$form[3]$form[6]$form[9] $exec</div>";
	 	$out.=$form[10].$form[11];
		$out.=$form[12].$form[13];
		$out.="</div>";
	} elseif (isset($arr_mode)) {
		$i=0;
		foreach ($arr_mode as $key => $value) {
			$i += $value;
		}
		$val=$i;
	} 
	if ($mode=='tak' and isset($arr_mode)) {
		$zmien=$this->set($link,$val, 'tak');
	} elseif ($mode!='tak' and isset($arr_mode)) {
		$zmien= $this->set($link, $val);
	}
	if(isset($arr_mode)){
	if ($zmien) {
		$out="{$this->lang['zmieniono']} \"$link\" {$this->lang['na']} \"$val\"";
		$out.="&nbsp;<a href=\"$akcja\"><button>{$this->lang['odśwież']}</button></a>";
	} else {
		$out="{$this->lang['nie']} {$this->lang['zmieniono']} \"$link\"";
	}
	}
	}
	return $out;
} // form
} // class

?>