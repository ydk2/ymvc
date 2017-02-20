
<ul class"list-group">
<a class="list-group-item btn btn-info" href="<?=$this->link;?>">Start</a>
<?php

foreach($this->files as $file){
?>
<li class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.$file['name'];?>"><?=$file['path'];?></a>
<?php } else { ?>
<?=$file['name'];?>
<?php } ?>
</li>
<?php
}
?>
</ul>
<?php

?>