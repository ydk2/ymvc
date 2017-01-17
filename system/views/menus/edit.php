<?php if($this -> pages):?>

  <div class="row">
    <div class="col-md-12">
      <h1>Edit menu entries</h1>
    </div>
  </div>

  <div class="row" id="editmenu">
    <div class="col-md-12">
      <form action="<?=HOST_URL ?>?admin:mngmenus&action=edit&data=<?=$this->groups?>" method="post">
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
            <?=$this -> edit_menu($this -> pages) ?>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="go" value="update">
                </td>
                <td><a class="btn btn-info" href="<?=HOST_URL ?>?admin:mngmenus&data=<?=$this->groups?>">Go tu main</a></td>
                <td>
                  <a type="button" href="<?=HOST_URL ?>?admin:mngmenus&action=adds&data=<?=$this->groups?>" class="btn btn-success">add new</a>
                </td>

              </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>

<?php else: ?>
<?php endif ?>