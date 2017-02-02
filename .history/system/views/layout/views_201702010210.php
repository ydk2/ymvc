<?php
//var_dump($this->data->layout);

?>
<?php foreach ($this->data->layout as $view) : ?>
<div>
    <?=$view['content'] ?>
</div>
<?php endforeach; ?>
<?php ?>