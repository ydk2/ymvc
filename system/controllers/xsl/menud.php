<?php

class Menu extends XSLRender {

	public function Init() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','user','any');
		$this->current_group = 'any';
		$this->AccessMode(1);
		$this->SetModel(SYS.M.'systemdata');
		$this->only_registered(FALSE);
		if(Helper::Get('elements'.S.'menu') == '')
		$this->SetView(SYS.V . "elements".S."nav");
	}
	public function Run(){
		//$this->groups=$this->model->groups;
		$this->groups=Config::$data['layouts']['current'];
        $this->datalist=$this->model->getData(Config::$data['menu_data']);
        $this->items = $this->model->itemsData($this->datalist,$this->groups,'group');
		if(!empty($this->items))
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data>'.$this->menulist($this -> items).'</data>', null, false);
	}
	
	function menulist($data, $parent = '') {
		// <item id="0" name="1">
		$tree = '';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] === $parent) {
				$tree .= '<item id="'.$item['id'].'" url="'.htmlspecialchars($item['link']).'" name="'.$item['title'].'">' . PHP_EOL;

				$tree .= call_user_func_array(array($this, 'menulist'), array($data, strval($item['id'])));

				$tree .= '</item>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "";
		return $tree;
	}


	public function Exception(){
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