<?php if(isset($this -> editor)):?>
<?=$this -> group?>
  <div class="row">
    <div class="col-md-12">
      <h1>Edit menu entries</h1>
    </div>
  </div>

  <div class="row" id="editmenu">
    <div class="col-md-12">
      <form action="<?=HOST_URL ?>?menus<?=S;?>mngmenus&action=update&data=<?=$this->group?>" method="post">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>TITLE</th>
              <th>LINK</th>
              <th>PARENT</th>
              <th>ACCESS</th>
              <th>DELETE</th>
            </tr>
          </thead>
          <tbody>
            <?=$this -> editor ?>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="update" value="update">
                </td>
                <td><a class="btn btn-info" href="<?=HOST_URL ?>?menus<?=S;?>mngmenus&data=<?=$this->group?>">Go tu main</a></td>
                <td>
                  <a type="button" href="<?=HOST_URL ?>?menus<?=S;?>mngmenus&action=adds&data=<?=$this->group?>" class="btn btn-success">add new</a>
                </td>

              </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>

<?php else: ?>
        <div class="row">
          <div class="col-sm-12">
            <div class="well">
              <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
              <p class="text-primary"><?=$this->ViewData('text')?></p>
              <a href="<?=$this->data->link?>" class="btn btn-info btn-large">OK</a>
            </div>
          </div>
        </div>
<?php endif ?>