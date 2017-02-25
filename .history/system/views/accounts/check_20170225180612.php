<div class="row">
<div class="col-sm-12">
    <div class="well">
      <h1>Oj! coś tu nie tak</h1>
      <p>Nic nie znaleziono</p>
      <a href="<?=$this->link?>" class="btn btn-primary btn-large">Wróć</a>
      <a href="?accounts-user=accounts-new" class="btn btn-primary btn-large">Wróć do nowego</a>
    </div>
</div>
</div>
<?php
//var_dump($_POST);
if(isset($this->post) && !empty($this->post)){
if(!helper::post('active')) $this->post['active']='no';
foreach ($this->post as $key => $value) {
  if($key=='address'){
    $string = serialize($value);
    //unset($this->post[$key]);
  } else if($key=='account_born'){
    $string = strtotime($value);
    echo "<h3>$key = ".date('d-m-Y',$string)."</h3>";
  } else {
    $string = (is_array($value))?implode(', ',$value):$value;
  }
  echo "<p>$key = ".$string."</p>";
}
}
?>
<?=$this->subview?>