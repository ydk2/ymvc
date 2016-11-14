<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Helpers functions
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
 * @subpackage Functions
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.5.11
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */
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
    $node = dom_import_simplexml($parent);
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

function build_sorter($key) {
	return function($a, $b) use ($key) {
		return strnatcmp($a[$key], $b[$key]);
	};
}

?>