<?php $e = $this->Page("/App/Controllers/Shared/E",$this->model);?>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissable">
          <h1><?=$e['error']?> <?=$e['response']?></h1>
          <p class="section-invert">
            <b><a href="<?=HOST?>">Home</a></b>
          </p>
        </div>
      </div>
    </div>
  </div>