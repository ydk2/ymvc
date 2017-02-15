	<div class="row">
    <?php if(!empty($this->menuitems)):?>
      <form role="form" action="<?=$this->data->link?>" method="post">
      <?php foreach($this->menuitems as $id=>$entry):?>
            <div>
            <select name="items[<?=$id?>][pos]">
            <?php for ($i=1; $i <= count($this->menuitems); $i++) : ?>
            <?php $selected = ($entry['pos']==$i)?' selected="selected"':''; ?>
              <option<?=$selected?>><?=$i?></option>
            <?php endfor;?>
            </select>
            <input type="text" name="items[<?=$id?>][title]" value="<?=$entry['title']?>">
            <input type="text" name="items[<?=$id?>][link]" value="<?=$entry['link']?>">

            <select name="items[<?=$id?>][parent]">
            <option value="">No parent</option>
            <?php foreach ($this->menuitems as $parents) : ?>
            <?php $selected = ($entry['parent']==$parents['pos'])?' selected="selected"':''; ?>
              <option value="<?=$parents['pos'];?>"<?=$selected?>><?=$parents['title'];?></option>
            <?php endforeach;?>

      <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
      <input type="hidden" name="items[<?=$id?>][group]" value="<?=$this->group?>">
            </div>
      <?php endforeach;?>
      <button class="btn btn-success" type="submit">Update</button>
      </form>
    <?php endif;?>
<?=var_dump(Helper::post('items'))?>
	</div>