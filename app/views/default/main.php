<?php $data = $this->Page("/App/Controllers/Main",$this->model);?>
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="media">
            <div class="media-left media-top">
              <img src="<?=HOST?>/app/views/default/images/logo2.png" class="media-object" style="width:8em" />
              <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=test">Test</a>
              <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=main">Main</a>
              <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=login">Login</a>
              <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=error">Error</a>
            </div>
            <div class="media-body">
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <?=$data['main_column']?>
        </div>
      </div>
    </div>
  </div>