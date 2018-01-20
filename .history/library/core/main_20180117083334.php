<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-01-21 22:00:35
*/
namespace Library\Core;


class Main
{
    public $enabled;
    
    public $mode;
    public $uid;
    protected $access;
    public $guid;
    protected $groups;
    
    
    private $name;
    
    public $model;
    public $ext;
    
    public $data;
    protected $view;
    protected $error;
    
    
    public function __construct($model = NULL)
    {
        $theme = null;
        $this->model = $model;
        if(isset($this->model->enabled)){
            $this->enabled = $this->model->enabled;
        }
        if(isset($this->model->theme)){
            $theme = $this->model->theme;
        }
        if(isset($this->model->ext)){
            $this->ext = $this->model->ext;
        } else {
            $this->ext = "";
        }
        
        if(isset($this->model->mode)) $this->mode = $this->model->mode;
        if(isset($this->model->uid)) $this->uid = $this->model->uid;
        if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->data = new Data();
        $this->name = get_class($this);
        
        if(class_exists('ReflectionClass')){
            $ref = new \ReflectionClass($this->name);
            $this->path = dirname($ref->getFileName());
        } else {
            $included_files = get_included_files();
            foreach ($included_files as $filename) {
                if( stripos( $filename, $this->name.'.php' ) !== false ){
                    $this->path = dirname($filename);
                    break;
            }
        }
    }
    
    $spath = str_replace(strtolower(ROOT), '', strtolower($this->name));
    $spath = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $spath));
    $this->strip = explode(DIRECTORY_SEPARATOR, $spath);
    
    $vpath = array();
    foreach ($this->strip as $key => $value) {
        if ($value == 'controllers') {
            $vpath[] = 'views';
            if ($theme != NULL && $theme != "") {
                $vpath[] = $theme;
            }
        } else {
            $vpath[] = $value;
        }
    }
    $this->view = DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$vpath);
}

/**
* Internal helper method to check access or reset it.
* @param Integer $m
* @param Integer OR String $acc
* @param Integer OR Array $gacc
* @param BOOLEAN $g Default FALSE
* @access public
* @return BOOLEAN
**/
final public function GetAccess($m=NULL,$g=FALSE){
    
    if($m == NULL){
        $m = $this->mode;
    } else {
        $this->mode = $m;
    }
    
    if($this->error == 20403){
        if($g) $this->error = 0;
    }
    
    switch ($m) {
        case 0:
            return TRUE;
            break;
        
        case 1:
            $gacc = $this->uid;
            $acc = $this->access;
            if($gacc > $acc){
                if($g) $this->error = 20403;
                return FALSE;
        }
        return TRUE;
        break;
    
    case 2:
        $gacc = $this->guid;
        $acc = $this->groups;
        if(!empty($acc) && !in_array($gacc,$acc)){
            if($g) $this->error = 20403;
            return FALSE;
    }
    return TRUE;
    break;

default:
    return TRUE;
    break;
}
}

final public function isEnabled($g=FALSE){
    $item = strtolower(str_replace(array('\\', '/'), "/", $this->name));
    if($this->error == 20402){
        if($g) $this->error = 0;
    }
    
    $acc = $this->enabled;
    if(!empty($acc) && !in_array($item,$acc)){
        if($g) $this->error = 20402;
        return FALSE;
    }
    return TRUE;
}

/**
* Method used to get, render and return controller sub view as string
* @access public
* @param string $path Optional normally set in constructor or Init
* @return string HTML output
**/
final public function xView($view=NULL) {
    try {
        if($view!=NULL) {
            $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $view) . $this->ext);
            if (file_exists($filename) && is_file($filename)) {
                
                $xsl = new \DOMDocument();
                $xsl->substituteEntities = TRUE;
                $xsl->loadXML(file_get_contents($filename));
                $xsl->documentURI = $filename;

                $xpath = new \DomXpath($xsl);
				$controller = (isset($xpath->query('//xsl:param[@name="controller"]')[0]))?$xpath->query('//xsl:param[@name="controller"]')[0]->nodeValue:NULL;
				if($controller){
					$runner = $this->newController($controller,$this->model);
					
					$data = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>', null, false);
					$this->to_xml($runner->data);
				}

                $proc = new \XSLTProcessor;
                $proc->registerPHPFunctions();
                $proc->importStylesheet($xsl);

                //$controller = $proc->getParameter('', 'content');

                $retval = $proc->transformToXML($data);
                var_dump($data);
                return $retval;
            } else {
                return "";
            }
        } else {
            return "";
        }
    } catch(\Exception $e){
        var_dump($e);    
    }
}

final public function Views($view)
{
    try {
        ob_start();
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $view) . $this->ext);
        if (file_exists($filename) && is_file($filename)) {
            require_once($filename);
        } else {
            $this->error = 20404;
        }
        return ob_get_clean();
    } catch (\Exception $e) {
        $this->error = $e->getCode();
        return $e->getMessage();
    }
}

final public function View($view=NULL)
{
    if($view==NULL)
    return $this->Views($this->view);
    else
        return $this->Views($view);
}

final public function Show($view=NULL)
{
    if($view==NULL)
    echo $this->Views($this->view);
    else
        echo $this->Views($view);
}

/**
* Method return a new controller view
* @access public
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return Render object
**/
public final function newController($controller)
{
    if (is_object($controller)) {
        return $controller;
    }
    else {
        $ext = '.php';
        $path= strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR,  $controller));
        $controller = strtolower(str_replace(array('\\', '/'), '\\',  $controller));
        if ($this->Inc($path.$ext)) {
            if (!class_exists($controller)) return NULL;
            $a = func_get_args();
            array_shift($a);
            $new = new \ReflectionClass($controller);
            $object = $new->newInstanceArgs($a);
            return $object;
        }
        return NULL;
    }
}

/**
* Method return a new controller view
* @access public
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return Render object
**/
public final function newClass($class)
{
    if (is_object($class)) {
        return $class;
    }
    else {
        $ext = '.php';
        $path= strtolower(str_replace(array('\\', '/'), '\\',  $class));
        if ($this->Inc($path.$ext)) {
            if (!class_exists($class)) return NULL;
            $a = func_get_args();
            array_shift($a);
            $new = new \ReflectionClass($class);
            $object = $new->newInstanceArgs($a);
            return $object;
        }
    }
}

final public function Inc($class)
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class));
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
        return TRUE;
    }
    return FALSE;
}

final public function throwError($message = '', $code = 0)
{
    throw new \Exception($message, $code);
}

/**
* Get or Set data to views
* @access  protected
* @param string $name Name of element
* @param mixed $value Optional new value for given name
* @return mixed Value for name
**/
final protected function ViewData()
{
    $argsv = func_get_args();
    $argsc = func_num_args();
    
    if ($argsc == 1) {
        $name = $argsv[0];
        if ($name == '') {
            return '';
        }
        return (isset($this->data->$name)) ? $this->data->$name : '';
    }
    if ($argsc == 2) {
        $name = $argsv[0];
        $value = $argsv[1];
        if ($name == '') {
            return '';
        }
        $this->data->$name = $value;
        return (isset($this->data->$name)) ? $this->data->$name : '';
    }
    return '';
}

function to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_numeric($key) ){
			if($key != 0) $key = $key;
        }
        if( is_array($value) ) {
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
     }
}

}
?>