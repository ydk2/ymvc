<?php

class Admin extends PHPRender {
	//    public $model;
	//	public $view;
	public $header;
	public $footer;
	public $heading;

	public function onInit() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		//$this -> register(CONTROLLER . 'index', $model, VIEW . 'menu');
		//$this -> showme();
		$c = array(
		array(
			array(SYS.C.'template/header',SYS.M,$this -> model -> template),
			array(SYS.C.'admin/header',SYS.M,SYS.V.'admin/header'),
		),
		array(
			array(SYS.C.'template/footer',SYS.M,$this -> model -> template),
		),
		array(
			array(SYS.C.'account',SYS.M,SYS.V.'account'),
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
	$a=array('admin','data','action','item');
	$this->page = (router::sys_from_get($a)=='')?router::from_array($value[2]):router::sys_from_get($a);	
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