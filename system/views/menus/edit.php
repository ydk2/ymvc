<?php if($this -> pages):?>
<?=$this -> showin(SYS.V . "menus/adds");?>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-12">
			<h1>Edit menu entries</h1>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-12">
			<form action="<?=HOST_URL ?>/?menus=menus/edit&action=edit&data=<?=$this->groups?>" method="post">
				<table  class="table">
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
							<td><a class="btn btn-info" href="<?=HOST_URL ?>/?menus=menus/edit&action=edit&data=<?=$this->groups?>">Reload to see changes</a></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<?php else: $this -> show(SYS.V . "menus/adds");?>

<?php endif ?>