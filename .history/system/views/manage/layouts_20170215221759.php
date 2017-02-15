	<div class="row">
  <div class="col-sm-12">
  <div class="col-sm-3">
	<div class="row">
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form" method="get" action="<?=HOST_URL ?>">
    <div class="form-group">
        <div class="input-group">
        <input type="text" class="form-control" name="group" value="<?=$this->group?>" placeholder="Wpisz nazwę nowej grupy"/>

        <span class="input-group-btn">
    	  <button class="btn btn-success" name="manage<?=S;?>layouts" value="groups" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
	</div>
    <div class="row">
      <h3>Add new item</h3>
       <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">

       <input name="item[name]" type="text" class="form-control" value="">
       <input name="item[module]" type="text" class="form-control" value="">
       <input name="item[view]" type="text" class="form-control" value="">
       <input name="item[class]" type="text" class="form-control" value="">
       <input name="item[attrid]" type="text" class="form-control" value="">
       <input name="item[mode]" type="text" class="form-control" value="">
       <input name="item[group]" type="hidden" value="<?=$this->group?>">
       <input name="item[id]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[pos]" type="hidden" value="<?=$this->freekey()?>">
       <button name="add" type="submit" class="btn btn-block btn-success">Dodaj</button>
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

  <?php if(!Helper::post('items') && !empty($this->items)):?>
<hr>
  <div class="col-sm-9">
      <h3>Edit Items</h3>
      <form class="form-inline" role="form" action="<?=$this->data->link?>&action=update" method="post">
      <?php foreach($this->items as $id=>$entry):?>
            <div class="table table-striped">

            <select class="form-control" name="items[<?=$id?>][pos]">
            <?php $i=1; foreach ($this->items as $pos) : ?>
            <?php $selected = ($entry['pos']===$i)?' selected="selected"':''; ?>
              <option value="<?=$i?>"<?=$selected?>><?=$i?></option>
            <?php $i++; endforeach;?>
            </select>
            <input class="form-control" type="text" name="items[<?=$id?>][name]" value="<?=$entry['name']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][module]" value="<?=$entry['module']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][view]" value="<?=$entry['view']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][class]" value="<?=$entry['class']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][attrid]" value="<?=$entry['attrid']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][mode]" value="<?=$entry['mode']?>">

            <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
            <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">
            <a class="btn btn-danger" href="<?=$this->data->link?>&action=delete&item=<?=$entry['id']?>">Remove</a>
            </div>
      <?php endforeach;?>
      <button class="btn btn-success" type="submit">Update</button>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
      </form>
      </div>

      </div>
  <?php else:?>

  <div class="col-sm-9">
  <hr>
    <div class="well">
      <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
      <p class="text-primary"><?=$this->ViewData('text')?></p>
      <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
    </div>
  </div>
  <?php endif;?>
  </div>
	</div>