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
<!--
  <div class="col-sm-offset-2 col-sm-8 well">
      <h3>Add new item</h3>
       <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">

       <input name="item[title]" type="text" class="form-control" value="" placeholder="Title">
       <input name="item[link]" type="text" class="form-control" value="" placeholder="Link">
       <input name="item[group]" type="hidden" value="<?=$this->group?>">
       <input name="item[id]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[pos]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[parent]" type="hidden" value="">
       <button name="add" type="submit" class="btn btn-block btn-success">Dodaj</button>
       </form>
  </div>
-->
<?=$this->subView(SYS.V.'manage-menu-new')?>
  <div class="col-sm-12 well">
  Bieżąca grupa "<?=$this->group?>" <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
  </div>
	</div>