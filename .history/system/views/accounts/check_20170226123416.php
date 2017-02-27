<div class="row">
<div class="col-sm-12">
<div class="well">
<a href="?accounts-user=accounts-new" class="btn btn-primary btn-large">Wróć do nowego</a>
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


<?php foreach ($this->post as $key => $value) { ?>
<?php if($key=='address'){ ?>
<?=serialize($value);?>
<?php } else if($key=='account_born'){ ?>

<?php } else { ?>
<?=(is_array($value))?implode(';',$value):$value;?>
<?php } ?>

<?php } ?>
<p>
<b></b>
<span></span>
</p>
<p>...</p>
<p>...</p>
<p>...</p>
<p>...</p>
<p>...</p>
<a href="?accounts-user=accounts-new&answer=no" class="btn btn-danger btn-large">
<?=intl::_('popraw')?>
</a>
<a href="?accounts-user=accounts-new&answer=yes" class="btn btn-large btn-success">
<?=intl::_('potwierdź')?>
</a>
</div>
</div>

<?php } else { ?>
<h3><?=intl::_('Brak Danych')?></h3>
<?php } ?>
</div>