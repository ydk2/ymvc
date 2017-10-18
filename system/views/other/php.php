<main class="main">


<div class="row">
<div class="col-md-2">
<ul class="list-group">
<?php foreach ($this->ViewData('list')->items as $value): ?>
<li class="list-group-item"><a href="<?=$value['href'];?>"><?=$value;?></a></li>
<?php endforeach; ?>
</ul>
</div>
<div class="col-md-10">
<div class="well">
<h2><?=$this->ViewData('subheader');?></h2>
<p>
<?=$this->ViewData('content');?>
</p>
</div>
</div>
</div>


</main> <!-- main -->