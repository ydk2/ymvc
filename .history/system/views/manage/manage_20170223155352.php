
  <div class="row">

  <div class="col-sm-12">
  <?php if(!empty($this->group_list)):?>
  <h3><?=intl::_('Administracja')?></h3>
  <div class="list-group">
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>groups"><?=intl::_('Grupy')?></a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>layouts"><?=intl::_('Układy')?></a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>menus"><?=intl::_('Menu')?></a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>modules"><?=intl::_('Moduły')?></a>
  </div>
  <?php endif;?>
  </div>


   <div class="col-sm-12 well">
    <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Bieżąca grupa')?> "<?=$this->group?>" </a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'manage&group='.$this->group);
      ?>
  </div>

	</div>