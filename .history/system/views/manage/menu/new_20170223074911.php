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
<div class="col-sm-12 well">
  <h3>Add new item</h3>
  <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">
    <div class="form-group">
      <div class="col-sm-12">
        <div class="input-group">
          <input name="item[title]" type="text" class="form-control" value="" placeholder="Title">
          <span class="input-group-addon">&nbsp;<?=intl::_('Nazwa')?></span>
    	  <input name="item[link]" type="text" class="form-control" value="" placeholder="Link">
          <span class="input-group-addon">&nbsp;<?=intl::_('Link')?></span>
        </div>
      </div>
    </div>
  </form>
</div>