
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->data->link;?>">Start</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=application">Applikacje</a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=system">System</a>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(base64_decode(dirname($file['path'])));?>">Wróć</a>
</div>
<?php if(!empty($this->files)){ ?>
<?php foreach($this->files as $file){ ?>
<div class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>"><?=$file['path'];?></a>
<?php } else { ?>

<?=$file['name'];?>&#160;
<a class="btn btn-sm btn-success" href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>">dodaj</a>
<a class="btn btn-sm btn-danger" href="<?=$this->data->link.'&path='.base64_encode($file['path']);?>">usuń</a>
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
