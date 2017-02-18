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

        $this->datalist=$this->model->getData(Config::$data['menu_data']);

        $this->items = $this->model->itemsData($this->datalist,$this->groups,'group');
        //$this->mainitems = $this->model->itemsData($this->datalist,Config::$data['mainitems'],'group');

		//$this -> items = $this -> model -> get_menu($this->groups);
		
		//$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		//var_dump($this->menulist($this -> items));
		if(!empty($this->items))
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data>'.$this->menulist($this -> items).'</data>', null, false);
	}
	

    public function menu($data, $parent = '') {

        $tree = '<ul>';

        foreach ($data as $item) {
            if ($item['parent'] === $parent) {
                $tree .= '<li>'. PHP_EOL;
                $tree .= '<a href="'.htmlspecialchars($item['link']).'">' .$item['title']. PHP_EOL;
                $tree .= '</a>' . PHP_EOL;
                $tree .= '</li>' . PHP_EOL;
            }
        }
        $tree .= "</ul>";
        return $tree;
    }

    public function items($data, $parent = '') {
		$ul=array();
        foreach ($data as $item) {
            if ($item['parent'] === $parent) {
				$ul[]=$item;
            }
        }
        return $ul;
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