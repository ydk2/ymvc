<div class="row">
  <div class="col-sm-12">
    <?php if(!empty($this->userdetails)){ ?>
      <?php foreach($this->userdetails as $ukey=>$uvalues) { ?>
	 <!-- <p><b><?=$ukey?></b> "<?=$uvalues?>"</p> -->
      <?php } ?>

    <form class="form-horizontal text-info .form" method="POST" action="?accounts-users=accounts-save"
        role="form">
         <fieldset class="d-account">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Administracyjne Konta</h4>
                <label class="checkbox-inline">

                  <input name="can_login" value="yes" id="d-login-check" type="checkbox" data-toggle="toggle" data-on="Tak"
                  data-off="Nie" data-onstyle="success" data-offstyle="danger"<?=($this->userdetails['can_login']=='yes')?' checked="checked"':'';?>>
                  <i class="fa fa-lg fa-lock"></i>
                  <strong>&nbsp;Logowanie do konta</strong>
                </label>
                <label class="checkbox-inline">
                  <input name="active" value="yes" type="checkbox" data-toggle="toggle" data-on="Konto Aktywne" data-off="Konto Nieaktywne"
                  data-onstyle="success" data-offstyle="danger"<?=($this->userdetails['active']=='yes')?' checked="checked"':'';?>>
                  <i class="fa fa-lg fa-sitemap"></i>
                  <strong>&nbsp;Konto Aktywne</strong>
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                <input name="account_role" list="account_role" value="<?=$this->userdetails['account_role']?>" type="password" class="form-control">
                  <datalist id="account_role">
                  <select name="account_role">
                    <option value="admin">Administrator</option>
                    <option value="editor" >Kierownik</option>
                    <option>Magazynier</option>
                    <option selected="selected">Pracownik</option>
                    <option>Odbiorca</option>
                    <option>Dostawca</option>
                  </select>
                  </datalist>
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
          <fieldset class="d-contact">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Kontaktowe</h4>
                <div class="input-group">
                  <input name="account_name" value="<?=$this->userdetails['account_name']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-user"></i>&nbsp;Nazwa</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="account_email" value="<?=$this->userdetails['account_email']?>" type="email" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-at fa-lg"></i>&nbsp;E-mail</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="tel[]" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-phone-square"></i>&nbsp;Telefon</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="fax[]" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg -square fa-fax"></i>&nbsp;Fax</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="www[]" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-compass"></i>&nbsp;Strona WWW</span>
                </div>
              </div>
            </div>
            <div class="form-group" id="d-add-new">
              <div class="col-sm-12">
                <div class="input-group">
                  <input class="form-control" list="d-new-list" placeholder="Wpisz nazwę pola">
                  <datalist class="" id="d-new-list">
                    <option selected="selected" data-type="" value="Wybierz">Wybierz</option>
                    <option data-type="mail" value="E-mail">E-mail</option>
                    <option data-type="tel" value="Telefon">Telefon</option>
                    <option data-type="fax" value="Fax">Fax</option>
                    <option data-type="www" value="Strona WWW">Strona WWW</option>
                    <option data-type="bank" value="Konto Bankowe">Konto Bankowe</option>
                    <option data-type="other" value="Inne">Inne</option>
                  </datalist>
                  <span class="input-group-addon">
                    <i class="fa fa-lg -square fa-bullhorn"></i>&nbsp;Nowe pole</span>
                  <span class="input-group-btn">
                    <a class="btn btn-success"><i class="fa fa-lg fa-plus-circle"></i>&nbsp;Dodaj</a>
                  </span>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="d-address-main">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Adresowe</h4>
                <h5>Adres siedziby</h5>
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Miasto</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Ulica</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer lokalu</span>
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer budynku</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kod</span>
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Poczta</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kraj</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <label class="checkbox-inline" contenteditable="true">
                  <input type="checkbox" data-toggle="toggle" data-on="Tak" data-off="Nie"
                  data-onstyle="success" data-offstyle="danger" id="d-address-send">
                  <i class="fa fa-lg fa-send"></i>
                  <strong>&nbsp;Inny Adres Korespondencyjny</strong>
                </label>
              </div>
            </div>
          </fieldset>
          <fieldset class="d-address-send">
            <div class="form-group">
              <div class="col-sm-12">
                <h5>Adres Korespondencyjny</h5>
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-user"></i>&nbsp;Nazwa</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Miasto</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Ulica</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer lokalu</span>
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer budynku</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kod</span>
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Poczta</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kraj</span>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="d-money">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Finansowe</h4>
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-bank fa-lg"></i>&nbsp;Numer konta</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-institution fa-lg"></i>&nbsp;NIP</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-institution fa-lg"></i>&nbsp;REGON</span>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="d-adnotes">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Adnotacje</h4>
                <textarea rows="5" class="form-control" placeholder="Adnotacje"></textarea>
              </div>
            </div>
          </fieldset>
		  <fieldset class="d-action">
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-block btn-primary">
				<input name="idx" value="<?=$this->userdetails['idx']?>" type="hidden">
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

