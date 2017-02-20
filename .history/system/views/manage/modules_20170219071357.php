
<ul class"list-group">
<li class="list-group-item">
<a class="btn btn-info" href="<?=$this->link;?>">Start</a>
</li>
<?php

foreach($this->files as $file){
?>
<li class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.$file['name'];?>"><?=$file['path'];?></a>
<?php } else { ?>
<?=$file['name'];?>
<a class="btn btn-success" href="<?=$this->data->link.'&path='.$file['name'].'&add='.$file['name'];?>">dodaj</a>
<a class="btn btn-danger" href="<?=$this->data->link.'&path='.$file['name'].'&del='.$file['name'];?>">usuń</a>
<?php } ?>
</li>
<?php
}
?>
</ul>
<?php

?>