<?php
namespace System\Helpers;
/**
 * @author ydk2
 */
class X2A {
    const _ARRAY = 1;
    const _XML = 2;
    const _JSON = 3;
    private $arg,$node,$tmpout;
    private $tmp = array();
    private $ToArray;
    private $xmldata;
    private $name;
    private $root;
    protected $out;
    private $type;
    protected $i = 0;
    public $json,$xml,$array;

    function __construct($arg=NULL) {
        try {
        if ($arg != NULL) {
       If(is_array($arg)){
		   $this->type = self::_ARRAY;
            $this->out =  $this->ToXML($arg);
        } 
       If(is_object($arg)){
		   $this->type = self::_ARRAY;
		   $json = json_decode(json_encode($arg),TRUE);
            $this->out =  $this->ToXML($json);
        } 
		If(is_string($arg)) {
		   $this->type = self::_XML;
            $this->out =  $this->ToArray($arg);
        }
        }
    	return $this->out;
        } catch (\Exception $e) {
           // trigger_error("'Caught exception: ',". $e->getMessage(),E_USER_ERROR);
            return FALSE;
        }
    }
    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
        clearstatcache();
    }
    final private function _getattr(array $attrlist=array())
    {
        $this->arg = NULL;       
                foreach ($attrlist as $attrname => $attrvalue) {
                    if ($attrname == 'style' && is_array($attrvalue)) {
                        $this->arg .= "style=\"";
                            foreach ($attrvalue as $stylename => $stylevalue) {
                            $this->arg .= "$stylename:$stylevalue;";
                            }
                        $this->arg .= "\" ";
                    } else $this->arg .= "$attrname=\"$attrvalue\" ";
            } // end foreach
           return (string) trim($this->arg);       
    }

   final public function ToXML($arg) {
        $tmp = array(NULL,NULL,NULL,NULL);
        $tmparray = array();
        if(is_array($arg)){
        foreach ($arg as $key => $tagname) {
            $tmp[0] = $key;
        if (is_array($tagname)) {
        $i = 0;
        foreach ($tagname as $tagkey => $tagvalue) {
            if ($tagkey === "@attributes") {
                $tmp[1] = $this->_getattr($tagvalue);
            } // @attributes
           elseif ($tagkey !== "@attributes") {
                      if (!is_int($tagkey)) {
                        $tmp[3] .= call_user_func_array(array($this, 'ToXML'), array($tagname));//$this->a2x($tagvalue); 
                      } else {
                        $tmp[3] .= call_user_func_array(array($this, 'ToXML'), array($tagvalue));//$this->a2x($tagvalue);  
                      }
            }
        }
        } else {
          $tmp[3] .= $tagname;
        }
        
        } // end foreach 1
        $tmp[2] = ((trim($tmp[3])==NULL) /*&& ($this->node != '')*/)?"/>":">".$tmp[3]."</{$tmp[0]}>";
        $tmp[4] = (!isset($tmp[1]))?NULL:" ".trim($tmp[1]);
        $out = "<".trim($tmp[0].$tmp[4])."".$tmp[2];
        unset($tmp);
        } else {
            $out = $arg;
        }
        /*
        $this->i++;
        if (($this->i) > 200) {
            throw new \Exception('Memory limit.');
        }
         * 
         */
        if ($this->out == null || $this->out == "") {
            $this->out = (string) $out;
            //$this->out();
        }
        return (string) $out;
    }
     final public function ToArray($xml) {
     try {
             $this->ToArray = xml_parser_create ();
             xml_set_object($this->ToArray,$this);
             xml_set_element_handler($this->ToArray, "tagOpen", "tagClosed");
             xml_set_character_data_handler($this->ToArray, "tagData");
             $this->xmldata = xml_parse($this->ToArray,$xml );
             if(!$this->xmldata) {
                 throw new \Exception("error: ".xml_error_string(xml_get_error_code($this->ToArray))." at line ".xml_get_current_line_number($this->ToArray));
             }
             xml_parser_free($this->ToArray);
             $out[$this->root] = $this->tmp[0];
            if ($this->out == null || $this->out == "") {
                $this->out = (array) $out;
                //$this->out();
            }
             return (array) $out;
             } catch (\Exception $e) {
            //trigger_error("LITTLEXML ". $e->getMessage(),E_USER_NOTICE);
			return FALSE;
            //exit;    
            }
     }
     final private function tagOpen($parser, $name, $attrs) {
        $this->name = $name;
        $tag=array("@name"=>strtolower($name),"@attributes"=>array_change_key_case($attrs));
        array_push($this->tmp,$tag);
    }
     final private function tagData($parser, $tagData) {
        if(trim($tagData)) {
             if(isset($this->tmp[count($this->tmp)-1]['tagData'])) {
                 $this->tmp[count($this->tmp)-1][] .= $tagData;
             } 
             else {
                 $this->tmp[count($this->tmp)-1][] = $tagData;
             }
        }
     }
     final private function tagClosed($parser, $name) {
         $a =$this->tmp[count($this->tmp)-1]['@name'];
         $this->root = $this->tmp[key($this->tmp)]['@name'];
         unset($this->tmp[count($this->tmp)-1]['@name']);
        $this->tmp[count($this->tmp)-2][][strtolower($a)] = array_change_key_case($this->tmp[count($this->tmp)-1]);
        
        array_pop($this->tmp);
     }
	 final public function Save($arg=NULL)
	 {
        if ($arg != NULL) {
       If(is_array($arg)){
		   $this->type = self::_ARRAY;
           $this->out =  $this->ToXML($arg);
        } 
       If(is_object($arg)){
		   $this->type = self::_ARRAY;
		   $json = json_decode(json_encode($arg),TRUE);
        	$this->out =  $this->ToXML($json);
        } 
		If(is_string($arg)) {
		   $this->type = self::_XML;
        	$this->out =  $this->ToArray($arg);
        }
		
      }
    	return $this->out;
	 }
    final public static function Convert($arg=NULL) {
		$out = new X2A($arg);
        return $out->Save();
    }
    final public function Close()
    {
        $this->__destruct();
        return 0;  
    }
}
?>