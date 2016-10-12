<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');
?>
<?php
Helper::Inc(CORE.'router');
Config::Init();

Config::$data['default']['database']['type'] = 'sqlite';
Config::$data['default']['cpu_limit'] = 15;
//$model = new stdClass;
//$views = new CoreRender;
$loader = new Loader;

//echo htmlspecialchars_decode( Router::sys_routed($array,$disabled)->asXml());
echo $loader->showsys('layout','layout');

//$next = $views->Controller(SYS.C.'view');
//$start = $loader->Controller(SYS.C.'index');

//$next->show();
//$start->show();
//var_dump($next);
//var_dump($start);
?>