
  <div class="row">

  <?php if(!Helper::post('items') && !empty($this->items)):?>
  <div class="col-sm-12">
  <div class="row">
	<ul class="breadcrumb">
    <li><strong>Pokaż w kolumnach</strong></li>
		<?php foreach($this->columns as $n=>$l) { ?>
			<li><a href="<?=$l?>">
        <?=$n?>
			</a></li>
		<?php } ?>
	</ul>
	</div>
  <div class="row">
      <h3>Edytuj Układ</h3>
      <form class="form" role="form" action="<?=$this->data->link?>&action=update" method="post">
      <div class="col-sm-12">
      <button class="btn btn-success" type="submit">Update</button>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
      <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>

      </div>
      <div class="col-sm-12">
      <?php foreach($this->items as $id=>$entry):?>
            <div class="<?=$this->cols;?> well">

            <select class="form-control" name="items[<?=$id?>][pos]">
            <?php $i=1; foreach ($this->items as $pos) : ?>
            <?php $selected = ($entry['pos']===$i)?' selected="selected"':''; ?>
              <option value="<?=$i?>"<?=$selected?>><?=$i?></option>
            <?php $i++; endforeach;?>
            </select>
            <input class="form-control" type="text" name="items[<?=$id?>][name]" value="<?=$entry['name']?>" placeholder="Name">
            <input class="form-control" type="text" name="items[<?=$id?>][module]" value="<?=$entry['module']?>" placeholder="Module">
            <input class="form-control" type="text" name="items[<?=$id?>][view]" value="<?=$entry['view']?>" placeholder="View">
            <input class="form-control" type="text" name="items[<?=$id?>][class]" value="<?=$entry['class']?>" placeholder="Class">
            <input class="form-control" type="text" name="items[<?=$id?>][attr]" value="<?=$entry['attr']?>" placeholder="Attribute">
            <input class="form-control" type="text" name="items[<?=$id?>][mode]" value="<?=$entry['mode']?>" placeholder="Mode">

            <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
            <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">
            <a class="btn btn-danger" href="<?=$this->data->link?>&action=delete&item=<?=$entry['id']?>">Usuń</a>
    <?php
    if(in_array($entry['module'],$this->special)){
    ?>
        <a class="btn btn-success" href="<?=$this->link?>&group=<?=$entry['name']?>" >Edytuj</a>
    <?php }
    if(in_array($entry['module'],$this->menus)){
    ?>
        <a class="btn btn-success" href="?manage<?=S?>manage=manage<?=S?>menus&group=<?=$this->group?>" >Edytuj menu</a>
    <?php } if($entry['attr']!="") { ?>
        <a class="btn btn-success" href="?manage<?=S?>manage=manage<?=S?>menus&group=<?=$entry['attr']?>" >Edytuj menu</a>
    <?php } ?>
            </div>
      <?php endforeach;?>
      </div>
      </form>
      </div>
      </div>
      </div>
  <?php else:?>
  <div class="col-sm-offset-2 col-sm-8">
    <div class="well">
      <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
      <p class="text-primary"><?=$this->ViewData('text')?></p>
      <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
    </div>
  </div>
  <?php endif;?>

  <div class="col-sm-offset-2 col-sm-8 well">
      <h3>Nowy układ</h3>
       <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">

       <input name="item[name]" type="text" class="form-control" value="" placeholder="Name">
       <input name="item[module]" type="text" class="form-control" value="" placeholder="Module">
       <input name="item[view]" type="text" class="form-control" value="" placeholder="View">
       <input name="item[class]" type="text" class="form-control" value="" placeholder="Class">
       <input name="item[attr]" type="text" class="form-control" value="" placeholder="Attribute">
       <input name="item[mode]" type="text" class="form-control" value="" placeholder="Mode">
       <input name="item[group]" type="hidden" value="<?=$this->group?>">
       <input name="item[id]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[pos]" type="hidden" value="<?=$this->freekey()?>">
       <button name="add" type="submit" class="btn btn-block btn-success">Dodaj</button>
       </form>
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