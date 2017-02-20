<a class="btn btn-info" href="<?=$this->link;?>">Start</a>
<ul class"list-group">
<?php

foreach($this->files as $file){
?>
<li class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->link.'&path='.$file['name'];?>"><?=$file['path'];?></a>
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