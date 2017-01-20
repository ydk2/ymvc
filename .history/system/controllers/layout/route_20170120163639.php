<?php
class Route extends XSLRender {
	
	public function Init(){
		//call in __constructor
		$this->SetModel(SYS.M.'model');
		$this->exceptions = TRUE;
		$this->registerPHPFunctions();
		
		$this->only_registered(FALSE);
		$this->RegisterView(SYS.V."layouts".S."content");
		$this->RegisterView(SYS.V.'errors'.DS.'error');
		
		$this->setaccess(self::ACCESS_ANY);
		$this->AccessMode(1);
		$this->global_access = Helper::Session('user_access');
		$this->current_group = (Helper::Session('user_role')!="")?Helper::Session('user_role'):'any';
		$this->SetView(SYS.V."layouts".S."content");

	}
	
	public function onEnd(){
		// 		call after render view
				return TRUE;
	}
	
	public function Destruct(){
		// 		call in __destructor
				return TRUE;
	}
	
	public function Exception(){
		$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
		$this->exception->setParameter('','inside','yes');
		$this->exception->setParameter('','show_link','yes');
		$this->exception->ViewData('title', Intl::_p('Error!!!'));
		$this->exception->ViewData('header', Intl::_p('Error!!!').' '.$this->error);
		$this->exception->ViewData('alert',Intl::_p($this->emessage)." ");
		$this->exception->ViewData('error', $this->error);
		return $this->exception->View();
	}

	public function Run($model = NULL){

		$this->model->disabled = array('error','errors','data','index','item','action','load','access'); 

		$this->model->registered = array("route"); 
		$this->model->enabled = Config::$data['enabled'];
		$this->model->layout_group = 'route';
        if(!isset($this->model->layout_data) || $this->model->layout_data==''){
          $this->model->layout_data=Config::$data['layout_data'];
        }
		if(!file_exists(ROOT.SYS.STORE.$this->model->layout_data)){
			throw new SystemException(Intl::_('Error file not exists'),90404);
		}
		$items = json_decode(file_get_contents(ROOT.SYS.STORE.$this->model->layout_data),true);
		if (empty($items)){
		    throw new SystemException(Intl::_("Error can't find default entries"),90201);
		}
		$this->model->default = $items;

		$i = 2;
		foreach ($_GET as $key => $value) {
		if(!in_array($key,$this->model->disabled)){
			$this->model->layouts[] = array('pos' => $i++, 'name'=>'FromRoute_'.$key,'module'=>$key,'view'=>$value,'class'=>'col-sm-12','attrid'=>'', 'users'=>'', 'group'=>'route', 'mode'=>$this->model->mode);
		}
		}
		//$this->router();
		$this->contents();		
		if($this->ViewData('content')==""){
			$this->model->layouts = $this->model->default;
			//$this->router();
			$this->contents();
		}


	}

	protected function contents() {
		$this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
		$content = $this->GetModule(SYS.C.'layout'.S.'layout');
		$contents = ($content)? $content->View():"";
		$this->ViewData('content', htmlspecialchars($contents));
	}
	protected function router() {
		$content = Loader::Layouts($this->model);
		$contents = ($content)? $content:"";
		$this->ViewData('content', htmlspecialchars($contents));
	}
	protected function menus(){
        return "";
	}
	protected function header(){
        return "";
	}
	protected function footer(){
        return "";
	}

}
?>