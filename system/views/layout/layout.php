<?php
?>
<?php foreach ($this->data->layout as $view) : ?>
<div class="<?=$view['class']?>">
    <?=$view['content']?>
</div>
<?php endforeach; ?>
<?php ?>