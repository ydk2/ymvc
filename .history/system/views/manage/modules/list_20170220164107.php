
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
<a class="btn btn-info" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>">Moduły</a>

</div>
<?php if(!empty($this->items)){ ?>
<?php foreach($this->items as $file){ ?>
<div class="list-group-item">

<span class="btn btn-link lead"><?=$file['title'];?>&#160;</span>
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.base64_encode($file['path']).'&item='.$file['id'];?>">Edytuj</a>
<a class="btn btn-sm btn-danger pull-right" href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>">Usuń</a>

</div>
<?php } ?>
<?php } else { ?>
<div class="list-group-item">
<h4>Coś nie tak</h4>
<p>Pusto, Nic tu nie ma</p>
</div>
<?php } ?>
</div>
