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
$loader->sys('view',NULL,loader::PHP);
$loader->sys('index',NULL);
//$next = $views->Controller(SYS_C.'view');
//$start = $loader->Controller(SYS_C.'index');

//$next->show();
//$start->show();
//var_dump($next);
//var_dump($start);
?>