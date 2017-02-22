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
                <input autocomplete="off" name="account_role" list="account_role" value="<?=$this->userdetails['account_role']?>" type="text" class="form-control">
                  <datalist id="account_role">
                  <!--<select name="account_role">-->
                    <option value="admin" label="Administrator">
                    <option value="editor" label="Kierownik">
                    <option value="user" label="Użytkownik">
                  <!--</select>-->
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
            <?php if(isset($this->userdetails['tel'])) { ?>
            <?php foreach (explode(';',$this->userdetails['tel']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="tel[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-phone-square"></i>&nbsp;Telefon<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(isset($this->userdetails['fax'])) { ?>
            <?php foreach (explode(';',$this->userdetails['fax']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="fax[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-fax"></i>&nbsp;Fax<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(isset($this->userdetails['www'])) { ?>
            <?php foreach (explode(';',$this->userdetails['www']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="www[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-compass"></i>&nbsp;WWW<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
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
                    <option data-type="finanse" value="Dane Finansowe"></option>
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
            <?php if(isset($this->userdetails['address'])) { ?>
            <?php foreach (unserialize($this->userdetails['address']) as $key => $value) { ?>
          <fieldset class="d-address d-can-delete">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Adresowe</h4>
                <h5>Adres siedziby</h5>
                <div class="input-group">
                  <input name="address[<?=$key?>][city]" value="<?=$value['city']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Miasto</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="address[<?=$key?>][street]" value="<?=$value['street']?>"  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Ulica</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="address[<?=$key?>][apartament]" value="<?=$value['apartament']?>"  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer lokalu</span>
                  <input name="address[<?=$key?>][number]" value="<?=$value['number']?>"  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer budynku</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="address[<?=$key?>][postal_code]" value="<?=$value['postal_code']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kod</span>
                  <input name="address[<?=$key?>][postal_city]" value="<?=$value['postal_city']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Poczta</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input name="address[<?=$key?>][country]" value="<?=$value['country']?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kraj</span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <div class="form-group">
              <div class="col-sm-12">
                <label class="checkbox-inline">
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
                <h4>Dane Finansowe</h4>
            <?php if(isset($this->userdetails['bank_account'])) { ?>
            <?php foreach (explode(';',$this->userdetails['bank_account']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="bank_account[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-bank"></i>&nbsp;Konto Bankowe<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(isset($this->userdetails['nip'])) { ?>
            <?php foreach (explode(';',$this->userdetails['nip']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="nip[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-institution"></i>&nbsp;NIP<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(isset($this->userdetails['regon'])) { ?>
            <?php foreach (explode(';',$this->userdetails['regon']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="regon[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-institution"></i>&nbsp;REGON<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if(isset($this->userdetails['finanse'])) { ?>
            <?php foreach (explode(';',$this->userdetails['finanse']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="finance[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-institution"></i>&nbsp;Dane Finansowe<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
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

