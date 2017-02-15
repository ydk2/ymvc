	<div class="row">
  <?php if(!Helper::post('items')):?>
    <?php if(!empty($this->items)):?>
      <form class="form-inline" role="form" action="<?=$this->data->link?>" method="post">
      <?php foreach($this->items as $id=>$entry):?>
            <div class="table table-striped">

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
            <a class="btn btn-danger" href="<?=$this->data->link?>&delete=<?=$entry['id']?>">Remove</a>
            </div>
      <?php endforeach;?>
      <button class="btn btn-success" type="submit">Update</button>
      </form>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
    <?php endif;?>
    <?=$this->menu($this->items);?>
  <?php else:?>
          <div class="row">
          <div class="col-sm-12">
            <div class="well">
              <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
              <p class="text-primary"><?=$this->ViewData('text')?></p>
              <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
            </div>
          </div>
        </div>
  <?php endif;?>
	</div>