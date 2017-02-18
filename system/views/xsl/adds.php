<?php

?>
        <div class="row">
          <div class="col-md-12">
            <h1>Add new menu entry</h1>
          </div>
        </div>

        <div class="row"  id="editmenu">
          <div class="col-md-12">
            <form class="form-horizontal" role="form" action="<?=HOST_URL ?>?admin<?=S;?>mngmenus&action=adds&data=<?=$this->groups?>" method="post">
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="title" class="control-label">Insert Title</label>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="title" placeholder="New Title"  type="text" name="item_title" value="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="link" class="control-label">Insert Link</label>
                </div>
                <div class="col-sm-10">
                  <input class="form-control" id="link" placeholder="New Link" type="text" name="item_link" value="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" name="add_menu" value="add menu entry" class="btn btn-primary" >
                  <a type="button" href="<?=HOST_URL ?>?admin<?=S;?>mngmenus&action=edit&data=<?=$this->groups?>" class="btn btn-warning" >Edit Menu</a>
                  <a type="button" href="<?=HOST_URL ?>?admin<?=S;?>mngmenus&data=<?=$this->groups?>" class="btn btn-info" >Go to Main</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        