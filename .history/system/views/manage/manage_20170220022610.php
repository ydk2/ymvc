
  <div class="row">
  <div class="col-sm-12">
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form" method="get" action="<?=HOST_URL ?>">
    <div class="form-group">
        <div class="input-group">
        <input type="text" class="form-control" name="group" value="<?=$this->group?>" placeholder="Wpisz nazwę nowej grupy"/>
        <span class="input-group-btn">
    	  <button class="btn btn-success" name="manage<?=S;?>groups" value="manage<?=S;?>groups" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
	</div>

  <div class="col-sm-12">
  <?php if(!empty($this->group_list)):?>
  <ul class="list-group">
  <?php foreach ($this->group_list as $grp) { ?>
    <li class="list-group-item">
    <a href="<?=$this->link?>=manage<?=S;?>groups&group=<?=$grp?>"><?=$grp?></a>
    <a href="<?=$this->link?>=manage<?=S;?>layoutss&group=<?=$grp?>">Rozkład</a>
    <a href="<?=$this->link?>=manage<?=S;?>menus&group=<?=$grp?>">Menu</a>
    <a href="<?=$this->link?>manage<?=S;?>modules<?=S;?>list&group=<?=$grp?>">Moduły</a>

    </li>
  <?php } ?>
  </ul>
  <?php endif;?>
  </div>
	</div>