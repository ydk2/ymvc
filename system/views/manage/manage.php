
  <div class="row">

  <div class="col-sm-12">
  <?php if(!empty($this->group_list)):?>
  <h3>Administracja</h3>
  <div class="list-group">
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>groups">Grupy</a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>layouts">Rozkłady</a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>menus">Menu</a>
    <a class="list-group-item" href="<?=$this->link?>=manage<?=S;?>modules<?=S;?>list">Moduły</a>
  </div>
  <?php endif;?>
  </div>
	</div>