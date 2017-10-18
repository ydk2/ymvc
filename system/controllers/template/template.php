<?php
class Template extends Render {
    
    public function Init(){
        //call in __constructor
        Intl::set_path(SYS.LANGS.'index');
        $this->langs = Intl::available_locales(Intl::PO);
		$this->lang=Intl::get_browser_lang($this->langs);
        //if(!Helper::Session('locale'))
        //Helper::Session_Set('locale',Intl::get_browser_lang($this->langs));
        Intl::po_locale_plural(Helper::Session('locale'));
        
        $this->ViewData('lang', Helper::Session('locale'));
        $this->SetModel(SYS.M.'systemdata');
        
        $this->registerPHPFunctions();
        
        $this->only_registered(FALSE);
        $this->RegisterView(SYS.THEMES.Config::$data['template']['system'].DS.strtolower($this->name));
        $this->RegisterView(SYS.THEMES.Config::$data['template']['any'].DS.strtolower($this->name));
        $this->RegisterView(SYS.V.'errors'.DS.'error');
        
        $this->setaccess(self::ACCESS_ANY);
		$this->access_groups = array();
        $this->AccessMode(2);
        $this->global_access = Helper::Session('user_access');
        $this->fixie='<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->';
        $this->current_group = Helper::Session('user_role');
        
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
		//echo "";
		return $this->showwarning();

	}
	public function showwarning()
	{
		$this->model->header = Intl::_('Uwaga!!!');
		$this->model->text = Intl::_('Błąd').' '.$this->error;
		return $this->subView(SYS.V."elements-msg");
	}
    
    public function Run($model = NULL){
        //$		this->SetView(SYS.V.'time');
        $grp = Helper::Session('user_role');
        $this->current_group = (!$grp || $grp=='')?'any':$grp;
        //if($this->error > 0) throw new SystemException(Intl::_p('Error'),$this->error);
        $this->model->mode = SYS;

        $this->header();
        $this->contents();
        

    }

    protected function contents()
    {
        //$this->cache = Helper::Loader(CORE.'cache');
        //$this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
        //$content = $this->GetModule(SYS.C.'layout'.S.'layout');
		$content = $this->NewControllerExt(CORE.'layout');

        $content->mode = 'sys';
        $content->layout_data=Config::$data['layout_data'];
		$content->registered = array("layout","views");
		$content->enabled = Config::$data['enabled'];
        $table='layouts';
		$gprx = 'layout';
		$contents = '';

        $content->layouts = $this->model->getData(Config::$data['layout_data']);
        $modules = $this->model->getData(Config::$data['modules_data']);

        if(isset($_GET['login'.S.'form'])){
            $this->current_group='login';
        }
        if(isset($_GET['register'.S.'signin'])){
            $this->current_group='signin';
        }

        $content->layout_group = $this->current_group;

        var_dump($this->current_group);

        $moduleitems = $this->model->itemsData($modules,$this->current_group,'group');
        $content->layout_group = $this->current_group;
        $items = array();
        foreach ($moduleitems as $module) {
            $items[]= $module['path'];
        }

        Config::$data['enabled'] = $items;

        if($this->current_group=="admin"){

            //$content->default_route_group='default';
        }
        //var_dump($content);
//echo $this->current_group;
        $content->default_route_count=1;
        $content->enabled = Config::$data['enabled'];
        $content->disabled = Config::$data['disabled'];
        $content->mode = $this->model->mode;
		//$content->run();
		//foreach ($content->data->layout as $view) :
		//$contents .= '<div class="'.$view['class'].'">';
    	//$contents .= $view['content'];
		//$contents .= '</div>';
		//endforeach;
        $contents = ($content)? $content->Views():"";
        $this->contents= $contents;

    }
    
    protected function footer()
    {
        $this->ViewData('footerheader', Intl::_p('Footer Header'));
        $this->ViewData('footercontent', Intl::_p('footer content'));
    }
    protected function styles($array=array()){
        $string = '';
        if(!empty($array)){
            foreach ($array as $value) {
                $string .= "<style".
                (isset($value['type']) && $value['type']!='')?' type="'.$value['type'].'"':''.
                (isset($value['content']) && $value['content']!='')?''.$value['content'].'':''.
                "></style>".PHP_EOL;
            }
        }
        return $string;
    }
    protected function scripts($array=array()){
        $string = '';
        if(!empty($array)){
            foreach ($array as $value) {
                $string .= "<script";
                $string .= (isset($value['type']) && $value['type']!='')?' type="'.$value['type'].'"':'';
                $string .= (isset($value['src']) && $value['src']!='')?' src="'.$value['src'].'"':'';
                $string .= (isset($value['content']) && $value['content']!='')?''.$value['content'].'':'';
                $string .= "></script>\n";

            }
        }
        return $string;
    }
    protected function links($array=array()){
        $string = '';
        if(!empty($array)){
            foreach ($array as $value) {
                $string .= "<link".
                (isset($value['rel']) && $value['rel']!='')?' rel="'.$value['rel'].'"':''.
                (isset($value['type']) && $value['rel']!='')?' type="'.$value['type'].'"':''.
                (isset($value['href']) && $value['href']!='')?' href="'.$value['href'].'"':''.
                ">".PHP_EOL;
            }
        }
        return $string;
    }
    protected function header(){
    $links = array(
        array('rel'=>'stylesheet','type'=>'text/css','href'=>''),
    );
    $scripts = array(
        array('type'=>'text/javascript','src'=>'libriares/libs/jquery/1.9.1/jquery.min.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/bootstrap-combobox/bootstrap-combobox.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js','content'=>''),
        // codemirror
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/lib/codemirror.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/mode/xml/xml.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/lib/formatting.js','content'=>''),
        //codemirror addon
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/addon/hint/show-hint.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/addon/hint/xml-hint.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/addon/hint/html-hint.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/mode/xml/xml.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/mode/javascript/javascript.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/mode/css/css.js','content'=>''),
        array('type'=>'text/javascript','src'=>'libriares/libs/codemirror/mode/htmlmixed/htmlmixed.js','content'=>'')
        // summernote

    );
    //echo $this->scripts($scripts);
    $header = '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">';
    $header .= $this->scripts($scripts).
    '<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">';
    $header .='
    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="libriares/libs/codemirror/lib/codemirror.css">
    <link rel="stylesheet" type="text/css" href="libriares/libs/codemirror/theme/monokai.css">
    <!-- -->
    <!-- -->
    <link href="libriares/libs/summernote/summernote.css" rel="stylesheet">
    <script src="libriares/libs/summernote/summernote.min.js"></script>
    <!-- include summernote-ko-KR -->
    <script src="libriares/libs/summernote/lang/summernote-pl-PL.js"></script>
    <!-- plugins -->
    <script src="libriares/libs/summernote/plugin/summernote-image-attributes.js"></script>
    <script src="libriares/libs/summernote/plugin/summernote-ext-rtl.js"></script>
    <script src="libriares/libs/summernote/plugin/summernote-fontawesome.js"></script>
    <script src="libriares/libs/summernote/plugin/summernote-ext-addclass.js"></script>
    <script src="libriares/libs/summernote/plugin/summernote-floats-bs.js"></script>';
    $header .='<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>';
    $header .= '
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>';
    $this->header=$header;
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