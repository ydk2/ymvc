<?php
$name = basename(base64_decode(Helper::get('path')),'.php');
$this->Inc(base64_decode(Helper::get('path')));
if(class_exists($name) && method_exists($name,'Config')){
$config = $name::Config();
?>

<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group;?>">List</a>
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
<form action="<?=$this->data->link.'&action=edit&path='.helper::get('path')?>" method="post" class="form-inline">
<input type="hidden" name="items[path]" value="<?=base64_decode(helper::get('path'))?>">
<input type="hidden" name="items[title]" value="<?=$config['title']?>">
<input type="hidden" name="items[group]" value="<?=$this->group?>">
<input type="hidden" name="items[id]" value="<?=$this->freekey()?>">
<input type="hidden" name="items[access_groups]" value="<?=implode(',',$config['access_groups']);?>">
<button class="btn btn-success" type="submit">Dodaj</button>
</form>
</div>

</div>
<?php
} else {
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'&app='.$this->app.'';?>">Wróć</a>
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