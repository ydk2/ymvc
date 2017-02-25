<?php
$list = array();
$pagination=$this->Loader(SYS.C.'elements-pagination');
if($pagination!=null){
  $pagination->limit = 5;
  $pagination->items = $this->group_list;
  $list = $pagination->paginate_list($this->group_list);
}
?>
  <div class="row">
  <div class="col-sm-12">
  <h3>Administracja Grupami</h3>
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form" method="get" action="<?=HOST_URL ?>">
    <div class="form-group">
        <div class="input-group">
        <input type="hidden"  name="manage<?=S;?>manage" value="manage<?=S;?>groups">
        <input type="text" class="form-control" name="group" value="<?=$this->group?>" placeholder="Wpisz nazwę nowej grupy"/>
        <span class="input-group-btn">
    	  <button class="btn btn-success" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
	</div>

  <div class="col-sm-12">
  <?php if(helper::get("group")!=""): $group=helper::get("group");?>
  <div class="list-group">
  <div class="list-group-item">
  <h4>Wybrana grupa &#160;</h4>
  </div>
  <div class="list-group-item">
  <div class="btn"><?=$group?></div>
    <a class="btn btn-info pull-right" href="<?=$this->link?>=manage<?=S;?>layouts&group=<?=$group?>">Układy</a>
    <a class="btn btn-primary pull-right" href="<?=$this->link?>=manage<?=S;?>menus&group=<?=$group?>">Menu</a>
    <a class="btn btn-warning pull-right" href="<?=$this->link?>=manage<?=S;?>modules&group=<?=$group?>">Moduły</a>
  </div>
  </div>
  <?php endif;?>

  <?php if(!empty($this->group_list)):?>
  <div class="list-group">
    <div class="list-group-item">Wybierz z listy"</div>
  <?php foreach ($list as $grp) { ?>
  <div class="list-group-item">
    <a class="btn btn-link" href="<?=$this->link?>=manage<?=S;?>groups&group=<?=$grp?>"><?=$grp?></a>
    <a class="btn btn-info pull-right" href="<?=$this->link?>=manage<?=S;?>layouts&group=<?=$grp?>">Układy</a>
    <a class="btn btn-primary pull-right" href="<?=$this->link?>=manage<?=S;?>menus&group=<?=$grp?>">Menu</a>
    <a class="btn btn-warning pull-right" href="<?=$this->link?>=manage<?=S;?>modules&group=<?=$grp?>">Moduły</a>
  </div>
  <?php } ?>
  </div>
  <?php endif;?>
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