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
		<div class="col-md-3">
      <h3>Current Menu Items</h3>
			<?php if($this -> pages):?>
      <?= $this->menulist($this -> pages); ?>
      <?php endif ?>
		</div>
		<div class="col-md-3">
      <h3>Menus groups</h3>
      <?= $this->menugroups(); ?>
		</div>

          <div class="col-md-6">
          <h3>Add New Menus group</h3>
            <form role="form">
              <div class="form-group">
                <label class="control-label" for="nmenu">Add new menu</label>
                <div class="input-group">
                  <input id="nmenu" type="text" value="<?=$this->groups;?>" class="form-control" placeholder="Enter new menu name">
                  <span class="input-group-btn">
                    <a class="btn btn-success" id="add">Add</a>
                  </span>
                  <script>
                  $('#add').click(function(){
                    document.location.href = "?admin:menus&data="+$('#nmenu').val();
                  });  
                  </script>
                </div>
              </div>
            </form>
          </div>
	</div>
   