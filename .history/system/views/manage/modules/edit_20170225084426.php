<div class="row">
<div class="col-sm-12">
<?php if ($this->model->cache->itemExists($this->items,base64_decode(Helper::get('path')),'path')) { ?>
<?php
$item = $this->model->cache->GetItemBy($this->items,base64_decode(Helper::get('path')),'path');
?>
  <h3><?=Intl::_('Zarządzaj Modułem')?></h3>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>"><?=Intl::_('Moduły')?></a>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(dirname($item['path']));?>"><?=Intl::_('Wróć')?></a>
</div>
<div class="list-group-item">
<?=Intl::_('Tytuł')?> "<?=$item['title'];?>" <?=Intl::_('dla')?> "<?=basename($item['path'])?>"
</div>
<div class="list-group-item">
<?=Intl::_('Dostęp dla')?>: "<?=$item['access_groups'];?>"
</div>
<div class="list-group-item">
<?=Intl::_('Zainstalowano w')?> "<?=$item['path']?>"
</div>
<div class="list-group-item">
<?php if(strpos($this->data->link, 'modules'.S.'list')!==FALSE){ ?>
<a class="btn btn-danger" href="<?=$this->data->link.'&action=delete&item='.$item['id'];?>"><?=Intl::_('Usuń')?></a>
<?php } else { ?>
<p class="btn btn-success"><?=Intl::_('Zarejestrowano')?></p>
<?php } ?>
</div>
</div>
<?php } else { ?>
<?php

$name = basename(base64_decode(Helper::get('path')),'.php');
$this->Inc(base64_decode(Helper::get('path')));
if(class_exists($name) && method_exists($name,'Config')){
$config = $name::Config();
?>

  <h3><?=Intl::_('Dodaj nowy moduł')?></h3>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>"><?=Intl::_('Moduły')?></a>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>"><?=Intl::_('Wróć')?></a>
</div>
<div class="list-group-item">
<?=Intl::_('Tytuł')?> "<?=$config['title'];?>" <?=Intl::_('dla')?> "<?=$name?>"
</div>
<div class="list-group-item">
<?=Intl::_('Dostęp dla')?>: <?=implode(', ',$config['access_groups']);?>
</div>
<div class="list-group-item">
<?=Intl::_('Zainstalowano w')?> "<?=base64_decode(Helper::get('path'))?>"
</div>
<div class="list-group-item">
<form action="<?=$this->data->link.'&action=edit&path='.helper::get('path')?>" method="post" class="form-inline">
<input type="hidden" name="items[path]" value="<?=base64_decode(helper::get('path'))?>">
<input type="hidden" name="items[title]" value="<?=$config['title']?>">
<input type="hidden" name="items[group]" value="<?=$this->group?>">
<input type="hidden" name="items[id]" value="<?=$this->freekey()?>">
<input type="hidden" name="items[access_groups]" value="<?=implode(',',$config['access_groups']);?>">
<button class="btn btn-success" type="submit"><?=Intl::_('Dodaj')?></button>
</form>

</div>
</div>
<?php
} else {
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-warning" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>"><?=Intl::_('Wróć')?>/a>
</div>
<div class="list-group-item">
<h4><?=Intl::_('Coś nie tak')?></h4>
<p><?=Intl::_('Nic tu nie ma lub moduł nie jest zgodny z systemem')?></p>
<p><?=base64_decode(helper::get('path'))?> <?= $name ?></p>
</div>
</div>
<?php } ?>
<?php } ?>
</div>
   <div class="col-sm-12 well">
    <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Bieżąca grupa')?> "<?=$this->group?>" </a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST.modify_url($_SERVER['QUERY_STRING'],array()));
      ?>
  </div>
</div>