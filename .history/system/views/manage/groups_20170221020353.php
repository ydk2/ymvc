
  <div class="row">
  <div class="col-sm-12">
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
  <?php if(helper::get("group")!=""): $grp=helper::get("group");?>
  <div class="list-group">
    <div class="list-group-item"><h5>Zarządzaj "<?=$grp?>"</h5></div>
    <a class="list-group-item btn-info" href="<?=$this->link?>=manage<?=S;?>layouts&group=<?=$grp?>">Rozkład</a>
    <a class="list-group-item btn-primary" href="<?=$this->link?>=manage<?=S;?>menus&group=<?=$grp?>">Menu</a>
    <a class="list-group-item btn-warning" href="<?=$this->link?>=manage<?=S;?>modules&group=<?=$grp?>">Moduły</a>
  </div>
  <?php endif;?>

  <?php if(!empty($this->group_list)):?>
  <div class="list-group">
    <div class="list-group-item">Wybierz z listy"</div>
  <?php foreach ($this->group_list as $grp) { ?>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>groups&group=<?=$grp?>"><?=$grp?></a>
  <?php } ?>
  </div>
  <?php endif;?>
  </div>

    <div class="col-sm-12 well">
      Bieżąca grupa "<?=$this->group?>" <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
    </div>
  </div>