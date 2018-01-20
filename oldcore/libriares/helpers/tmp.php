<?php

$list = array(
'pl'=>array('name'=>'polski','date'=>'pl','get'=>'pl','sub'=>array(
array('name'=>'start','date'=>'pl-start','get'=>'start','sub'=>''),
array('name'=>'jeden','date'=>'pl-jeden','get'=>'jeden','sub'=>''),
array('name'=>'dwa','date'=>'pl-dwa','get'=>'dwa','sub'=>'')
)),
'en'=>array('name'=>'english','date'=>'en','get'=>'en','sub'=>array(
array('name'=>'start','date'=>'en-start','get'=>'start','sub'=>''),
array('name'=>'one','date'=>'en-jeden','get'=>'jeden','sub'=>'')
)),
'sp'=>array('name'=>'espaniol','date'=>'sp','get'=>'sp','sub'=>array(
array('name'=>'start','date'=>'sp-start','get'=>'start'),
array('name'=>'one','date'=>'sp-jeden','get'=>'jeden','sub'=>array(
         array('name'=>'four','date'=>'sp-czterygg','get'=>'cztery')))
))
);

?>
<?php 

?>
<?php
require_once 'A2O.php';
require_once 'XML2Array.php';
require_once 'array_paths.class.php';
require_once 'ArrayPath.php';

//$themefile = file_get_contents(dirname(__DIR__).'/datasite/sites.xml');
//$xml = new XML2Array($themefile);
//$s = $xml->out;
//$xml->close();
//echo '<pre>'; print_r ($lists); echo '</pre>';
?>
<?php
/**/
$s = json_decode(file_get_contents(dirname(__DIR__).'/datasite/menu.json'),TRUE);
$z = new Array_Object ;
$q = $z->Obj($s);
$z->a = $q;
 $z->a->insert_before('en',array('o' => 'new TT'));
//$z->a->h->delete('t');
echo '<pre>'; print_r ($z->a->pl); echo '</pre>';
echo '<hr><pre>'; echo htmlentities($z->a->ToXML());  echo '</pre><hr>';
echo '<pre>'; print_r (json_decode($z->a->JSON(), true)); echo '</pre>';
echo "<hr />";
 /**/
//$xml = new XML2Array(array('root'=>$z->a->ToArrays()));
//$xml = new XML2Array($lists);
//echo $z->a->pl->JSON();
//echo "<pre>".htmlentities($xml->out)."</pre>";

//$xml->close();
?>