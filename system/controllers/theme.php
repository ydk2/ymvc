<?php
class Theme extends XSLRender {
	
	public function onInit(){
		//call in __constructor
		Intl::set_path(SYS.LANGS.'index');
		$this->langs = Intl::available_locales(Intl::PO);
		//if(!Helper::Session('locale'))
		//Helper::Session_Set('locale',Intl::get_browser_lang($this->langs));
		Intl::po_locale_plural(Helper::Session('locale'),'index');
		
		$this->ViewData('lang', Helper::Session('locale'));
		$this->SetModel(SYS.M.'model');
		
		$this->registerPHPFunctions();
		
		$this->only_registered(FALSE);
		$this->RegisterView(SYS.THEMES.Config::$data['template']['system'].DS.strtolower($this->name));
		$this->RegisterView(SYS.V.'errors'.DS.'error');
		
		$this->setaccess(self::ACCESS_ANY);
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);
		
		$this->setParameter('','fixie','<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		');
		
		if(Helper::Get('action')=="error"){
			$this->error = 193502;
		}
		
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
		//$		this->SetView(SYS.V.'time');
		
		if($this->error > 0) throw new SystemException(Intl::_p('Error'),$this->error);
		
		$this->ViewData('subheader', Intl::_p('Theme modules'));
		//$this->ViewData('content', Intl::_p("Content of modules" ));
		$this->SetModule($this->model,SYS.V.'layout'.DS.'sections',SYS.C.'layout'.DS.'layout');
		$content = $this->GetModule(SYS.C.'layout'.DS.'layout');
		$content = ($content)? htmlspecialchars($content->View()):"";
		$this->ViewData('content', $content);
		
		
		
		
		
		$this->headers();
		$this->mainmenu();
		$this->sidemenu();
		$this->langmenu();
		$this->footer();
	}

	protected function footer()
	{
		$this->ViewData('footerheader', Intl::_p('Footer Header'));
		$this->ViewData('footercontent', Intl::_p('footer content'));
	}

	protected function headers()
	{
		$this->ViewData('maintitle', Intl::_p('YMVC System'));
		$this->ViewData('title', Intl::_p('Theme'));
		$this->ViewData('smallheader', Intl::_p('View'));
		$this->ViewData('header', Intl::_p('Main Theme '));
	}
	
	protected function sidemenu($value='')
	{
		$this->ViewData('list', "" );
		$list = $this->data->list->addChild('items',Intl::_p('Load XSL'));
		$list->addAttribute('href', HOST_URL."?load=xsl");
		$list = $this->data->list->addChild('items',Intl::_p('Load PHP'));
		$list->addAttribute('href', HOST_URL."?load=php");
		$list = $this->data->list->addChild('items',Intl::_p('Throw Error'));
		$list->addAttribute('href', HOST_URL."?action=error");
		$list = $this->data->list->addChild('items',Intl::_p('Load Theme'));
		$list->addAttribute('href', HOST_URL."?load=theme");
		$list = $this->data->list->addChild('items',Intl::_p('Link four'));
		$list->addAttribute('href', HOST_URL);
		$list = $this->data->list->addChild('items',Intl::_p('Docs'));
		$list->addAttribute('href', HOST_URL.'docs');
	}
	
	protected function mainmenu() {
		
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('items',Intl::_p('Link'));
		$links->addAttribute('href', HOST_URL.'?load=theme');
		
		$links = $this->data->links->addChild('items',Intl::_p('Any'));
		$links->addAttribute('href', HOST_URL.'?access=10');
		
		$links = $this->data->links->addChild('items',Intl::_p('User'));
		$links->addAttribute('href', HOST_URL.'?access=5');
		
		$links = $this->data->links->addChild('items',Intl::_p('Admin'));
		$links->addAttribute('href', HOST_URL.'?access=1');
	}
	protected function langmenu(){
		
		foreach ($this->langs as $key => $value) {
			$langs = $this->data->links->addChild('langs',Intl::_p($value));
			$langs->addAttribute('href', HOST_URL.'?setlocale='.$value.'&load=theme');
			$langs->addAttribute('hreflang', $value);
		}
	}
}
?>