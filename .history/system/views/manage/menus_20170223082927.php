<?=$this->subview?>
<div class="row">

  <?php if(!Helper::post('items') && !empty($this->items)):?>
    <?=$this->subView(SYS.V.'manage-menu-edit')?>
  <?php else:?>

  <div class="col-sm-offset-2 col-sm-8">
    <div class="well">
      <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
      <p class="text-primary"><?=$this->ViewData('text')?></p>
      <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
    </div>
  </div>
  <?php endif;?>
    <?=$this->subView(SYS.V.'manage-menu-new')?>
  <div class="col-sm-12 well">
  Bieżąca grupa "<?=$this->group?>" <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
  </div>
	</div>