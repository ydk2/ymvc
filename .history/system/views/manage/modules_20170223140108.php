<div class="row">
<div class="col-sm-12">
  <h3>Administracja Modułami</h3>
<div class"list-group">
<div class="list-group-item">
<span class="btn btn-link lead">Grupy&#160;</span>
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Zarządzaj grupami</a>
</div>
<div class="list-group-item">
<span class="btn btn-link lead">Moduły zarejestrowane&#160;</span>
<a class="btn btn-info pull-right" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';?>">Zarządzaj</a>
</div>
<div class="list-group-item">
<span class="btn btn-link lead">Moduły dostępne&#160;</span>
<a class="btn btn-success pull-right" href="<?=$this->link.'='.'manage'.S.'modules'.S.'available&group='.$this->group.'';?>">Zarejestruj nowy</a>
</div>
</div>
<?php
?>
</div>

  <div class="col-sm-12 well">
    <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>"><?=intl::_('Bieżąca grupa')?> "<?=$this->group?>" </a>
      <?php
        if(helper::session('backlink')){
      ?>
      <a class="btn btn-warning pull-left" href="<?=helper::session('backlink')?>"><?=intl::_('Wróć')?></a>
      <?php
        }
          helper::session_Set('backlink',HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'layouts&group='.$this->group);
      ?>
  </div>
</div>