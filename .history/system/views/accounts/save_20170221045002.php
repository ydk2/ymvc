<div class="row">
<div class="col-sm-12">
    <div class="well">
      <h1>Oj! coś tu nie tak</h1>
      <p>Nic nie znaleziono</p>
      <a href="<?=$this->link?>" class="btn btn-primary btn-large">Wróć</a>
    </div>
</div>
</div>
<?php
$post = $_POST;
if(isset($post) && !empty($post)){
if(!helper::post('can_login')) {
  $post['can_login']='n';
  unset($post['account_login']);
  unset($post['account_pass']);
}
if(!helper::post('active')) $post['active']='n';
foreach ($post as $key => $value) {
  $string = (is_array($value))?implode(', ',$value):$value;
  echo "<p>$key = ".$string."</p>";
}
}
?>