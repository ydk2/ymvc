<?php $data = $this->Page("/App/Controllers/Test",$this->model);?>        
<div class="container">
    <!-- Left-aligned -->
    <div class="col-sm-12">
        <div class="row">
            <div class="media">
                <div class="media-left media-top">
                    <img src="<?=HOST?>/app/views/default/images/logo2.png" class="media-object" style="width:8em"/>
                    <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=test">Test</a>
                    <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=main">Main</a>
                    <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=login">Login</a>
                    <a class="media-object btn btn-full btn-info" href="<?=HOST?>?view=error">Error</a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <?=$data['xml']?>
                    </h4>
                    <div class="section-invert" style="overflow-wrap:break-word;">
                        <?=$data['error']?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>