<?php
class LoadContent extends XSLRender {
	
	public function onInit(){
		//call in __constructor
		$this->SetModel(SYS.M.'model');
		
		$this->registerPHPFunctions();
		
		$this->only_registered(FALSE);
		$this->RegisterView(SYS.V."layouts:content");
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
	
	public function onDestruct(){
		// 		call in __destructor
				return TRUE;
	}
	
	public function onException(){
		$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
		$this->exception->setParameter('','inside','no');
		$this->exception->setParameter('','show_link','yes');
		$this->exception->ViewData('title', Intl::_p('Error!!!'));
		$this->exception->ViewData('header', Intl::_p('Error!!!').' '.$this->error);
		$this->exception->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Catch Error').' - ');
		$this->exception->ViewData('error', $this->error);
		return $this->exception->View();
	}
	
	public function onRun($model = NULL){
		
		if($this->error > 0) throw new SystemException(Intl::_p('Error'),$this->error);

		$this->model->disabled = array('error','errors','data','index','item','action','load','access'); 

		$default_items = array(
			// sec

			array('id'=>1,'pos' => 1, 'name'=>'menu','module'=>'admin:menu','view'=>'elements:nav','class'=>'row', 'model'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			array('id'=>2,'pos' => 1, 'name'=>'menu','module'=>'admin:menu','view'=>'elements:nav','class'=>'row', 'model'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),
			
			// layout
			array('id'=>4,'pos' => 2, 'name'=>'admin', 'module'=>'layout','view'=>'','class'=>'row', 'model'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			// items
			array('id'=>19,'pos' => 3, 'name'=>'one', 'module'=>'other:one','view'=>'other:one','class'=>'col-sm-4', 'model'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			array('id'=>5,'pos' => 4, 'name'=>'two', 'module'=>'other:two','view'=>'other:two','class'=>'col-sm-8', 'model'=>'', 'group'=>'admin', 'attrid'=>'', 'users'=>''),
			
			// sections
			array('id'=>5,'pos' => 3, 'name'=>'any', 'module'=>'layout','view'=>'','class'=>'row', 'model'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),
			// items
			array('id'=>3,'pos' => 2, 'name'=>'login','module'=>'admin:account','view'=>'admin:login','class'=>'col-sm-12', 'model'=>'', 'group'=>'any', 'attrid'=>'', 'users'=>''),

		);
		$this->model->registered = array("layout"); 
		$this->model->enabled = Config::$data['enabled'];
		if($this->current_group!="admin"){
			$this->model->layout_group = $this->current_group;
		} else {
			$this->model->layout_group = 'admin';
		}
		if(!file_exists(ROOT.SYS.STORE.$this->name.".json")){
			file_put_contents(ROOT.SYS.STORE.$this->name.".json", json_encode($default_items));
		}
		$items = json_decode(file_get_contents(ROOT.SYS.STORE.$this->name.".json"),true);
		//$items = $layout_items;
		if (empty($items)){
		    $items = $default_items;
		}
		$this->model->default = $items;
		
		$i = 2;
		foreach ($_GET as $key => $value) {
		if($this->current_group!="admin"){
			$this->model->layouts[0] = $this->model->default[1];
		} else {
			$this->model->layouts[0] = $this->model->default[0];
		}
		if(!in_array($key,$this->model->disabled) && $this->ControllerExists(SYS.C.$key)){
			$this->model->layouts[] = array('pos' => $i++, 'name'=>'FromGet','module'=>$key,'view'=>$value,'class'=>'col-sm-12','attrid'=>'', 'users'=>'', 'group'=>'', 'model'=>'');
		}
		}

		if(!isset($this->model->layouts) || count($this->model->layouts)<=1){
			$this->model->layouts = $this->model->default;
		}

		$this->contents();
		$this->menus();
	}

	protected function contents()
	{
		$this->SetModule(SYS.V.'layout:views',SYS.C.'layout:layout');
		$content = $this->GetModule(SYS.C.'layout:layout');
		$content = ($content)? htmlspecialchars($content->View()):"";
		$this->ViewData('content', $content);
	}
	protected function menus($value='')
	{
        return "";
	}

}
?>