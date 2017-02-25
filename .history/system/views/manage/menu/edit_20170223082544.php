<div class="col-sm-12">
	<h3>Edit Items</h3>
<form class="form" role="form" action="<?=$this->data->link?>&action=update" method="post">
<div class="form-group">
  <div class="col-sm-12">
    <div class="input-group">
      <button class="btn btn-success" type="submit">Update</button>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
      <a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
    </div>
  </div>
</div>
<?php foreach($this->items as $id=>$entry):?>
<div class="form-group">
      <div class="col-sm-12">
        <div class="input-group">


            <select class="form-control" name="items[<?=$id?>][pos]">
            <?php $i=1; foreach ($this->items as $pos) : ?>
            <?php $selected = ($entry['pos']===$i)?' selected="selected"':''; ?>
              <option value="<?=$i?>"<?=$selected?>><?=$i?></option>
            <?php $i++; endforeach;?>
            </select>
          	<span class="input-group-addon">pos</span>
            <input class="form-control" type="text" name="items[<?=$id?>][title]" value="<?=$entry['title']?>">

          	<span class="input-group-addon">name</span>
            <input class="form-control" type="text" name="items[<?=$id?>][link]" value="<?=$entry['link']?>">
          	<span class="input-group-addon">link</span>

            <select class="form-control" name="items[<?=$id?>][parent]">
            <option value="">No parent</option>
            <?php foreach ($this->items as $parents) : ?>
            <?php if($entry['id']!=$parents['id']):?>
            <?php $selected = ($entry['parent']==$parents['id'])?' selected="selected"':''; ?>
              <option value="<?=$parents['id'];?>"<?=$selected?>><?=$parents['title'];?></option>
            <?php endif; ?>
            <?php endforeach;?>
			</select>
          	<span class="input-group-addon">parent</span>
			<span class="input-group-btn">
            <a class="btn btn-danger" href="<?=$this->data->link?>&action=delete&item=<?=$entry['id']?>"><?=intl::_('Usuń')?></a>
		  	</span>

            <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
            <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">

		</div>
	</div>
</div>
<?php endforeach;?>

</form>

</div>