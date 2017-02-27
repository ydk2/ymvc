<div class="row">
<div class="col-sm-12">
    <div class="panel">
<?php
if(isset($this->user) && !empty($this->user)){
foreach ($this->user as $key => $value) {
  $string = (is_array($value))?implode(', ',$value):$value;
  echo "<p>$key = ".$string."</p>";
}
}
?>
    </div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
    <div class="panel">
<?php
foreach ($this->user as $key => $value) {
  $string = (is_array($value))?implode(', ',$value):$value;
  echo "<p>$key = ".$string."</p>";
}
?>
    </div>
</div>
</div>
