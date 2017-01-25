        <div class="row vertical-center">
          <div class=" col-md-offset-4 col-md-6 col-md-offset-0">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h2 class="panel-title">
                  <i class="fa fa-fw fa-sign-in"></i>Zaloguj</h2>
              </div>
              <div class="panel-body">
                <div class="row login-form">
                  <div class="col-md-12">
                    <form class="form-horizontal" role="form" method="POST" id="login" action="?login<?=S;?>form&action=login">
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="login" class="control-label">Login</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="login" placeholder="Login" name="account_login" value="<?=Helper::post('account_login');?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-2">
                          <label for="password" class="control-label">Hasło</label>
                        </div>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password" placeholder="Hasło" name="account_pass">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  name="remember">Zapamiętaj mnie</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-block btn-info">Zaloguj</button>
                        </div>
                      </div>
                    </form>
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