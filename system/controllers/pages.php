<?php
namespace System\controller;
use \System\core\Router as Router;
use \System\helpers\Intl as Intl;

class pages extends \System\core\controller {


	public function __construct($model, $view) {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		$this -> access = $this::ACCESS_EDITOR;
		//Router::sessionset('user_role','any');
		parent::__construct($model, $view);
	}
}
?>