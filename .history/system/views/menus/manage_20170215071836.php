	<div class="row">
    <?php if(!empty($this->menuitems)):?>
      <form role="form" action="<?=$this->data->link?>" method="post">
      <?php foreach($this->menuitems as $id=>$entry):?>
            <div>
            <select>

            </select>
              <span><?=$entry['id']?></span>
              <span><?=$entry['pos']?></span>
              <span><?=$entry['title']?></span>
              <span><?=$entry['link']?></span>
              <span><?=$entry['parent']?></span>
              <span><?=$pos?></span>
            </div>
      <?php endforeach;?>
      <input type="hidden" name="item[<?=$id?>][id]" value"<?=$entry['id']?>">
      <button class="btn btn-success" type="submit">Update</button>
      </form>
    <?php endif;?>
<?=var_dump($this->out)?>
	</div>