
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>">Moduły</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=application">Applikacje</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=system">System</a>
<?php $base = base64_decode(helper::get('path')); if (strpos($base, SYS.C) !== false || strpos($base, APP.C) !== false) { ?>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>">Wróć</a>
<?php } ?>
</div>
<?php if(!empty($this->files)){ ?>
<?php foreach($this->files as $file){ ?>
<div class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>"><?=$file['path'];?></a>
<?php } else { ?>

<span class="btn btn-link lead"><?=$file['name'];?>&#160;</span>

<?php if ($this->model->cache->itemExists($this->items,base64_decode(Helper::get('path')),'path')) { ?>
<p class="btn btn-warning">Moduł zarejestrowany</p>
<?php } else { ?>
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>">Dodaj</a>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<?php } else { ?>
<div class="list-group-item">
<h4>Coś nie tak</h4>
<p>Pusto, Nic tu nie ma</p>
</div>
<?php } ?>
</div>
