<div class="row">
<div class="col-sm-12">
    <div class="well">
      <a href="?accounts-user=accounts-new" class="btn btn-primary btn-large">Wróć do nowego</a>
    </div>
</div>
</div>
<?=$this->msg?>
<?php
//var_dump($_POST);
if(isset($this->post) && !empty($this->post)){
  $this->post['account_ctime']=time();
  $this->post['account_mtime']=time();
if(!isset($this->post['account_can_login'])) $this->post['account_can_login']='no';
if(!isset($this->post['account_active'])) $this->post['account_active']='no';
foreach ($this->post as $key => $value) {
  if($key=='address'){
    $string = serialize($value);
  } else if($key=='account_born'){
    $string = strtotime($value);
    echo "<h3>$key = ".date('d-m-Y',$string)."</h3>";
  } else {
    $string = (is_array($value))?implode(';',$value):$value;
  }
  echo "<p>$key = ".$string."</p>";

}
}
?>
<?=$this->subview?>

        <div class="row">
          <div class="col-sm-12">
            <div class="well">
              <h3><?=intl::_('Nowe Konto')?></h3>
              <i><?=intl::_('Sprawdź dane')?></i>
              <p>
                <b></b>
                <span></span>
              </p>
              <p>...</p>
              <p>...</p>
              <p>...</p>
              <p>...</p>
              <p>...</p>
              <a class="btn btn-danger btn-large"><?=intl::_('zrezygnuj')?></a>
              <a class="btn btn-large btn-success"><?=intl::_('potwierdź)?></a>
            </div>
          </div>
        </div>