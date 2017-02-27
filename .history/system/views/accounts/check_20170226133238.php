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
<b><?=substr($key, strpos($key, '_'),strlen($key))?></b>
</div>
<div class="col-sm-8">
<span> <?=$value;?></span>
</div>
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

<?php } ?>
</div>