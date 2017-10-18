<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
//namespace Library\Core;


class mainController
{
    public $array;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $mode;
    public $access;
    public $current_group;
    public $access_groups;


    private $name;

    public $model;

    protected $data;
    private $view;
    protected $error;


    public function __construct($theme = NULL)
    {
        $this->data = new Data();
        $this->name = get_class($this);
        $this->path = dirname(__FILE__);
        $this->view = str_replace('controllers', 'views', strtolower($this->path));

        $this->view = str_replace(strtolower(ROOT.DIRECTORY_SEPARATOR),'',$this->view);

        if ($theme != NULL && $theme != "") {
            $this->view = $this->view . DIRECTORY_SEPARATOR . $theme;
        }

        $this->strip = explode(DIRECTORY_SEPARATOR, $this->name);
    }

    function View($view, $ext = ".php")
    {
        try {
            ob_start();
            $this->view = $view;
            $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $view) . $ext);
            if (file_exists($filename) && is_file($filename)) {
                require ($filename);
            }
            return ob_get_clean();
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
            $controller = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR . $controller));
            if ($this->Inc($controller,$ext)) {
                $stack = explode(DIRECTORY_SEPARATOR, $controller);
                $end = end($stack);
                if (!class_exists($end)) return NULL;
                $a = func_get_args();
                array_shift($a);
                $new = new ReflectionClass($end);
                $object = $new->newInstanceArgs($a);
                return $object;
            }
        }
    }
    /**
     * Method return a new class 
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
            $class = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR . $class));
            if ($this->Inc($class,$ext)) {
                $stack = explode(DIRECTORY_SEPARATOR, $class);
                $end = end($stack);
                if (!class_exists($end)) return NULL;
                $a = func_get_args();
                array_shift($a);
                $new = new ReflectionClass($end);
                $object = $new->newInstanceArgs($a);
                return $object;
            }
        }
    }

    function Inc($class, $ext = ".php")
    {
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class) . $ext);
        if (file_exists($filename) && is_file($filename)) {
            require_once ($filename);
            return TRUE;
        }
        return FALSE;
    }
    public function Show()
    {
        //$this->ViewData('testing', 'ddd');
        echo $this->View($this->view, '.html');
    }

    public function throwError($message = '', $code = 0)
    {
        throw new Exception($message, $code);
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

}
?>