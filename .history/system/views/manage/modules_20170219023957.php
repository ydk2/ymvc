
<ul class="nav nav-tabs">
<?php

foreach($this->files[0] as $k => $file){
?>
<li><?=$file[$k]['path'];?> </li>
<?php
}
?>
</ul>
<?php

?>