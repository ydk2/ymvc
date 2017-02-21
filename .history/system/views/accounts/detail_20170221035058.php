<div class="row">
  <div class="col-sm-12">
    <?php if(!empty($this->userdetails)){ ?>
      <?php foreach($this->userdetails as $ukey=>$uvalues) { ?>
	  <p><b><?=$ukey?></b> "<?=$uvalues?>"</p>
      <?php } ?>

    <form class="form-horizontal text-info .form" method="POST" action=""
        role="form">
         <fieldset class="d-account">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Administracyjne Konta</h4>
                <label class="checkbox-inline">

                  <input name="can_login"<?=($this->userdetails['can_login']=='y')?' checked="checked"':'';?> value="<?=$this->userdetails['can_login']?>" id="d-login-check" type="checkbox" data-toggle="toggle" data-on="Tak"
                  data-off="Nie" data-onstyle="success" data-offstyle="danger">
                  <i class="fa fa-lg fa-lock"></i>
                  <strong>&nbsp;Logowanie do konta</strong>
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" data-toggle="toggle" data-on="Konto Aktywne" data-off="Konto Nieaktywne"
                  data-onstyle="success" data-offstyle="danger"<?=($this->userdetails['can_login']=='y')?' checked="checked"':'';?>>
                  <i class="fa fa-lg fa-sitemap"></i>
                  <strong>&nbsp;Konto Aktywne</strong>
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <select name="account_role" class="form-control combobox">
                    <option value="admin" disabled="disabled">Administrator</option>
                    <option value="editor" >Kierownik</option>
                    <option>Magazynier</option>
                    <option selected="selected">Pracownik</option>
                    <option>Odbiorca</option>
                    <option>Dostawca</option>
                  </select>
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-group"></i>&nbsp;Rodzaj konta</span>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="d-login">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Logowania</h4>
                <div class="input-group">
                  <input name="account_login" value="<?=$this->userdetails['account_login']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-user"></i>&nbsp;Login</span>
                </div>
              </div>
            </div>
            <div class="form-group" id="u-pass">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="account_pass" value="" type="password" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-lock"></i>&nbsp;Hasło</span>
                  <span class="input-group-btn">
                    <a class="btn btn-warning" type="submit" id="show-pass" data-toggle="button"><i class="fa fa-lg fa-eye icon-pass"></i>&nbsp;Pokaż</a>
                  </span>
                </div>
              </div>
            </div>
          </fieldset>
		  <fieldset class="d-action">
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-block btn-primary">
                  <i class="fa fa-fw fa-lg fa-save"></i>&nbsp;Zapisz</button>
              </div>
            </div>
          </fieldset>
	  </form>
	  <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć do listy</a>
    <?php } else { ?>
    <div class="well">
      <h1>Oj! coś tu nie tak</h1>
      <p>Nic nie znaleziono</p>
      <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć</a>
    </div>
    <?php } ?>
  </div>
</div>

