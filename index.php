<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');
?>
  <?php
Helper::Session_Start();
Helper::Inc(CORE.'router');
Helper::Inc(CORE.'intl');
Config::Init();

Config::$data['default']['database']['type'] = 'sqlite';
    Config::$data['default']['cpu_limit'] = 15;
        //$model = new stdClass;
        //$views = new CoreRender;
		Intl::set_path(SYS.LANGS);
		$langs = Intl::available_locales(Intl::PO);
		if(Helper::Get('setlocale')){
			Helper::Session_Set('locale',Helper::Get('setlocale'));
			Intl::load_locale(Helper::Session('locale'),'main_index');
		} 
		if(!Helper::Session('locale'))
				Helper::Session_Set('locale',Intl::get_browser_lang($langs));
				Intl::load_locale(Helper::Session('locale'),'main_index');
		
		//var_dump($strings);
		//echo Intl::_('Comments are closed','main_index');
        $loader = new Loader;
        
        //echo htmlspecialchars_decode( Router::sys_routed($array,$disabled)->asXml());
        //echo $loader->showsys('layout','layout');
        echo $loader->showsys('phpcall','phpcall');
        
        //$model = new stdClass;
        //$views = new Core();
        //$next = $views->Controller(SYS.C.'view');
        //$start = $loader->Controller(SYS.C.'index');
        
        //$next->show();
        //$start->show();
        //var_dump($next);
        //var_dump($start);
        ?>
    <?php
        //Encryption:

        //print "My Decrypted Text: ". $decryptedText;

		//echo Intl::_('Comments are closed','main_index');
?>