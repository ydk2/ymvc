<?php
$name = basename(helper::get('add'),'.php');
$this->Inc(SYS.C.Helper::get('path').DS.$name);

$config = $name::Config();
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';?>">List</a>
</div>
<div class="list-group-item">
Tytuł "<?=$config['title'];?>" of <?=$name?>
</div>
<div class="list-group-item">
Dostęp dla: <?=implode(', ',$config['access_groups']);?>
</div>
<div class="list-group-item">
Zainstalowano w: <?=ROOT.SYS.C.Helper::get('path').DS.helper::get('add')?>
</div>
</div>