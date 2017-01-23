<?php

class Menu extends XSLRender {

	public function onInit() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','user','any');
		$this->current_parent = 'any';
		$this->AccessMode(1);
		$this->SetModel(SYS.M.'menudata');
		$this->only_registered(FALSE);
		if(Helper::Get('admin:menu') == '')
		//$this->SetView(SYS.V . "elements:nav");
		$this->Inc(SYS.M.'model');
	}
	public function onRun()
	{

		//$this->parent=$this->model->groups;
		$this->layout_parent=Config::$data['layouts']['current'];
		$this -> items = $this -> model -> get_menu($this->layout_parent);
		
		//$this->layout_parent=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		//var_dump($this->menulist($this -> items));
		if(!empty($this->items))
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data>'.$this->menulist($this -> items).'</data>', null, false);
	}
	
	function menulist($data, $parent = '') {
		// <item id="0" name="1">
		$tree = '';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] === $parent) {
				$tree .= '<item id="'.$item['pos'].'" url="'.htmlspecialchars($item['link']).'" name="'.$item['title'].'">' . PHP_EOL;

				$tree .= call_user_func_array(array($this, 'menulist'), array($data, strval($item['pos'])));

				$tree .= '</item>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "";
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
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

}
?>