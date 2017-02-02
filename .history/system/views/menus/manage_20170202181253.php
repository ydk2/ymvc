	<div class="row">
	<div class="col-sm-3">
	<div class="row">
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form" method="get" action="{$addgroup}">
    <div class="form-group">
        <div class="input-group">
        <input type="text" class="form-control" name="group" placeholder="Wpisz nazwę nowej grupy"/>

        <span class="input-group-btn">
    	<button class="btn btn-success" name="{$addgrouphidden}" value="add" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
	</div>
	<div class="row">
	<xsl:value-of select="data/addnewitem" disable-output-escaping="yes"/>
	</div>
	<div class="row">
	<strong class="lead"><xsl:value-of select="data/menushead"/></strong>
	<div class="list-group custom-restricted">
		<xsl:for-each select="data/menus/list">
			<a class="list-group-item" href="{@link}">
			<xsl:value-of select="node()" />
			</a>
		</xsl:for-each>
	</div>
	</div>
	</div>
	<div class="col-sm-9">
<div class="row">
          <div class="col-md-12">
            <form role="form">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tytuł</th>
                    <th>Link</th>
                    <th colspan="2">
                      <span>Rodzic</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select name="pos" class="form-control">
                        <option>1</option>
                      </select>
                    </td>
                    <td>
                      <input name="title" class="form-control" value="">
                    </td>
                    <td>
                      <input name="link" class="form-control" value="">
                    </td>
                    <td>
                      <select name="parent" class="form-control">
                        <option>Brak</option>
                      </select>
                    </td>
                    <td>
                      <button name="add" type="submit" class="btn btn-block btn-success">Dodaj</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
        </div>
<?php if(isset($this -> editor)):?>


  <div class="row">
    <div class="col-md-12">
      <h3>Edit menu entries</h3>
    </div>
  </div>

  <div class="row" id="editmenu">
    <div class="col-md-12">
      <form action="<?=HOST_URL ?>?menus<?=S;?>mngmenus&action=update&group=<?=$this->group?>" method="post">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>TITLE</th>
              <th>LINK</th>
              <th>PARENT</th>
              <th>DELETE</th>
            </tr>
          </thead>
          <tbody>
            <?=$this -> editor ?>
              <tr>
                <td>
                  <input class="btn btn-primary" type="submit" name="update" value="update">
                </td>
                <td><a class="btn btn-info" href="<?=HOST_URL ?>?menus<?=S;?>mngmenus&group=<?=$this->group?>">Go tu main</a></td>
                <td>
                  <a type="button" href="<?=HOST_URL ?>?menus<?=S;?>mngmenus&action=adds&group=<?=$this->group?>" class="btn btn-success">add new</a>
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

	</div>
	</div>