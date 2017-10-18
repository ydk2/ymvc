<?php

class Test extends PHPRender {

	public function onInit() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);
		$this->RegisterView(SYS.V.'test');
		$this->SetView(SYS.V.'test');

		$this->SetModel(SYS.M.'model');
		$this ->tests();
		//echo 'rrrr';
		//$db = new Model(TRUE);
		//$db->import = TRUE;
		//var_dump($db);
	}
	public function onRun()
	{
		//$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		//$this -> set_changes();
		//var_dump(get_called_class());
		//var_dump(debug_backtrace());
	}
	public function tests($view='')
	{
		//$t = new Menus($view);
		//return $this->View();
	}
	function lista($data, $parent = '') {
		$tree = '<ul>';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] == $parent) {
				$tree .= '<li>' . $item['title'] . ':' . $parent . ' @:' . $item['link'];

				$tree .= call_user_func_array(array($this, 'lista'), array($data, $item['title']));
				//call_user_func('show_list',$data, $i);

				$tree .= '</li>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "</ul>";
		return $tree;
	}

	public function onException(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Try get more privilages').' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

}
?>