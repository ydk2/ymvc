	<div class="row">

            <?php if(!empty($this->menuitems)): foreach($this->menuitems as $pos=>$entry):?>
            <div>
              <span><?=$entry['id']?></span>
              <span><?=$entry['pos']?></span>
              <span><?=$entry['title']?></span>
              <span><?=$entry['link']?></span>
              <span><?=$entry['parent']?></span>
              <span><?=$pos?></span>
            </div>
            <?php endforeach; endif;?>
<?=var_dump($this->out)?>
	</div>