<div class="row">
<div class="col-sm-12">
<div class="well">
<a href="?accounts-user=accounts-new" class="btn btn-primary btn-large"><?=intl::_('Wróć')?></a>
</div>
</div>
</div>
<?=$this->msg?>
<?=$this->subview?>

<div class="row">
<?php if(isset($this->post) && !empty($this->post)){ ?>
<div class="col-sm-12">
<div class="well">
<h3><?=intl::_('Nowe Konto')?></h3>
<h4><?=intl::_('Sprawdź wprowadzone dane')?></h4>
<hr>

<?php foreach ($this->post as $key => $value) { ?>
<?php if(strpos($key, "account_") !== false){ ?>
<div class="row thumbnail">
<div class="col-sm-4">
<?php switch ($key) {
  case 'account_name':?>
    <b><?=intl::_('Nazwa Konta')?></b>
    <?php break;
  case 'account_email':?>
    <b><?=intl::_('Adres E-mail')?></b>
    <?php break;
  case 'account_login':?>
    <b><?=intl::_('Login')?></b>
    <?php break;
  case 'account_pass':?>
    <b><?=intl::_('Hasło')?></b>
    <?php break;
  case 'account_born':?>
    <b><?=intl::_('Data Urodzin')?></b>
    <?php break;
  case 'account_role':?>
    <b><?=intl::_('Rola w systemie')?></b>
    <?php break;
  case 'account_can_login':?>
    <b><?=intl::_('Logowanie do konta')?></b>
    <?php break;
  case 'account_active':?>
    <b><?=intl::_('Konto Aktywne')?></b>
    <?php break;
  case 'account_ctime':?>
    <b><?=intl::_('Data utworzenia')?></b>
    <?php break;
  case 'account_mtime':?>
    <b><?=intl::_('Data Modyfikacji')?></b>
    <?php break;
  case 'account_adnotation':?>
    <b><?=intl::_('Adnotacje')?></b>
    <?php break;
} ?>
</div> <!-- end keys -->
<div class="col-sm-5">
<?php switch ($key) {
  case 'account_pass':?>
    <span><?=$value?></span>
    <?php break;
  case 'account_born':
  case 'account_ctime':
  case 'account_mtime':?>
    <span><?=date('d-m-Y',$value)?></span>
    <?php break;
  case 'account_adnotation':?>
    <span><?=$value?></span>
    <?php break;
  default:?>
    <span><?=$value?></span>
    <?php break;
} ?>
</div> <!-- end vals -->

<div class="col-sm-1">
<?php if($key == 'account_born'){ $value = date('d-m-Y',$value); }?>
<?php if(array_key_exists($key,$this->required)): ?>
    <?=(helper::validate($value,$this->required[$key][0],$this->required[$key][1],$this->required[$key][2]))?'<b class="text-success">'.intl::_('ok').'</b>':'<b class="text-danger">'.intl::_('popraw').'</b>';?>
<?php endif;?>
</div> <!-- end validate -->
</div> <!-- end row -->
<?php } else { ?>
<?php switch ($key) :
  case 'address':?>
<div class="row thumbnail">
<div class="col-sm-12">
    <b><?=intl::_('Adresy')?></b>
</div>
<div class="col-sm-offset-4 col-sm-8">
    <?php
    $addresses=unserialize($value);
    if(!empty($addresses)):
    foreach($addresses as $pos => $address):?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><?=$pos?></h3>
      </div>
      <div class="panel-body">
        <p><?=$address['city']?></p>
        <p><?=intl::_('ul.')?> <?=$address['street']?> <?=$address['number']?>
        <?=($address['apartament']!='')?'/'.$address['apartament']:''?></p>
        <p><?=$address['postal_code']?> <?=$address['postal_city']?></p>
        <p><?=$address['country']?></p>
      </div>
    </div>
    <?php endforeach; endif;?>
</div> <!-- end vals -->

</div> <!-- end row -->
<?php break;?>
<?php case 'mail':?>
<div class="row thumbnail">
<div class="col-sm-12">
    <b><?=intl::_('Adresy E-mail')?></b>
</div>
<div class="col-sm-offset-4 col-sm-8">
    <?php
    $mail=unserialize($value);
    if(!empty($mail)):
    foreach($mail as $pos => $address):?>
    <div class="panel panel-primary">
      <div class="panel-body">
        <p><?=$address?></p>
      </div>
    </div>
    <?php endforeach; endif;?>
</div> <!-- end vals -->

</div> <!-- end row -->
<?php break;?>
<?php endswitch ?>
<?php } ?>

<?php } ?>
<hr>
<div class="row">
<div class="col-sm-12">
<a href="?accounts-user=accounts-new" class="btn btn-danger btn-large">
<?=intl::_('popraw')?>
</a>
<?php if($this->utest == count($this->required)){ ?>
<a href="?accounts-user=accounts-check&answer=yes" class="btn btn-large btn-success">
<?=intl::_('potwierdź')?>
</a>
<?php } ?>
</div>
</div>

</div>
</div>
<?php } ?>

</div>