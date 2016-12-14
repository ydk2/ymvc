        <div class="row"  id="editmenu">
          <div class="col-md-12">
            <div class="jumbotron">
              <h1><?=$this->alert_header?></h1>
              <p><?=$this->alert_string?></p>
              <p> 
              	<a href="<?=HOST_URL?>?admin:menus&action=edit&data=<?=$this->groups?>" class="btn btn-primary">Edit menu</a>
              	<a href="<?=HOST_URL?>?admin:menus&action=adds&data=<?=$this->groups?>" class="btn btn-primary">Add new menu entry</a>
              	<a href="<?=HOST_URL?>?admin:menus=menus:help" class="btn btn-info">Help</a>
              </p>
            </div>
          </div>

        </div>


	<div class="row">
		<div class="col-md-12">
			<?php if($this -> pages):?>
      <?= $this->menulist($this -> pages); ?>
      <?php endif ?>
		</div>
	</div>
   