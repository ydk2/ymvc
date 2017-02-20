
<ul>
<?php

foreach($this->files as $file){
?>
<li>
<?php if($file['dir']){ ?>
<?=$file['path'];?>
<?php } ?>
</li>
<?php
}
?>
</ul>
<?php

?>