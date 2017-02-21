<div class="row">
<div class="col-sm-12">
<?=var_dump($this->userdetails)?>
<?php foreach($this->userdetails as $ukey=>$uvalues) { ?>
<p><?=$ukey?> <?=$uvalues?></p>
<?php } ?>
</div>
</div>