<?php

class Pagination extends Render {
	public $items=array();
	public $groups;
	public $limit = 10;
	public $link = HOST;
	public $offset = 1;
	public $getstr = 'p';
    public static function Config() {
        return array(
        'title'=>'Pagination menu',
        'access_groups'=>array(),
        'view'=>"",
        'access_mode'=>0,
        'model'=>NULL,
		'only_registered_views'=>FALSE
        );
    }
	public function Init() {
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array();
		$this->current_group = '';
		$this->AccessMode(0);
		$this->SetModel(SYS.M.'systemdata');
		$this->only_registered(FALSE);
	}
	public function Run(){
		$this->offset = (helper::get($this->getstr)=='')?1:intval(helper::get($this->getstr));

		$this->paginate_count($this->items);
	}

    public function paginate_list($array=array()){
		$lenght = count($array);
		$end = ceil($lenght/$this->limit);
		return array_slice($array,($this->offset-1)*$this->limit,$this->limit);
    }

    public function paginate_count($array=array()){
		$lenght = count($array);
		$this->lenght = ceil($lenght/$this->limit);
    }

	public function Exception(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		//$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		//$error->setParameter('','inside','yes');
		//$error->setParameter('','show_link','no');
		$this->ViewData('header', Intl::_p('Warning!!!'));
		$this->ViewData('text', Intl::_p('Warning!!!').' '.$this->error);
		$this->ViewData('link', HOST);
		return $this->subView(SYS.V."elements-msg");
	}

}
?>