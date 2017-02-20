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
</div>
<?php
} else {
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'&app='.$this->app.'';?>">Wróć</a>
</div>
<div class="list-group-item">
<h4>Nic tu nie ma</h4>
</div>
</div>
<?php
}
?>