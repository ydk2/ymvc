<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace Library\Core;


class Render
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
    protected $view;
    protected  $error;


    public function __construct($theme=NULL)
    {
        $this->data = new Data();
        $this->name = get_class($this);
        $this->view = str_replace('controllers', 'views', strtolower($this->name));

        if($theme!=NULL && $theme!=""){
            $this->view = $this->view.DIRECTORY_SEPARATOR.$theme;
        }

        $this->strip = explode(DIRECTORY_SEPARATOR,$this->name);
    }

    function View($view, $ext = ".php")
    {
        ob_start();
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $view) . $ext);
        if (file_exists($filename) && is_file($filename)) {
            require ($filename);
        }
        return ob_get_clean();
    }

    public function Run()
    {
        //$this->ViewData('testing', 'ddd');
        echo $this->View($this->view, '.html');
    }


/**
* Get or Set data to views
* @access  protected
* @param string $name Name of element
* @param mixed $value Optional new value for given name
* @return mixed Value for name
**/
	final protected function ViewData() {
		$argsv = func_get_args();
		$argsc = func_num_args();

		if($argsc == 1){
			$name=$argsv[0];
			if($name==''){
				return '';
			}
			return (isset($this ->data->$name)) ? $this ->data->$name : '';
		}
		if($argsc == 2){
			$name=$argsv[0];
			$value=$argsv[1];
			if($name==''){
				return '';
			}
			$this->data->$name = $value;
			return (isset($this->data->$name)) ? $this->data->$name: '';
		}
		return '';
	}

}
?>