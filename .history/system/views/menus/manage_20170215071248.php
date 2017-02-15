	<div class="row">
    <?php if(!empty($this->menuitems)):?>
      <form action="<?=$this->data->link?>" method="post">
      <?php foreach($this->menuitems as $pos=>$entry):?>
            <div>
              <span><?=$entry['id']?></span>
              <span><?=$entry['pos']?></span>
              <span><?=$entry['title']?></span>
              <span><?=$entry['link']?></span>
              <span><?=$entry['parent']?></span>
              <span><?=$pos?></span>
            </div>
      <?php endforeach;?>
      </form>
    <?php endif;?>
<?=var_dump($this->out)?>
	</div>