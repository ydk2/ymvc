
<ul class"list-group">
<li class="list-group-item">
<a class="btn btn-info" href="<?=$this->data->link;?>">Start</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&mode=application">Applikacje</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&mode=system">System</a>
</li>
<?php

foreach($this->files as $file){
?>
<li class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.$file['name'];?>"><?=$file['path'];?></a>
<?php } else { ?>
<?=$file['name'];?>&#160;
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.basename(dirname($file['path'])).'&add='.$file['name'].'&action=true';?>">dodaj</a>
<a class="btn btn-sm btn-danger pull-right" href="<?=$this->data->link.'&path='.basename(dirname($file['path'])).'&del='.$file['name'];?>">usuń</a>
<?php } ?>
</li>
<?php
}
?>
</ul>
<?php

?>