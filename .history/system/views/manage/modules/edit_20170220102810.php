<?php
$name = basename(helper::get('add'),'.php');
$this->Inc(DOCROOT.$this->app.DS.C.Helper::get('path').DS.$name);
if(class_exists($name) && method_exists($name,'Config')){
$config = $name::Config();
?>

<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'&app='.$this->app.'';?>">List</a>
</div>
<div class="list-group-item">
Tytuł "<?=$config['title'];?>" of "<?=$name?>"
</div>
<div class="list-group-item">
Dostęp dla: <?=implode(', ',$config['access_groups']);?>
</div>
<div class="list-group-item">
Zainstalowano w: <?=DOCROOT.$this->app.DS.C.Helper::get('path').DS.helper::get('add')?>
</div>

<div class="list-group-item">
<form action="<?=$this->data->link.'&path='.helper::get('path').'&group='.$this->group.'&action=true&add='.helper::get('add')?>" method="post" class="form-inline">
<input type="hidden" name="items[path]" value="<?=$this->app.DS.C.Helper::get('path').DS.helper::get('add')?>">
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