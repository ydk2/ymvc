
<ul class="nav nav-tabs">
<?php

foreach($this->files as $k => $file){
?>
<li><?=$file[$k]['path'];?> </li>
<?php
}
?>
</ul>
<?php

?>