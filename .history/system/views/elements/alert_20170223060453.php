<div class="row">
  <div class="col-md-12">
    <div class="alert alert-dismissable <?=$this->ViewData('type')?>">
      <button contenteditable="false" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <strong><?=$this->ViewData('header')?></strong>
      <?=$this->ViewData('text')?>
    </div>
  </div>
</div>