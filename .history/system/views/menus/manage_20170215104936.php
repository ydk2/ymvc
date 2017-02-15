	<div class="row">
    <?php if(!empty($this->menuitems)):?>
      <form role="form" action="<?=$this->data->link?>" method="post">
      <?php foreach($this->menuitems as $id=>$entry):?>
            <div>
            <select name="items[<?=$id?>][pos]">
            <?php $i=1; foreach ($this->menuitems as $pos) : ?>
            <?php $selected = ($entry['pos']===$i)?' selected="selected"':''; ?>
              <option value="<?=$i?>"<?=$selected?>><?=$i?></option>
            <?php $i++; endforeach;?>
            </select>
            <input type="text" name="items[<?=$id?>][title]" value="<?=$entry['title']?>">
            <input type="text" name="items[<?=$id?>][link]" value="<?=$entry['link']?>">

            <select name="items[<?=$id?>][parent]">
            <option value="">No parent</option>
            <?php foreach ($this->menuitems as $parents) : ?>
            <?php if($entry['id']!=$parents['id']):?>
            <?php $selected = ($entry['parent']==$parents['id'])?' selected="selected"':''; ?>
              <option value="<?=$parents['id'];?>"<?=$selected?>><?=$parents['title'];?></option>
            <?php endif; ?>
            <?php endforeach;?>

      <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
      <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">
            </div>
      <?php endforeach;?>
      <button class="btn btn-success" type="submit">Update</button>
      </form>
      <a class="btn btn-info" href="<?=$this->data->link?>">reload</a>
    <?php endif;?>
    <?=$this->menu($this->menuitems);?>

	</div>