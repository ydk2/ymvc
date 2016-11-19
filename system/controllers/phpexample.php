<?php
class PHPExample extends PHPRender {

	public function onInit(){
		// call in __constructor
		Intl::set_path(SYS.LANGS.strtolower($this->name));
		$this->langs = Intl::available_locales(Intl::PO);
		//	if(!Helper::Session('locale'))
		//		Helper::Session_Set('locale',Intl::get_browser_lang($this->langs));
				Intl::po_locale_plural(Helper::Session('locale'),$this->name);

		$this->ViewData('lang', Helper::Session('locale'));
		$this->SetModel(SYS.M.'model');

		$this->only_registered(TRUE);
		if(Helper::Get('load')!='php'){
		$this->setView(SYS.V.'layout'.DS.'php');
		$this->RegisterView(SYS.V.'layout'.DS.'php');
		$this->unRegisterView(SYS.V.strtolower($this->name));
		$this->setAccess(self::ACCESS_USER);
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);
		} else {

		$this->RegisterView(SYS.V.strtolower($this->name));
		}
		$this->registerPHPFunctions();
		
		$this->setParameter('','fixie','<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		');
		if(Helper::Get('action')=="error"){
           $this->error = 193502;
		}
		if($this->error > 0) {
			//echo $this->error ;
			$this->RegisterView(SYS.V.'errors'.DS.'error');
			
			
			$this->exceptions = TRUE;
			throw new SystemException(Intl::_p('Error',$this->name),$this->error);
		}
		
		
	}

	public function onEnd(){
		// call after render view
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}

	public function onException(){
		$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

		if(Helper::Get('load')!=='php'){
		$this->exception->setParameter('','inside','yes');
		$this->exception->setParameter('','show_link','no');
		} else {
		$this->exception->setParameter('','inside','no');
		$this->exception->setParameter('','show_link','yes');
		}
		$this->exception->ViewData('title', Intl::_p('Error!!!',$this->name));
		$this->exception->ViewData('header', Intl::_p('Error!!!',$this->name).' '.$this->error);
		$this->exception->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Catch Error',$this->name).' - ');
		$this->exception->ViewData('error', $this->error);
		return $this->exception->View();
	}

	public function onRun($model = NULL){
		//$this->SetView(SYS.V.'time');
	//	if($this->error == 193502) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
		if(Helper::Get('load')=='php'){
		if($this->error > 0) throw new SystemException(Intl::_p('Error',$this->name),$this->error);
		}
		$this->ViewData('maintitle', Intl::_p('YMVC System',$this->name));
		$this->ViewData('title', Intl::_p('PHPExample',$this->name));
		$this->ViewData('smallheader', Intl::_p('View',$this->name));
		$this->ViewData('header', Intl::_p('PHPExample',$this->name));
		$this->ViewData('subheader', Intl::_p('PHPExample View',$this->name));
		$this->ViewData('content', Intl::_p("Content for PHPExample" ,$this->name));


		$this->ViewData('footerheader', Intl::_p('PHPExample Footer Header',$this->name));
		$this->ViewData('footercontent', Intl::_p('PHPExample footer content',$this->name));
		
		$this->ViewData('list', "" );
		$list = $this->data->list->addChild('items',Intl::_p('Load XSL',$this->name));
		$list->addAttribute('href', HOST_URL."?load=xsl");
		$list = $this->data->list->addChild('items',Intl::_p('Load PHP',$this->name));
		$list->addAttribute('href', HOST_URL."?load=php");
		$list = $this->data->list->addChild('items',Intl::_p('Throw Error',$this->name));
		$list->addAttribute('href', HOST_URL."?action=error");
		$list = $this->data->list->addChild('items',Intl::_p('Load Intl test from phpclasses',$this->name));
		$list->addAttribute('href', HOST_URL."?load=test");
		$list = $this->data->list->addChild('items',Intl::_p('Link four',$this->name));
		$list->addAttribute('href', HOST_URL);
		$list = $this->data->list->addChild('items',Intl::_p('Docs',$this->name));
		$list->addAttribute('href', HOST_URL.'docs');

		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('items',Intl::_p('Link',$this->name));
		$links->addAttribute('href', HOST_URL.'?load=php');

		$links = $this->data->links->addChild('items',Intl::_p('Any',$this->name));
		$links->addAttribute('href', HOST_URL.'?load=php&access=10');

		$links = $this->data->links->addChild('items',Intl::_p('User',$this->name));
		$links->addAttribute('href', HOST_URL.'?load=php&access=5');

		$links = $this->data->links->addChild('items',Intl::_p('Admin',$this->name));
		$links->addAttribute('href', HOST_URL.'?load=php&access=1');

		foreach ($this->langs as $key => $value) {
		$links = $this->data->links->addChild('items',Intl::_p('Locale',$this->name).' '.$value);
		$links->addAttribute('href', HOST_URL.'?setlocale='.$value.'&load=php');
		$links->addAttribute('hreflang', $value);	 
		} 
	}	
	public function test($a='a test', $b='b test'){
		$this->ViewData('message', " Content for call PHPExample &amp; ".$a." ".$b );
	}
}
?>