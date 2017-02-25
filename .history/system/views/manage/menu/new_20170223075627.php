<div class="col-sm-12 well">
  <h3><?=intl::_('Dodaj nowy wpis')?></h3>
  <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">
    <div class="form-group">
      <div class="col-sm-12">
        <div class="input-group">
          <input name="item[title]" type="text" class="form-control" value="" placeholder="Title">
          <span class="input-group-addon">&nbsp;<?=intl::_('Nazwa')?></span>
          <input name="item[link]" type="text" class="form-control" value="" placeholder="Link">
          <span class="input-group-addon">&nbsp;<?=intl::_('Link')?></span>
          <span class="input-group-btn">
			<button name="add" type="submit" class="btn btn-success">
			<i class="fa fa-lg fa-plus-circle"></i>&nbsp;<?=intl::_('Dodaj')?></button>
		  </span>

          <input name="item[group]" type="hidden" value="<?=$this->group?>">
          <input name="item[id]" type="hidden" value="<?=$this->freekey()?>">
          <input name="item[pos]" type="hidden" value="<?=$this->freekey()?>">
          <input name="item[parent]" type="hidden" value="">
        </div>
      </div>
    </div>
  </form>
</div>