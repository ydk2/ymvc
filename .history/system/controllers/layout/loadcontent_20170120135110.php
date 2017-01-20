<?php
class LoadContent extends XSLRender {
	
	public function Init(){
		//call in __constructor
		$this->SetModel(SYS.M.'model');
		
		$this->registerPHPFunctions();
		
		$this->only_registered(FALSE);
		$this->RegisterView(SYS.V."layouts".S."content");
		$this->RegisterView(SYS.V.'errors'.DS.'error');
		
		$this->setaccess(self::ACCESS_ANY);
		$this->AccessMode(1);
		$this->global_access = Helper::Session('user_access');
		$this->current_group = (Helper::Session('user_role')!="")?Helper::Session('user_role'):'any';
		
		if($this->error > 0) {
			$this->exceptions = TRUE;
		}
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
		$this->exception->setParameter('','inside','no');
		$this->exception->setParameter('','show_link','yes');
		$this->exception->ViewData('title', Intl::_p('Error!!!'));
		$this->exception->ViewData('header', Intl::_p('Error!!!').' '.$this->error);
		$this->exception->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Catch Error').' - ');
		$this->exception->ViewData('error', $this->error);
		return $this->exception->View();
	}
	
	public function Run($model = NULL){
		
		if($this->error > 0) throw new SystemException(Intl::_p('Error'),$this->error);

		$this->model->disabled = array('error','errors','data','index','item','action','load','access'); 

		$default_items = array(
			// sec

			array('id'=>1,'pos' => 1, 'name'=>'menu','module'=>'admin'.S.'menu','view'=>'elements'.S.'nav','class'=>'row', 'mode'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			array('id'=>2,'pos' => 1, 'name'=>'menu','module'=>'admin'.S.'menu','view'=>'elements'.S.'nav','class'=>'row', 'mode'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),
			
			// layout
			array('id'=>4,'pos' => 2, 'name'=>'admin', 'module'=>'layout','view'=>'','class'=>'row', 'mode'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			// items
			array('id'=>7,'pos' => 3, 'name'=>'one', 'module'=>'other'.S.'one','view'=>'other'.S.'one','class'=>'col-sm-4', 'mode'=>'app', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			array('id'=>5,'pos' => 4, 'name'=>'two', 'module'=>'other'.S.'two','view'=>'other'.S.'two','class'=>'col-sm-8', 'mode'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			
			// sections
			array('id'=>6,'pos' => 3, 'name'=>'any', 'module'=>'layout','view'=>'','class'=>'row', 'mode'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),
			// items
			array('id'=>3,'pos' => 2, 'name'=>'login','module'=>'admin'.S.'account','view'=>'admin'.S.'login','class'=>'col-sm-12', 'mode'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),

		);
		$this->model->registered = array("layout"); 
		$this->model->enabled = Config::$data['enabled'];
		if(!file_exists(ROOT.SYS.STORE.$this->name.".json")){
			file_put_contents(ROOT.SYS.STORE.$this->name.".json", json_encode($default_items));
		}
		$items = json_decode(file_get_contents(ROOT.SYS.STORE.$this->name.".json"),true);
		$items = $default_items;
		if (empty($items)){
		    $items = $default_items;
		}
		$this->model->layouts = $items;

		$this->contents();
		$this->menus();
	}

	protected function contents() {
		$this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
		$content = $this->GetModule(SYS.C.'layout'.S.'layout');
		$content = ($content)? htmlspecialchars($content->View()):"";
		$this->ViewData('content', $content);
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