
  <div class="row">
  <div class="col-sm-12">
	<div class="row">
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

  <div class="row">
  <?php if(!empty($this->group_list)):?>
  <ul class="list-group custom-restricted">
  <?php foreach ($this->group_list as $grp) { ?>
    <li class="list-group-item">
    <a href="<?=$this->link?>&group=<?=$grp?>"><?=$grp?></a>

    </li>
  <?php } ?>
  </ul>
  <?php endif;?>
  </div>
  </div>
	</div>