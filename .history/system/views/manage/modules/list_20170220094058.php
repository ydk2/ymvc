
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->data->link;?>">Start</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=application">Applikacje</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=system">System</a>
</div>
<?php if(!empty($this->files)){ ?>
<form action="<?=$this->data->link.'&path='.helper::get('path')?>" method="post" class="form-inline">
<?php foreach($this->files as $file){ ?>
<div class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.$file['name'].'&app='.$this->app.'';?>"><?=$file['path'];?></a>
<?php } else { ?>
<?=$file['name'];?>&#160;

<input type="checkbox" name="items[]" value="<?=$file['path']?>">
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.basename(dirname($file['path'])).'&add='.$file['name'].'&action=true'.'&app='.$this->app.'';?>">dodaj</a>
<a class="btn btn-sm btn-danger pull-right" href="<?=$this->data->link.'&path='.basename(dirname($file['path'])).'&del='.$file['name'].'&app='.$this->app.'';?>">usuń</a>
<?php } ?>
</div>
<?php } ?>
<?php if(!$file['dir']){ ?>
<input type="hidden" name="group" value="<?=$this->group?>">
<button type="submit">Zarejestruj</button>
<?php } ?>
</form>
<?php } else { ?>
<div class="list-group-item">
<h4>Coś nie tak</h4>
<p>Pusto, Nic tu nie ma</p>
</div>
<?php } ?>
</div>
<div class="well">
<?php
var_dump(helper::post('items'))
?>
</div>