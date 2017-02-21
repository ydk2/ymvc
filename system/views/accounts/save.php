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
if(isset($this->post) && !empty($this->post)){
if(!helper::post('active')) $this->post['active']='n';
foreach ($this->post as $key => $value) {
  $string = (is_array($value))?implode(', ',$value):$value;
  echo "<p>$key = ".$string."</p>";
}
}
?>