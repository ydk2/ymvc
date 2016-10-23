<?php
	function convert($size){
	    $unit=array('b','kb','mb','gb','tb','pb');
	    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	function cpu_get_usage(){
    $load = sys_getloadavg();
    return $load[0];
	}
	
	function dump($var){
    ob_start();
	var_dump($var);
    return ob_get_clean();
	}
	function get_time(){
		# code...
		return microtime(true);
	}
	function get_time_exec($start,$end){
		return round(($end - $start),9);
	}
	function format_time($duration) {
	    $hours = (int) ($duration / 60 / 60);
    	$minutes = (int) ($duration / 60) - $hours * 60;
		$seconds = (int) $duration - $hours * 60 * 60 - $minutes * 60;
		return ($hours == 0 ? "00":$hours) . ":" . ($minutes == 0 ? "00":($minutes < 10? "0".$minutes:$minutes)) . ":" . ($seconds == 0 ? "00":($seconds < 10? "0".$seconds:$seconds));
	}

	function  get_root_url(){
		return HOST_URL;
	}
	/**
 * Insert XML into a SimpleXMLElement
 * @from http://stackoverflow.com/questions/767327/in-simplexml-how-can-i-add-an-existing-simplexmlelement-as-a-child-element
 * @param SimpleXMLElement $parent
 * @param string $xml
 * @param bool $before
 * @return bool XML string added
 */
function simplexml_import_xml(SimpleXMLElement $parent, $xml, $before = false)
{
    $xml = (string)$xml;

    // check if there is something to add
    if ($nodata = !strlen($xml) or $parent[0] == NULL) {
        return $nodata;
    }

    // add the XML
    $node     = dom_import_simplexml($parent);
    $fragment = $node->ownerDocument->createDocumentFragment();
    $fragment->appendXML($xml);

    if ($before) {
        return (bool)$node->parentNode->insertBefore($fragment, $node);
    }

    return (bool)$node->appendChild($fragment);
}
/**
 * Insert SimpleXMLElement into SimpleXMLElement
 * @from http://stackoverflow.com/questions/767327/in-simplexml-how-can-i-add-an-existing-simplexmlelement-as-a-child-element
 * @param SimpleXMLElement $parent
 * @param SimpleXMLElement $child
 * @param bool $before
 * @return bool SimpleXMLElement added
 */
function simplexml_import_simplexml(SimpleXMLElement $parent, SimpleXMLElement $child, $before = false)
{
    // check if there is something to add
    if ($child[0] == NULL) {
        return true;
    }

    // if it is a list of SimpleXMLElements default to the first one
    $child = $child[0];

    // insert attribute
    if ($child->xpath('.') != array($child)) {
        $parent[$child->getName()] = (string)$child;
        return true;
    }

    $xml = $child->asXML();

    // remove the XML declaration on document elements
    if ($child->xpath('/*') == array($child)) {
        $pos = strpos($xml, "\n");
        $xml = substr($xml, $pos + 1);
    }

    return simplexml_import_xml($parent, $xml, $before);
}

/**
* Parse Gettext po file into array
* @param string $path
* @return array of strings from po file
**/
function parse_po_file($path){
    $oarray = array();
    if(is_file($path)){
        $postring = file_get_contents($path);
        $oarray = parse_po_string($postring);
    }
    return $oarray;
}
/**
* Parse Gettext po string into array
* @param string $postring
* @return array of strings from po file
**/
function parse_po_string($postring){
    $oarray = array();
    if(!empty($postring)){
        $strings =  preg_replace(array("/\t+\n/"), "\n", $postring);
        $strings =  preg_replace(array("/\s+\n/"), "\n", $strings);
        $strings = str_replace(array("msgid \"\"\nmsgstr","\"\n\""),array("msgid \"_PO_HEADER_\"\nmsgstr",''),$strings);
        $narray = explode("\n",$strings);
        $ikey = 0; $pkey = 0;$skey = 0; $ckey = 0;$sikey = 0;$cmkey = 0;$cikey = 0;
        $n = 0;
        for ($i=0; $i < count($narray); $i++) {
            $cmsgid = preg_match("/^msgid \"(.*)\"/",$narray[$i],$msgid);
            $cmsgidp = preg_match("/^msgid_plural \"(.*)\"/",$narray[$i],$msgidp);
            $cmsgstr = preg_match("/^msgstr \"(.*)\"/",$narray[$i],$msgstr);
            $cmsgstri = preg_match("/^msgstr\[([0-9]+)\] \"(.*)\"/",$narray[$i],$msgstri);
            //$cstr = preg_match("/^\"(.*)\"/",$narray[$i],$str);
            if($cmsgid){
                $ikey = $i;
                $n++;
            }
            if($cmsgidp){
                $pkey = $i;
            }
            if($cmsgstr){
                $skey = $i;
            }
            if($cmsgstri){
                $sikey = $i;
            }
            
            if($ikey <= $i){
                if($ikey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER']=$msgid[1];
                    } else {
                        $oarray[$n]['msgid']=$msgid[1];
                    }
                }
                if($ikey < $pkey && $pkey == $i){
                    $oarray[$n]['msgid_plural']=$msgidp[1];
                }
                if($ikey < $skey && $skey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER_STR']=explode('\n',$msgstr[1]);
                    } else {
                        $oarray[$n]['msgstr']=$msgstr[1];
                    }
                }
                if($ikey < $sikey && $sikey == $i){
                    $oarray[$n]['msgstr'][$msgstri[1]]=$msgstri[2];
                }
            }
        }
    }
    return $oarray;
}

/**
*  Return translated string from parsed po array
* @param string $msgid
* @param array $domain
* @param integer $nplurals
* @param integer $plural
* @return string Translated string or $msgid
**/
function _n_search($msgid, array $domain, $nplurals = 2, $plural = 1){
    $retstr = $msgid;
    foreach ($domain as $value) {
        if(isset($value['msgid']) && isset($value['msgstr']) && !isset($value['msgid_plural']) && !is_array($value['msgstr']))
        	if($value['msgid']==$msgid)
        		$retstr = $value['msgstr'];
        		if(isset($value['msgid']) && isset($value['msgid_plural']) && is_array($value['msgstr']))
        			foreach($value['msgstr'] as $i=>$values):
       					if($i == 0)
        					if($value['msgid']==$msgid)
        						$retstr = $value['msgstr'][0];
        				else
            				if($value['msgid_plural']==$msgid)
        						$retstr = $value['msgstr'][$plural];
    				endforeach;
    }
	return $retstr;
}
?>