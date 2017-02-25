<?php

class Pagination extends Render {
	public $items=array();
	public $groups;
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
		if(!isset($this->groups) && $this->groups==""){
            $this->groups=Config::$data['layouts']['current'];
        }
        //$this->datalist=$this->model->getData(Config::$data['modules_data']);
        //$this->items = $this->model->itemsData($this->datalist,$this->groups,'group');
		$this->paginate_count($this->items);
	}

    public function paginate_list($array=array(),$offset=0,$limit=10){

    }

    public function paginate_count($array=array(),$limit=10){
		$lenght = count($array);
		$end = ceil($lenght/$limit);
		$start = (helper::get('p')=='')?0:intval(helper::get('p'));
		$this->lenght = array_slice($array,$start,$limit);

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