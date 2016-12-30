
        <div class="row">
          <div class="col-md-8">
            <form class="form-horizontal" method="post" action="<?=HOST_URL?>?admin:account&action=login" role="form">
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="Email" class="control-label">Email</label>
                </div>
                <div class="col-sm-10">
                  <input type="text"  name="name" class="form-control" id="Email" placeholder="Email" value="<?=$this->name?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-2">
                  <label for="Password" class="control-label">Password</label>
                </div>
                <div class="col-sm-10">
                  <input type="password"  name="password" class="form-control" id="Password" placeholder="Password" value="<?=$this->pass?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="from" value="login"/>
                <input type="submit" class="btn btn-primary" value="Sign in"/>
                <a class="btn btn-primary" href="<?=HOST_URL?>/?admin:account&action=register">Register</a>
                </div>
              </div>
            </form>
          </div>
        </div>
