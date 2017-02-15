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
		$this->SetModel(SYS.M.'menudata');
		$this->only_registered(FALSE);
		if(Helper::Get('admin'.S.'menu') == '')
		//$this->SetView(SYS.V . "elements:nav");
		$this->Inc(SYS.M.'model');
	}
	public function Run()
	{

		//$this->groups=$this->model->groups;
		$this->groups=Config::$data['layouts']['current'];

        $this->datalist=unserialize(file_get_contents(ROOT.STORE.'menus.data'));
        $this->items = array();

        if(!empty($this->datalist)){
            foreach ($this->datalist as $entry) {
                if($entry['group']==$this->groups){
                    $this->items[]=$entry;
                }
            }
        }
		var_dump($this->groups);
		//$this -> items = $this -> model -> get_menu($this->groups);
		
		//$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
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