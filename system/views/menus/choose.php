        <div class="row">
          <div class="col-md-12">
            <div class="jumbotron">
              <h1><?=$this->alert_header?></h1>
              <p><?=$this->alert_string?></p>
              <p> 
              	<a href="<?=HOST_URL?>/?menus=menus/edit&action=edit&data=<?=$this->groups?>" class="btn btn-primary">Edit menu</a>
              	<a href="<?=HOST_URL?>/?menus=menus/adds&action=adds&data=<?=$this->groups?>" class="btn btn-primary">Add new menu entry</a>
              	<a href="<?=HOST_URL?>/?<?=$this->alert_link?>" class="btn btn-primary">Reload</a>
              </p>
            </div>
          </div>
        </div>