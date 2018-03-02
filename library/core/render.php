<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use 
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * For more information on the YMVC project, 
 * please see <http://ydk2.tk>. 
 *   
 **/


namespace Library\Core;


class Render
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

    protected $data;
    
    protected $use_errors;
    protected $view;
    protected $error;

	/**
	 * $obj
	 * @static
	 * @var Render ref
	 */
	private static $obj;
	
    /**
     * __construct
     *
     * @param mixed $model
     * @return void
     */
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

        $this->use_errors = (isset($this->model->use_errors))?TRUE:FALSE;
        
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

 /**
  * isEnabled
  *
  * @param mixed $g=FALSE
  * @return void
  */
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
* @param string $view Optional normally set in constructor or Init
* @return string HTML output
**/
final public function xViews($view=NULL) {
    try {
        if($view!=NULL) {
            $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $view) . $this->ext);
            if (file_exists($filename) && is_file($filename)) {
                
                $xsl = new \DOMDocument();
                $xsl->substituteEntities = TRUE;
                $xsl->loadXML(file_get_contents($filename));
				$xsl->documentURI = $filename;

				$xml = "<data/>";
				$name = $this->name;

				$data = $this->simple_xml($xml);
                //$xpath = new \DomXpath($xsl);
				//$search = $xpath->query('//xsl:param[@name="controller"]')[0]->nodeValue;
                $search = $xsl->getElementsByTagName("controller")->item(0);
				$controller = (isset($search))?$search->getAttribute("path"):NULL;
                if($controller){
					$runner = $this->Controller($controller,$this->model);
					if($runner !== NULL){
						$name = $runner->name;
						self::$obj =& $runner;
						$this->to_simple($runner->data,$data);
					} else {
						$this->to_simple($this->data,$data);
					}
				} else {
					self::$obj =& $this;
					$this->to_simple($this->data,$data);
				}
                $proc = new \XSLTProcessor;
                $proc->registerPHPFunctions();
                $proc->importStylesheet($xsl);
				$proc->setParameter('', 'self', $name.'::Call');
				$proc->setParameter('', 'parent', $this->name.'::Call');

                $retval = $proc->transformToXML($data);
                return $retval;
            } else {
                $this->error = 20404;
                if($this->use_errors) throw new SystemException("View not exists", 20404);
                return "";
            }
        } else {
            $this->error = 20405;
            if($this->use_errors) throw new SystemException("View is empty string", 20405);
            return "";
        }
    } catch(SystemException $e){
        $this->error = $e->Code();
        return $e->Message();    
    }
}

 /**
  * Views
  *
  * @param mixed $view
  * @return void
  */
final public function pViews($view)
{
    try {
        ob_start();
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $view) . $this->ext);
        if (file_exists($filename) && is_file($filename)) {
            
            $viewdata = array();
            if(isset($this->data)){
                foreach ($object->data as $key => $value) {
                    $viewdata[$key] = $value;
                }
            }
            require_once($filename);
        } else {
            $this->error = 20404;
            if($this->use_errors) throw new SystemException("View not exists", 20404);
            return "";
        }
        return ob_get_clean();
    } catch (SystemException $e) {
        $this->error = $e->Code();
        return $e->Message();
    }
}

 /**
  * View
  *
  * @param mixed $view=NULL
  * @return void
  */
final public function View($view=NULL)
{
    if($view==NULL){
		$view = $this->view;
	} else {
        $this->view = $view;
    }
	$array = explode('.', $view);
	$ext = end($array);
	if($this->ext == ".xsl" || ($this->ext == ""|NULL && $ext == "xsl")){
		return $this->xViews($view);
	} else {
		return $this->pViews($view);
	}
}

 /**
  * Show
  *
  * @param mixed $view=NULL
  * @return void
  */
final public function Show($view=NULL)
{
	echo $this->View($view);
}

/**
* Method return a new controller view
* @access public
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return Render object
**/
public final function Controller($controller)
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
public final function Object($class)
{
    if (is_object($class)) {
        return $class;
    }
    else {
        $ext = '.php';
        $path= strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR,  $class));
        $class = strtolower(str_replace(array('\\', '/'), '\\',  $class));
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

/**
* Method return a new controller view data
* @access public
* @param mixed $path Can be XSLRender or PHPRender object or path
* @return Render->ViewData object
**/
public final function Page($path)
{
    $object = call_user_func_array([$this,'Object'],func_get_args());
    $data = array();
    if($object !== NULL && isset($object->data)){
        foreach ($object->data as $key => $value) {
            $data[$key] = $value;
        }
    }
    return $data;
}
 /**
  * Inc
  *
  * @param mixed $class
  * @return void
  */
