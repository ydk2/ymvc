<?=$this->subview?>
<div class="row">

  <?php if(!Helper::post('items') && !empty($this->items)):?>
    <?=$this->subView(SYS.V.'manage-menu-edit')?>
  <?php else:?>
    <?=$this->subView(SYS.V.'elements-msg')?>
  <?php endif;?>
    <?=$this->subView(SYS.V.'manage-menu-new')?>
  <div class="col-sm-12 well">
  Bieżąca grupa "<?=$this->group?>" <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'menus&group='.$this->group);
      ?>
  </div>
	</div>