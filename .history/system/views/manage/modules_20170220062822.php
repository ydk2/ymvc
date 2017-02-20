
<div class"list-group">
<div class="list-group-item">
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'available&group='.$this->group.'';?>">Available</a>
<a class="btn btn-info" href="<?=$this->link.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';?>">List</a>
</div>
</div>
<?php
var_dump(helper::post('check'));
?>
<div class="col-sm-12">
	<strong class="lead">Dodaj nową grupę</strong>
	<form role="form" method="post" action="<?=HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'?>">
    <div class="form-group">
        <div class="input-group">
        <input type="hidden"  name="manage<?=S;?>manage" value="manage<?=S;?>groups">
        <input type="checkbox" class="form-control" name="check[group]" value="<?=$this->group?>" >
        <span class="input-group-btn">
    	  <button class="btn btn-success" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
</div>