final public function Inc($class)
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class));
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
        return TRUE;
    }
    return FALSE;
}

final static public function Loader($class, $ext = ".php")
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class) . $ext);
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
    }
}

 /**
  * throwError
  *
  * @param mixed $message
  * @param mixed $code
  * @return void
  */
final public function throwError($message = '', $code = 0)
{
    throw new SystemException($message, $code);
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

/**
* Method Call existing method in this class or child from XSLTProcessor
* @access public
* @param string $method Call existing method in this class from XSLTProcessor
* @param mixed $arguments Multiple arguments ... 
* @return mixed Result from called method
**/ 	
final public static function Call($method){
	$parameters = func_get_args(); 
	array_shift($parameters);
	//$a = self::$obj->name."::".$method;
	if(self::$obj !== NULL && method_exists(self::$obj, $method))
	return call_user_func_array(array(self::$obj, $method), $parameters);
}

/**
 * to_xml
 *
 * @param Array or Object $data
 * @param SimpleXMLElement &$xml_data
 * @return void
 */
protected function to_simple( $data, \SimpleXMLElement &$xml_data ) {
    foreach( $data as $key => $value ) {
        if(is_array($value) ) {
            
            if( is_numeric($key) ){
                $key = 'child-'.$xml_data->getName().'';
            }
            if($key !== '@attributes') {
                $subnode = $xml_data->addChild($key);
                call_user_func_array(array($this,__FUNCTION__),array($value,$subnode));
            }
            if($key === '@attributes') {
                $this->to_attr($value,$xml_data);
            } 
            
        } else {
            if($key !== '@attributes') {    
                if( is_numeric($key) ){
                    $key = 'node-'.$xml_data->getName().'';
                }
                $xml_data->addChild($key,htmlspecialchars($value));
            }
        }
	} 
}

/**
 * to_attr
 *
 * @param mixed $data
 * @param SimpleXMLElement &$xml_data
 * @return void
 */
private function to_attr( $data, \SimpleXMLElement &$xml_data ) {
    foreach( $data as $key => $value ) {
        $xml_data->addAttribute($key,htmlspecialchars($value));
	} 
}

/**
 * array_to_simple
 * @param mixed $array 
 * @param mixed $root='data' 
 * @return SimpleXMLElement 
 */
public function array_to_simple($array,$root='<data/>'){
    try {
        $xml_data = $this->simple_xml($root);
        $this->to_simple($xml_data,$array);
        return $xml_data;
    } catch(SystemException $e){
        return NULL;
    }
}
/**
 * to_xml
 * @param mixed $array 
 * @param mixed $root='data' 
 * @return String xml string 
 */
public function to_xml($array,$root='<data/>'){
    try {
        $xml_data = $this->simple_xml($root);
        $this->to_simple($xml_data,$array);
        return $xml_data->asXml();
    } catch(SystemException $e){
        return NULL;
    }
}
/**
 * simple_xml
 * @param array $root='data' 
 * @return SimpleXmlElement 
 */
public function simple_xml($root='<data/>'){
    try {
        $xml_data = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.$root.'', null, false);
        return $xml_data;
    } catch(SystemException $e){
        return NULL;
    }
}

/**
 * get
 * @param mixed $val 
 * @return mixed 
 */
public function get($val)
{
    if (isset($_GET[$val]) && $_GET[$val] != '') {
        return $_GET[$val];
    }
    else {
        return FALSE;
    }
}

/**
 * post
 * @param mixed $val 
 * @return mixed 
 */
public function post($val)
{
    if (isset($_POST[$val]) && $_POST[$val] != '') {
        return $_POST[$val];
    }
    else {
        return FALSE;
    }
}

/**
 * Request
 * @param mixed $val 
 * @return mixed 
 */
public function request($val)
{
    if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
        return $_REQUEST[$val];
    }
    else {
        return FALSE;
    }
}

/**
 * Route
 * @param mixed $app not null
 * @param mixed $action 
 * @param mixed $default 
 * @return string 
 */
public function Route($app=NULL,$action=NULL,$default=NULL){
    try {
        $route = $this;
        if(!$this->is($app)) return 'Runtime Error Application not defined';
        $app = $app.'/';
        $default = ($this->is($default))?$app.$default:FALSE;
        $view = ($this->get($action))?$app.$this->get($action):$default;
        if($view && $view!=$this->view){
            $actions = $this->View($view);
        } else {
            $actions = '';
        }
        return $actions;
    } catch(SystemException $e){
        return $e->Message();
    }

}
/**
 * value check
 * @param mixed $value 
 * @return boolean 
 */
public function is($value){
    if(!isset($value) || $value == '' || $value==FALSE || empty($value)) return FALSE;
    return TRUE;
}
}
?>