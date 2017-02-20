	<div class="row">

  <?php if(!Helper::post('items') && !empty($this->items)):?>
  <div class="col-sm-12">
      <h3>Edit Items</h3>
      <form class="form" role="form" action="<?=$this->data->link?>&action=update" method="post">
      <div class="col-sm-12">
      <button class="btn btn-success" type="submit">Update</button>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
      <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
      </div>
      <div class="col-sm-12">
      <?php foreach($this->items as $id=>$entry):?>
            <div class="col-sm-6 well">

            <select class="form-control" name="items[<?=$id?>][pos]">
            <?php $i=1; foreach ($this->items as $pos) : ?>
            <?php $selected = ($entry['pos']===$i)?' selected="selected"':''; ?>
              <option value="<?=$i?>"<?=$selected?>><?=$i?></option>
            <?php $i++; endforeach;?>
            </select>
            <input class="form-control" type="text" name="items[<?=$id?>][title]" value="<?=$entry['title']?>">
            <input class="form-control" type="text" name="items[<?=$id?>][link]" value="<?=$entry['link']?>">

            <select class="form-control" name="items[<?=$id?>][parent]">
            <option value="">No parent</option>
            <?php foreach ($this->items as $parents) : ?>
            <?php if($entry['id']!=$parents['id']):?>
            <?php $selected = ($entry['parent']==$parents['id'])?' selected="selected"':''; ?>
              <option value="<?=$parents['id'];?>"<?=$selected?>><?=$parents['title'];?></option>
            <?php endif; ?>
            <?php endforeach;?>
            <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
            <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">
            <a class="btn btn-danger" href="<?=$this->data->link?>&action=delete&item=<?=$entry['id']?>">Remove</a>
            </div>
      <?php endforeach;?>
      </div>
      </form>
      </div>
      <!--
      <div class="col-sm-12">
        <?=$this->menu($this->items);?>
      </div>
      -->
      </div>
  <?php else:?>

  <div class="col-sm-offset-2 col-sm-8">
  <hr>
    <div class="well">
      <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
      <p class="text-primary"><?=$this->ViewData('text')?></p>
      <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
    </div>
  </div>
  <?php endif;?>

  <div class="col-sm-offset-2 col-sm-8">
      <h3>Add new item</h3>
       <form class="form" role="form" action="<?=$this->data->link?>&action=add" method="post">

       <input name="item[title]" type="text" class="form-control" value="" placeholder="Title">
       <input name="item[link]" type="text" class="form-control" value="" placeholder="Link">
       <input name="item[group]" type="hidden" value="<?=$this->group?>">
       <input name="item[id]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[pos]" type="hidden" value="<?=$this->freekey()?>">
       <input name="item[parent]" type="hidden" value="">
       <button name="add" type="submit" class="btn btn-block btn-success">Dodaj</button>
       </form>
  </div>

	</div>