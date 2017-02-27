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
<div class="row">
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
    <span>****</span>
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
<?php switch ($key) {
  case 'account_name':?>
    <?=(helper::validate($value,'text',2,40))?' <b class="text-success">'.intl::_('ok').'</b>':' <b class="text-danger">'.intl::_('popraw').'</b>';?>
    <?php break;
  case 'account_email':?>
    <?=(helper::validate($value,'email'))?' <b class="text-success">'.intl::_('ok').'</b>':' <b class="text-danger">'.intl::_('popraw').'</b>';?>
    <?php break;
  case 'account_login':?>
    <?=(helper::validate($value,'alphanum',2,40) || helper::validate($value,'email'))?' <b class="text-success">'.intl::_('ok').'</b>':' <b class="text-danger">'.intl::_('popraw').'</b>';?>
    <?php break;
  case 'account_pass':?>
    <?=(helper::validate($value,'alphanum',6,199))?' <b class="text-success">'.intl::_('ok').'</b>':' <b class="text-danger">'.intl::_('popraw').'</b>';?>
    <?php break;
  case 'account_born':?>
    <?=(helper::validate(date('d-m-Y',$value),'date'))?' <b class="text-success">'.intl::_('ok').'</b>':' <b class="text-danger">'.intl::_('popraw').'</b>';?>
    <?php break;
} ?>
</div> <!-- end validate -->
</div>
<?php } else { ?>
<?php } ?>

<?php } ?>
<hr>
<div class="row">
<div class="col-sm-12">
<a href="?accounts-user=accounts-new&answer=no" class="btn btn-danger btn-large">
<?=intl::_('popraw')?>
</a>
<a href="?accounts-user=accounts-check&answer=yes" class="btn btn-large btn-success">
<?=intl::_('potwierdź')?>
</a>
</div>
</div>

</div>
</div>
<?= $this->utest() ?>
<?php } ?>

</div>