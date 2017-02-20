<?php
$this->inc(ROOT.SYS.C.Helper::get('path').DS.helper::get('add'));
$name = basename(helper::get('add'),'.php');
//$config = $name::Config();
?>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';?>">List</a>
</div>
<div class="list-group-item">
<?=$config['title']?>
</div>
<div class="list-group-item">
<?=ROOT.SYS.C.Helper::get('path').DS.helper::get('add')?>
</div>
</div>