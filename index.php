<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');
?>
<?php
Config::Init();
$model = new stdClass;
//$views = new CoreRender;
$loader = new Loader;
$view = 'index';
if(isset($_GET['view']) && $_GET['view'] != ""){
	$view = $_GET['view'] ;
}
	function Inc($class){
		if(file_exists(APP.$class.EXT)  && is_file(APP.$class.EXT)){	
			require_once(APP.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}

//echo $loader->app('index','index');
echo $loader->showsys('sys_layout','layout');
//$next = $views->Controller(SYS.C.'view');
//$start = $loader->Controller(SYS.C.'index');

//$next->show();
//$start->show();
//var_dump($next);
//var_dump($start);
?>