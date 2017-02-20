<?php
$name = basename(base64_decode(Helper::get('path')),'.php');
$this->Inc(base64_decode(Helper::get('path')));
if(class_exists($name) && method_exists($name,'Config')){
$config = $name::Config();
?>

<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>">Moduły</a>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>">Wróć</a>
</div>
<div class="list-group-item">
Tytuł "<?=$config['title'];?>" of "<?=$name?>"
</div>
<div class="list-group-item">
Dostęp dla: <?=implode(', ',$config['access_groups']);?>
</div>
<div class="list-group-item">
Zainstalowano w: <?=base64_decode(Helper::get('path'))?>
</div>
<div class="list-group-item">
<?php if (strpos($this->data->link, 'modules'.S.'list') !== false || $this->model->cache->itemExists($this->items,base64_decode(Helper::get('path')),'path')) { ?>
<a class="btn btn-danger" href="<?=$this->data->link.'&action=delete&item='.Helper::get('item');?>">Usuń</a>
<?php } else { ?>
<form action="<?=$this->data->link.'&action=edit&path='.helper::get('path')?>" method="post" class="form-inline">
<input type="hidden" name="items[path]" value="<?=base64_decode(helper::get('path'))?>">
<input type="hidden" name="items[title]" value="<?=$config['title']?>">
<input type="hidden" name="items[group]" value="<?=$this->group?>">
<input type="hidden" name="items[id]" value="<?=$this->freekey()?>">
<input type="hidden" name="items[access_groups]" value="<?=implode(',',$config['access_groups']);?>">
<button class="btn btn-success" type="submit">Dodaj</button>
</form>
<?php } ?>
</div>

</div>
<?php
} else {
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-warning" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>">Wróć</a>
</div>
<div class="list-group-item">
<h4>Coś nie tak</h4>
<p>Nic tu nie ma lub moduł nie jest zgodny z systemem</p>
<p><?=base64_decode(helper::get('path'))?> <?= $name ?></p>
</div>
</div>
<?php
}
?>
<div class="well">
<?php
echo $this->postvals;
?>
</div>