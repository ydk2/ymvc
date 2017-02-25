<div class="row">

<div class="col-sm-12">
  <h3><?=intl::_('Wybierz nowy moduł')?></h3>
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Grupy')?></a>
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group?>"><?=intl::_('Moduły')?></a>
<?php $base = ROOT.base64_decode(helper::get('path')); if (strpos($base, SYS.C) !== false || strpos($base, APP.C) !== false) { ?>
<a class="btn btn-warning" href="<?=$this->data->link.'&path='.base64_encode(dirname(base64_decode(helper::get('path'))));?>"><?=intl::_('Wróć')?></a>
<?php } ?>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=application"><?=intl::_('Aplikacje')?></a>
<a class="btn btn-info" href="<?=$this->data->link;?>&app=system"><?=intl::_('System')?></a>
</div>
<?php if(!empty($this->files)){ ?>
<?php foreach($this->files as $file){
$path = str_replace(ROOT,'',$file['path']);
$path = str_replace(EXT,'',$path);
?>
<div class="list-group-item">
<?php if($file['dir']){ ?>
<a href="<?=$this->data->link.'&path='.base64_encode($path);?>"><?=$path;?></a>
<?php } else { ?>

<span class="btn btn-link lead"><?=$file['name'];?>&#160;</span>

<?php if ($this->model->cache->itemExists($this->items,$path,'path')) { ?>
<p class="btn btn-warning pull-right"><?=intl::_('Moduł zarejestrowany')?></p>
<?php } else { ?>
<a class="btn btn-sm btn-success pull-right" href="<?=$this->data->link.'&path='.base64_encode($path);?>"><?=intl::_('Dodaj')?></a>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<?php } else { ?>
<div class="list-group-item">
<h4><?=intl::_('Coś nie tak')?></h4>
<p><?=intl::_('Pusto, Nic tu nie ma')?></p>
</div>
<?php } ?>
</div>
</div>

   <div class="col-sm-12 well">
    <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Bieżąca grupa')?> "<?=$this->group?>" </a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'.S.'available&group='.$this->group);
      ?>
  </div>
</div>
<?php
$pagination=$this->Loader(SYS.C.'elements-pagination');
if($pagination!=null){
  $pagination->groups = $this->group;
  $pagination->Show(SYS.V.'elements-pagination');
}

?>
