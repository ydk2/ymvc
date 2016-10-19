
<div>
<h3><?=$this->ViewData('title');?></h3>
<div><b><?=$this->ViewData('header');?></b></div>
<div><?=$this->ViewData('alert');?></div>
<div><a href="<?=HOST_URL;?>">Go back</a></div>
<div>
	<?=Intl::_('Posts Categorized:','po_phpcall');?>
</div>
<div>

	
<ul>
	<?php foreach ($this->langs as $key => $value) : ?>
		<li><a href="<?=HOST_URL;?>?<?=htmlentities("setlocale");?>=<?=$value;?>"><?=$value;?></a></li>
	<?php endforeach; ?>
</ul>
</div>
</div>

