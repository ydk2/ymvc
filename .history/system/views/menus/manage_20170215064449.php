	<div class="row">

            <?php foreach($this->menuitems as $pos=>$entry):?>
            <div>
              <span><?=$entry['id']?></span>
              <span><?=$entry['pos']?></span>
              <span><?=$entry['title']?></span>
              <span><?=$entry['link']?></span>
              <span><?=$entry['parent']?></span>
            </div>
            <?php endforeach;?>

	</div>