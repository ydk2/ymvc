<div>
  <h3><?=$this->ViewData('title');?></h3>
  <div>
    <?=$this->ViewData('content');?>
  </div>
  <div>
  <?php foreach ($this->ViewData('links') as $key => $value): ?>
    <a href="<?=$value->a['href'];?>"><?=$value->a;?></a>
  <?php endforeach; ?>
  </div>
</div>