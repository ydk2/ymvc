<?php
?>
        <div class="row">
          <div class="col-md-4">
            <div class="well">
              <h2><?=$this -> alert_header ?></h2>
              <p><?=$this -> alert_string ?></p>
            </div>
            <div class="row">
            <div class="col-md-12">
              <a href="<?=HOST_URL ?>?admin:mngaccount&&action=delete" class="btn btn-primary">Delete account</a> 
              <a href="<?=HOST_URL ?>?admin:mngaccount&action=logout" class="btn btn-primary">logout</a>
            </div>
            </div>
          </div>
          <div class="col-md-6">
            <form role="form" method="post" action="<?=HOST_URL ?>?admin:mngaccount&action=change" >
              <div class="form-group">
                <label class="control-label" for="name">Your name</label>
                <input class="form-control" id="name" placeholder="Enter Name"
                type="text" name="name" value="<?=helper::session('user_name')?>">
              </div>
              <div class="form-group">
                <label class="control-label" for="Email">Email address</label>
                <input class="form-control" id="Email" placeholder="Enter email"
                type="email" name="email" value="<?=helper::session('user_email')?>">
              </div>
              <div class="form-group">
                <label class="control-label" for="Password">Password</label>
                <input class="form-control" id="Password" placeholder="Password"
                type="password" name="password">
              </div>
              <input type="submit" class="btn btn-primary" value="Submit">
            </form>
            
          </div>
        </div>
