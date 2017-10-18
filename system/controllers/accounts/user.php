<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-23 00:18:41
 */
class User extends Render {
	//private $error;

    public static function Config() {
        return array(
        'title'=>'account edit Module',
		'access_groups'=>array()
        );
    }
	public function Init() {
		Config::$data['tmp_data']['login'] = TRUE;
		$this -> alert = '';
		$this -> alert_header = '';
		$this -> alert_string = '';
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array(null);
		$this->current_group = null;
		$this->AccessMode(0);
		$this->global_access = null;

		$this->RegisterView(SYS.V.'user'.S.'edit');
		$this->SetModel(SYS.M.'accountsdata');

	}

	public function Run() {
		$this->success_link = Config::$data['modules']['default'];
       // if(helper::get('user'))
		$this->edit();
       // else
       // $this->SetView(SYS.V.'user'.S.'no');

	}

	public function edit(){
	# code...
		$update = false;
		$insert =false;
		$delete = FALSE;

		$table = 'accounts';

		$users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','account_role_id'=>1,'account_can_login'=>'yes','account_active'=>'yes');
		$users[1]=array('account_login'=>'ccc','account_name'=>'Cep','account_email'=>'cep@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','account_role_id'=>10,'account_can_login'=>'yes','account_active'=>'yes');


			$this->ViewData('alert',Intl::_('Podaj Nazwę Użytkownika i Hasło'));
			$this->ViewData('classes',' alert-info text-info');

		if(Helper::get('action')=='edit'){

		$user = Helper::post('account_login');
		$mail = Helper::post('account_email');
		$pass = Helper::post('account_pass');
		$pass1 = Helper::post('account_pass1');
		if (!$user && !$mail && !$pass && !$pass1) {
			$this->ViewData('alert',Intl::_('Pola nie mogą być puste'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($user)) {
			$this->ViewData('alert',Intl::_('Podaj Nazwę Użytkownika'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$this->ViewData('alert',Intl::_('Podaj Poprawny Email'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($pass) || !ctype_alnum($pass1)) {
			$this->ViewData('alert',Intl::_('Podaj Hasło'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif ($pass != $pass1) {
			$this->ViewData('alert',Intl::_('Hasła niepasują'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (strlen($pass) < Config::$data['default']['passlen']) {
			$this->ViewData('alert',Intl::_('Hasło jest za krótkie'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (strlen($user) < Config::$data['default']['loginlen']) {
			$this->ViewData('alert',Intl::_('Login jest za krótki'));
			$this->ViewData('classes',' alert-danger text-danger');
		} else {

		$user_check=$this->model->Select($table,array('id','account_login','account_email'),'where account_login=? or account_email=?',array($user,$mail));

		if(!$user_check){

		$chk = 0;
		$user_data = array();

		Helper::session_set('token-new', base64_encode(microtime()));
    	$this->model->Begin(Helper::Session('token-new'));

			$user_data['account_name']=$user;
			$user_data['account_login']=$user;
			$user_data['account_email']=$mail;
			$user_data['account_pass']=sha1($pass);
			$user_data['account_ctime']=time();
			$user_data['account_mtime']=time();
			$user_data['account_born']=0;
			$user_data['account_role']='user';
			$user_data['account_role_id']=10;
			$user_data['account_can_login']='yes';
			$user_data['account_active']='yes';

        return true;
		$chk=$this->model->insert($table,$user_data);
		//$ins = $this->model->db->prepare('INSERT INTO accounts (account_name,account_login,account_email,account_pass,account_ctime,account_mtime,account_born,account_role,account_role_id,account_can_login,account_active) VALUES (?,?,?,?,?,?,?,?,?,?,?);');
		//$ins->execute(array_values($user_data));
		//$chk = $ins->rowCount();
	    $this->model->Commit(Helper::Session('token-new'));
		//var_dump($chk);
		    if($chk){
    		    $this->model->Release(Helper::Session('token-new'));
				Helper::session_unset('token-new');

				$this->ViewData('alert',Intl::_('Konto jest wolne'));
				$this->ViewData('classes',' alert-success text-success');
				$this->SetView(SYS.V . "register".S."welcome");
				$this->ViewData('success_link',"?login".S."form");
	    	} else {
    	    	$this->model->Rollback(Helper::Session('token-new'));

				$this->ViewData('alert',Intl::_('Nie można utworzyć konta'));
				$this->ViewData('classes',' alert-danger text-danger');
				//$this->SetView(SYS.V . "register".S."signin");
    		}
		} else {
			$this->ViewData('alert',Intl::_('Takie konto już istnieje'));
			$this->ViewData('classes',' alert-danger text-danger');
			//$this->SetView(SYS.V.'user'.S.'edit');
            		$chk = 0;
		$user_data = array();

		Helper::session_set('token-new', base64_encode(microtime()));
    	$this->model->Begin(Helper::Session('token-new'));

			$user_data['account_name']=$user;
			$user_data['account_login']=$user;
			$user_data['account_email']=$mail;
			$user_data['account_pass']=sha1($pass);
			//$user_data['account_ctime']=time();
			$user_data['account_mtime']=time();
			$user_data['account_born']=0;
			$user_data['account_role']='user';
			$user_data['account_role_id']=10;
			$user_data['account_can_login']='yes';
			$user_data['account_active']='yes';

        //return true;
		$chk=$this->model->update($table,$user_data,'where id=?',array(helper::post('id')));
		//$ins = $this->model->db->prepare('INSERT INTO accounts (account_name,account_login,account_email,account_pass,account_ctime,account_mtime,account_born,account_role,account_role_id,account_can_login,account_active) VALUES (?,?,?,?,?,?,?,?,?,?,?);');
		//$ins->execute(array_values($user_data));
		//$chk = $ins->rowCount();
	    $this->model->Commit(Helper::Session('token-new'));
		//var_dump($chk);
		    if($chk){
    		    $this->model->Release(Helper::Session('token-new'));
				Helper::session_unset('token-new');

				$this->ViewData('alert',Intl::_('Konto jest wolne'));
				$this->ViewData('classes',' alert-success text-success');
				$this->SetView(SYS.V . "register".S."welcome");
				$this->ViewData('success_link',"?login".S."form");
	    	} else {
    	    	$this->model->Rollback(Helper::Session('token-new'));

				$this->ViewData('alert',Intl::_('Nie można utworzyć konta'));
				$this->ViewData('classes',' alert-danger text-danger');
				//$this->SetView(SYS.V . "register".S."signin");
    		}
		} // check user

		}
		} else {

		$user_check=$this->model->Select($table,array('*'),'where id=?',array(helper::get('user')));
        	switch ($user_check[0]['account_role']) {
				case 'admin':
					$roleid = 1;
					break;
				case 'system':
					$roleid = 2;
					break;
				case 'moderator':
					$roleid = 3;
					break;
				case 'editor':
					$roleid = 4;
					break;
				case 'user':
					$roleid = 5;
					break;

				default:
					$roleid = 10;
					break;
			}
			$this->ViewData('account_name',$user_check[0]['account_name']);
			$this->ViewData('account_login',$user_check[0]['account_login']);
			$this->ViewData('account_email',$user_check[0]['account_email']);
			$this->ViewData('account_pass','');
			$this->ViewData('account_ctime',$user_check[0]['account_ctime']);
			$this->ViewData('account_mtime',time());
			$this->ViewData('account_born',$user_check[0]['account_born']);
			$this->ViewData('account_role',$user_check[0]['account_role']);
			$this->ViewData('account_role_id',$roleid);
			$this->ViewData('account_can_login',$user_check[0]['account_can_login']);
			$this->ViewData('account_active',$user_check[0]['account_active']);
        //var_dump($user_check);
        }

$this->SetView(SYS.V.'user'.S.'edit');

	}

	public function Exception(){
		//echo "";
		if($this->error > 0) return $this->showwarning();

	}
	public function showwarning()
	{
		$this->model->header = Intl::_('Uwaga!!!');
		$this->model->text = Intl::_('Błąd').' '.$this->error;
		return $this->subView(SYS.V."elements-msg");
	}
}
?>
<?php
function unew(){
	/**
    $table = 'accounts';
    $mailtable = 'accounts_mail';
    $addresstable = 'accounts_address';
    $wwwtable = 'accounts_www';
    $teltable = 'accounts_tel';
    $banktable = 'accounts_bank';
    $finansetable = 'accounts_finanse';
    $niptable = 'accounts_nip';
    $regontable = 'accounts_regon';
    $faxtable = 'accounts_fax';
    $othertable = 'accounts_other';
    $finanse = array(
    "finanse varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $other = array(
    "other varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $fax = array(
    "fax varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $regon = array(
    "regon integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $nip = array(
    "nip integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $bank = array(
    "bank integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $www = array(
    "www varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $mail = array(
    "mail varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $tel = array(
    "tel varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $address = array(
    "city varchar(99) not null",
    "street varchar(99) not null",
    "apartament varchar(9) not null",
    "number varchar(9) not null",
    "postal_code varchar(9) not null",
    "postal_city varchar(99) not null",
    "country varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $entries = array(
    "account_name varchar(99) not null",
    "account_login varchar(99) not null unique",
    "account_email varchar(99) not null unique",
    "account_pass varchar(199) not null",
    "account_role varchar(32) not null default 'user'",
    "account_born varchar(32) not null",
    "account_can_login varchar(4) default 'yes'",
    "account_active varchar(4) default 'yes'",
    "account_adnotation TEXT ",
    "account_role_id integer not null default 10",
    "account_ctime integer not null",
    "account_mtime integer not null"
    );
    $this->model->dropTable($table);
    $this->model->dropTable($mailtable);
    $this->model->dropTable($teltable);
    $this->model->dropTable($faxtable);
    $this->model->dropTable($wwwtable);
    $this->model->dropTable($othertable);
    $this->model->dropTable($banktable);
    $this->model->dropTable($finansetable);
    $this->model->dropTable($niptable);
    $this->model->dropTable($regontable);
    $this->model->dropTable($addresstable);

    $this->model->createTable($table,$entries);
    $this->model->createTable($mailtable,$mail);
    $this->model->createTable($teltable,$tel);
    $this->model->createTable($faxtable,$fax);
    $this->model->createTable($wwwtable,$www);
    $this->model->createTable($othertable,$other);
    $this->model->createTable($banktable,$bank);
    $this->model->createTable($finansetable,$finanse);
    $this->model->createTable($niptable,$nip);
    $this->model->createTable($regontable,$regon);
    $this->model->createTable($addresstable,$address);
    //var_dump($this->usersList);
    //$this->ushownew();
	**/
}
?>