

      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="media-list">
              <li class="media">
                <a class="pull-left" href="#"><img class="media-object" src="https://unsplash.imgix.net/photo-1420708392410-3c593b80d416?w=1024&amp;q=50&amp;fm=jpg&amp;s=db450320d7ee6de66c24c9b0bf2de3c6" height="64" width="64"></a>
                <div class="media-body">
                  <h4 class="media-heading"><?=Intl::_('Check Form')?> <?=$this->name?></h4>
                  <p><?=$this->email?> <?=$this->pass?> <?=$this->pass2?></p>
                  <p>
                  	<a class="btn btn-primary" href="<?=HOST_URL?>?admin:mngaccount&action=login"><?=Intl::_('Login')?></a> 
                  	<a class="btn btn-primary" href="<?=HOST_URL?>?admin:mngaccount&action=register"><?=Intl::_('Register')?></a>
                  </p>
                <p><?=$this->alert?></p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
