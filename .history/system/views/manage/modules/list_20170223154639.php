<div class="row">
<div class="col-sm-12">
  <h3><?=intl::_('Zarejestrowane Moduły')?></h3>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Grupy')?></a>
<a class="btn btn-info" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>"><?=intl::_('Moduły')?></a>

</div>
<?php if(!empty($this->items)){ ?>
<?php foreach($this->items as $file){ ?>
<div class="list-group-item">

<span class="btn btn-link lead"><?=$file['title'];?>&#160;</span>
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>"><?=intl::_('Edytuj')?></a>

</div>
<?php } ?>
<?php } else { ?>
<div class="list-group-item">
<h4><?=intl::_('Coś nie tak')?></h4>
<p><?=intl::_('Pusto, Nic tu nie ma')?></p>
<a class="btn btn-success" href="<?=$this->link.'='.'manage'.S.'modules'.S.'available&group='.$this->group.'';?>"><?=intl::_('Zarejestruj nowy')?></a>
</div>
<?php } ?>
</div>
</div>

<div class="col-sm-12 well">
   <div class="col-sm-12 well">
    <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Bieżąca grupa')?> "<?=$this->group?>" </a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'.S.'list&group='.$this->group);
      ?>
  </div>
</div>
