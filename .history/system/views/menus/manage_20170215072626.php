	<div class="row">
    <?php if(!empty($this->menuitems)):?>
      <form role="form" action="<?=$this->data->link?>" method="post">
      <?php foreach($this->menuitems as $id=>$entry):?>
            <div>
            <select name="items[<?=$id?>][pos]">
            <?php for ($i=1; $i <= count($this->menuitems); $i++) : ?>

              <option><?=$i?></option>
            <?php endfor;?>
            </select>
              <span><?=$entry['id']?></span>
              <span><?=$entry['pos']?></span>
              <span><?=$entry['title']?></span>
              <span><?=$entry['link']?></span>
              <span><?=$entry['parent']?></span>
              <span><?=$id?></span>

      <input type="hidden" name="items[<?=$id?>][id]" value="<?=$entry['id']?>">
            </div>
      <?php endforeach;?>
      <button class="btn btn-success" type="submit">Update</button>
      </form>
    <?php endif;?>
<?=var_dump(Helper::post('items'))?>
	</div>