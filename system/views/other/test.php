<?php
?>

<div class="row">
<?php
$query = array(
'table'=>'sitedata',
'keys'=>array(
'id','name'
),
'ask'=>array(
'name LIKE'=>'me',
'id ='=>'1'
),
'order'=>array('id','ASC'),
'prepare'=>array()
);
function test($query){
		# code...
if(!empty($query['keys'])){
	$keys = implode(', ',$query['keys']);
} else {
	$keys = '*';
}
$prepare = array();
$ask = '';

if(!empty($query['ask'])){
	$ask .= ' WHERE '.implode(' ? AND ',array_keys($query['ask'])).' ?';
	$prepare=array_values($query['ask']);
} 
if(!empty($query['order'])){
	$ask .= ' ORDER BY '.$query['order'][0].' '.$query['order'][1];
} 
 


echo "SELECT ".$keys." FROM ".$query['table'].$ask.";";
//var_dump($prepare);
}
test($query);
//var_dump($this->model->get('sitedata',array('id')))
?>
</div>
