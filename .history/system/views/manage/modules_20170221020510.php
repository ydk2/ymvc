<div class="row">
<div class"list-group">
<div class="list-group-item">
<p class="lead">Moduły&#160;</p>
</div>
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
<div class="col-sm-12">
</div>

<div class="col-sm-12 well">
  Bieżąca grupa "<?=$this->group?>" <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
</div>
</div>