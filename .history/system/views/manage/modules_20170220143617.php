
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info pull-right" href="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'groups&group='.$this->group?>">Grupy</a>
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'available&group='.$this->group.'';?>">Available</a>
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';?>">List</a>
</div>
</div>
<?php
var_dump(helper::post('check'));
?>
<div class="col-sm-12">
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form-inline" method="post" action="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'?>">
    <div class="form-group">
        <div class="input-group">
        <input type="hidden"  name="manage<?=S;?>manage" value="manage<?=S;?>groups">
        <label>Test<input type="checkbox" class="checkbox" name="check[group]" value="<?=$this->group?>" >
		</label>
        <span class="input-group-btn">
    	  <button class="btn btn-success" name="check[one]" value="true" type="submit">jeden</button>
    	  <button class="btn btn-warning" name="check[two]" value="true" type="submit">dwa</button>
        </span>
        </div>
    </div>
    </form>
</div>