
<ul>
<?php

foreach($this->files as $file){
?>
<li>
<?php if($file['dir']){ ?>
<?=$file['path'];?>
<a href="<?=$this->link.'?path='.$file['name'];?>"><?=$file['path'];?></a>
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