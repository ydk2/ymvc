<div class="row">
<div class="col-sm-12">
  <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć do listy</a>
</div>
  <div class="col-sm-12">
    <?php if(!empty($this->userdetails)){ ?>
      <?php foreach($this->userdetails as $ukey=>$uvalues) { ?>
	 <!-- <p><b><?=$ukey?></b> "<?=$uvalues?>"</p> -->
      <?php } ?>

    <form class="form-horizontal text-info d-form" method="POST" action="?accounts-user=accounts-check"
        role="form">
         <fieldset class="d-account">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Dane Administracyjne Konta</h4>
                <label class="checkbox-inline">
                  <input name="account_can_login" value="yes" id="d-login-check" type="checkbox" data-toggle="toggle" data-on="Tak"
                  data-off="Nie" data-onstyle="success" data-offstyle="danger"<?=($this->userdetails['account_can_login']=='yes')?' checked="checked"':'';?>>
                  <i class="fa fa-lg fa-lock"></i>
                  <strong>&nbsp;Logowanie do konta</strong>
                </label>
                <label class="checkbox-inline">
                  <input name="account_active" value="yes" type="checkbox" data-toggle="toggle" data-on="Konto Aktywne" data-off="Konto Nieaktywne"
                  data-onstyle="success" data-offstyle="danger"<?=($this->userdetails['account_active']=='yes')?' checked="checked"':'';?>>
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
                  <input name="account_login" value="<?=(isset($this->userdetails['account_login']))?$this->userdetails['account_login']:''?>" type="text" class="form-control">
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
                <div class="input-group date" id="none" data-date-format="dd-mm-yyyy">
                  <input name="account_born" value="<?=$this->userdetails['account_born']?>"
                   type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-th fa-lg"></i>&nbsp;Data Urodzin</span>
                </div>
              </div>
            </div>
            <?php if(isset($this->userdetails['mail'])) { ?>
            <?php foreach (explode(';',$this->userdetails['mail']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="tel[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-at"></i>&nbsp;Email<?=($key>0)?' '.$key:'';?></span>
                    <span class="input-group-btn">
                    <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
                  </span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
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
            <?php if(isset($this->userdetails['other'])) { ?>
            <?php foreach (explode(';',$this->userdetails['other']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="other[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-lg fa-star"></i>&nbsp;Inne<?=($key>0)?' '.$key:'';?></span>
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
                    <option data-type="regon" value="REGON">REGON</option>
                    <option data-type="nip" value="NIP">NIP</option>
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
          <?php $next = 0;?>
            <?php if(isset($this->userdetails['address'])) { ?>
            <?php foreach (unserialize($this->userdetails['address']) as $key => $value) { $next=$key+1;?>
          <fieldset class="d-address d-can-del">
              <h4>Dane Adresowe <?=($key>0)?' '.$key:'';?></h4>
            <div class="form-group">
              <div class="col-sm-12">
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
            <a class="btn btn-danger d-delete">
                      <i class="fa fa-lg fa-minus-circle"></i>&nbsp;Usuń</a>
            </fieldset>
            <?php } ?>
            <?php } ?>
            <fieldset class="d-address-toggle">
              <div class="col-sm-12">
                <label class="checkbox-inline">
                  <input type="checkbox" data-toggle="toggle" data-on="Tak" data-off="Nie"
                  data-onstyle="success" data-offstyle="danger" id="d-address-send">
                  <i class="fa fa-lg fa-send"></i>
                  <strong>&nbsp;Dodaj Nowy Adres</strong>
                </label>
              </div>
            </fieldset>
          <fieldset class="d-address-send d-can-delete">
              <h4>Dane Adresowe  <?=($next>0)?' '.$next:'';?></h4>
            <div class="form-group">
              <div class="col-sm-12">
                <h5>Adres siedziby</h5>
                <div class="input-group">
                  <input disabled="disabled" name="address[<?=$next?>][city]" value="" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Miasto</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input disabled="disabled" name="address[<?=$next?>][street]" value=""  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Ulica</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input disabled="disabled" name="address[<?=$next?>][number]" value=""  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer budynku</span>
                  <input disabled="disabled" name="address[<?=$next?>][apartament]" value=""  type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Numer lokalu</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input disabled="disabled" name="address[<?=$next?>][postal_code]" value="" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Kod</span>
                  <input disabled="disabled" name="address[<?=$next?>][postal_city]" value="" type="text" class="form-control">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope fa-lg"></i>&nbsp;Poczta</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group">
                  <input disabled="disabled" name="address[<?=$next?>][country]" value="" type="text" class="form-control">
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
            <?php if(isset($this->userdetails['bank'])) { ?>
            <?php foreach (explode(';',$this->userdetails['bank']) as $key => $value) { ?>
            <div class="form-group d-can-del">
              <div class="col-sm-12">
                <div class="input-group">
                  <input  name="bank[<?=$key?>]" value="<?=$value?>" type="text" class="form-control">
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
          </fieldset>
          <fieldset class="d-adnotes">
            <div class="form-group">
              <div class="col-sm-12">
                <h4>Adnotacje</h4>
                <textarea id="summernote" name="account_adnotation" rows="5" class="form-control" placeholder="Adnotacje"><?=(isset($this->userdetails['account_adnotation']))?$this->userdetails['account_adnotation']:'';?></textarea>
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
    <?php } else { ?>
    <div class="well">
      <h1>Oj! coś tu nie tak</h1>
      <p>Nic nie znaleziono</p>
      <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć</a>
    </div>
    <?php } ?>
  </div>
</div>
    <script>
    $('#d-account-edit').prop('checked',false);
    var options =  {
  height: 300,                
  placeholder: 'Start typing your text...',
  toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert',['ltr','rtl']],
      ['insert', ['link','picture', 'video', 'hr']],
      ['view', ['fullscreen', 'codeview']]
  ]
};
    $(document).ready(function() {
        $('#none').datepicker({
          format: "dd-mm-yyyy",
          language: "pl"
        });
        $('#summernote').summernote({
            addclass: {
                debug: false,
                classTags: [{title:"clean",value:""},{title:"Button",value:"btn btn-success"},"empty","jumbotron", "lead","img-rounded","img-circle", "img-responsive","btn", "btn btn-success","btn btn-danger","text-muted", "text-primary", "text-warning", "text-danger", "text-success", "table-bordered", "table-responsive", "alert", "alert alert-success", "alert alert-info", "alert alert-warning", "alert alert-danger", "pull-left","pull-right"]
            },
            popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['custom', ['imageAttributes', 'imageShape']],
                ['remove', ['removeMedia']]
            ]
            },
            lang: 'pl-PL',
            codemirror: { // codemirror options
                theme: 'monokai',
                lineNumbers: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                mode: {name: "text/html", globalVars: true}
            },
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style', 'addclass', 'clear']],
                ['fontstyle', ['bold', 'italic', 'ul', 'ol', 'link', 'paragraph']],
                ['fontstyleextra', ['strikethrough', 'underline', 'hr', 'color', 'superscript', 'subscript']],
                ['insert',['ltr','rtl']],
                ['extra', ['link','picture','video', 'table', 'height']],
                ['misc', ['undo', 'redo']],
                ['view', ['codeview']]
            ]
        });
    });
  </script>

