<?php
namespace Application\controller;
use \System\core\Router as router;
use \System\controller\template as template;

class index extends \System\core\controller {
	//    public $model;
	//	public $view;
	public $header;
	public $footer;
	public $heading;

	public function __construct($model, $view) {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		 
		parent::__construct($model, $view);
		
		//$this -> register(CONTROLLER . 'index', $model, VIEW . 'menu');
		//$this -> showme();
		$c = array(
		array(
			array(SCONTROLLER.'template/header',MODEL,$this -> model -> template),
			array(CONTROLLER.'header',MODEL,VIEW.'header'),
			array(CONTROLLER.'menu/main',MODEL,VIEW.'menu/top'),
		),
		array(
			//array(CONTROLLER.'table',MODEL,VIEW.'table'),
			//array(CONTROLLER.'view',MODEL,VIEW.'view'),
			//array(CONTROLLER.'aside',MODEL,VIEW.'aside'),
			array(SCONTROLLER.'template/footer',MODEL,$this -> model -> template),
		),
		array(
			array(CONTROLLER.'pages',MODEL,VIEW.'page'),
		),
		array(
			array(CONTROLLER.'aside',MODEL,VIEW.'aside'),
		)
		);

		$this->app($c);
	}
public function app($value=array())
{
	$this->top($value);
	$this->page($value);
	$this->bottom($value);
}
public function top($value=array())
{
	$this->top = router::from_array($value[0]);
}
public function page($value=array())
{
	$a=array('index','data','action','item','page');
	$this->page = (router::app_from_get($a)=='')?router::from_array($value[2]):router::app_from_get($a);	
}
public function aside($value=array())
{
	$this->aside = router::from_array($value[3]);	
}
public function bottom($value=array())
{
	$this->bottom = router::from_array($value[1]);
}

}
?>