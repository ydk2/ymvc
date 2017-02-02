<?php
var_dump($this->data);

?>
<h1>ffff</h1>
<?php foreach ($this->data->layout as $view) : ?>
<div class="<?=$view['class']?>">
    <?=$view['content']?>
</div>
<?php endforeach; ?>
<?php ?>