<?php
class Theme extends XSLRender {
    
    public function Init(){
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
        $this->RegisterView(SYS.THEMES.Config::$data['template']['any'].DS.strtolower($this->name));
        $this->RegisterView(SYS.V.'errors'.DS.'error');
        
        $this->setaccess(self::ACCESS_ANY);
        $this->AccessMode(1);
        $this->global_access = Helper::Session('user_access');
        $this->setParameter('','fixie','<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        ');
        $this->current_group = Helper::Session('user_role');
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
        //$		this->SetView(SYS.V.'time');
        $grp = Helper::Session('user_role');
        $this->current_group = (!$grp || $grp=='')?'any':$grp;
        if($this->error > 0) throw new SystemException(Intl::_p('Error'),$this->error);
        $this->model->mode = SYS;
        
        $this->ViewData('subheader', Intl::_p('Theme modules'));
        $this->header();
        $this->contents();
        

    }
    
    protected function contents()
    {
        $this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
        $content = $this->GetModule(SYS.C.'layout'.S.'layout');
        $content->layout_group = $this->current_group;
        $content->mode = 'sys';
        $content->layout_data=Config::$data['layout_data'];
		$content->registered = array("layout");
		$content->enabled = Config::$data['enabled'];
		if(!file_exists(ROOT.SYS.STORE.$content->layout_data)){
			//file_put_contents(ROOT.SYS.STORE.$content->model->layout_data, json_encode($default_items));
		}
		$items = json_decode(file_get_contents(ROOT.SYS.STORE.$content->layout_data),true);
        $table='layouts';
		$gprx = 'layout';
		$array = $this->model->get_entries($table,$gprx);
        //$items=$this->model->searchByName($array,'name',$gprx);
		//$items = $default_items;
		if (empty($items)){
		    //$items = $default_items;
		}
        $content->layouts = $items;
        if($this->current_group=="admin"){
            Config::$data['enabled'] = array(
            APP.C.'one',
            SYS.C.'other'.S.'two',
            SYS.C.'check'.S.'gettime',
            SYS.C.'elements'.S.'menu',
            SYS.C.'login'.S.'form',
            SYS.C.'admin'.S.'mngmenus',
            SYS.C.'admin'.S.'mngaccount',
            SYS.C.'admin'.S.'mnglayout',
            SYS.C.'test'.S.'test'
            );
            $content->layout_group = 'admin';
        }
        if(Helper::get('login'.S.'form') || $this->current_group=="any"){

            Config::$data['enabled'] = array(
            APP.C.'one',
            SYS.C.'check'.S.'gettime',
            SYS.C.'elements'.S.'menu',
            SYS.C.'login'.S.'form',
            SYS.C.'admin'.S.'mngaccount',
            SYS.C.'other'.S.'phpcall',
            SYS.C.'test'.S.'test'
            );
            $content->layout_group = 'any';
        }
        $content->enabled = Config::$data['enabled'];
        $content->disabled = Config::$data['disabled'];
        $content->mode = $this->model->mode;
        $content = ($content)? htmlspecialchars($content->View()):"";
        $this->ViewData('contents', $content);
    }
    
    protected function footer()
    {
        $this->ViewData('footerheader', Intl::_p('Footer Header'));
        $this->ViewData('footercontent', Intl::_p('footer content'));
    }
    
    protected function header(){

        $header = '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <script src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
    <script src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/theme/css/bs-style.css" rel="stylesheet" type="text/css">';
        $this->ViewData('header', $header);
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
    protected function sidemenus($value='')
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