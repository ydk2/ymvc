
<ul class="nav nav-tabs">
<?php

foreach($this->files[DOCROOT.SYS.C] as $k => $file){
?>
<li><?=$file[$k]['path'];?> </li>
<?php
}
?>
</ul>
<?php

?>