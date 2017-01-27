
        <div class="row vertical-center">
          <div class=" col-md-offset-4 col-md-6 col-md-offset-0">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h2 class="panel-title">
                  <i class="fa fa-fw fa-sign-in"></i>Wyloguj</h2>
              </div>
              <div class="panel-body">
                <div class="row login-form well">
                  <div class="col-md-12">
                    <h1>Wyloguj <?=$this->ViewData('user_name');?></h1>
                    <p class="lead">Napewno?</p>
                    <p>Teraz możesz wylogować się lub wrócić do konta</p>
                  </div>
                  <div class="col-sm-12">
                    <a class="btn btn-block btn-info" href="<?=$this->ViewData('success_link');?>">Wróć do konta</a>
                    <a class="btn btn-block btn-danger" href="?login<?=S;?>form&action=bye&token=<?=$this->ViewData('token');?>">Wyloguj</a>
                  </div>
                </div>
                <div class="row login-bar">
                  <div class="col-md-12">
                    <div class="alert alert-dismissable <?=$this->ViewData('classes');?>">
                      <button contenteditable="false" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?=$this->ViewData('alert');?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
