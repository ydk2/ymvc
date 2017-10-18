<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-23 00:18:41
 */
class signin extends Render {
	//private $error;

    public static function Config() {
        return array(
        'title'=>'Register Module',
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

		$this->RegisterView(SYS.V.'register'.S.'form');
		$this->SetModel(SYS.M.'accountsdata');

	}

	public function Run() {
		$this->success_link = Config::$data['modules']['default'];
		$this->register();
	}
	public function itemattr($attrs){
		$retval = '';
		if(!empty($attrs)){
		foreach ($attrs as $key => $value) {
			$retval.= " $key=\"$value\"";
		}
		}
		return $retval;
	}
	function itemlist($data) {
		// <item id="0" name="1">
		$tree = '';
		$i = 1;
		foreach ($data as $item) {
				$tree .= '<item'.$this->itemattr($item).'>' . PHP_EOL;
				$tree .= '</item>' . PHP_EOL;

			$i++;
		}
		$tree .= "";
		return $tree;
	}

	public function register(){
	# code...
		$update = false;
		$insert =false;
		$delete = FALSE;

		$table = 'accounts';

		$users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','account_role_id'=>1,'account_can_login'=>'yes','account_active'=>'yes');
		$users[1]=array('account_login'=>'ccc','account_name'=>'Cep','account_email'=>'cep@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','account_role_id'=>10,'account_can_login'=>'yes','account_active'=>'yes');


		if(!Helper::session('id')){

		if(Config::$data['default']['allowregister']){

			$this->ViewData('alert',Intl::_('Podaj Nazwę Użytkownika i Hasło'));
			$this->ViewData('classes',' alert-info text-info');

		if(Helper::get('action')=='sign'){
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
				$this->SetView(SYS.V . "register".S."signin");
    		}
		} else {
			$this->ViewData('alert',Intl::_('Takie konto już istnieje'));
			$this->ViewData('classes',' alert-danger text-danger');
			$this->SetView(SYS.V . "register".S."signin");
		} // check user
		}
		}
		} else {
			$this->ViewData('alert',Intl::_('Rejestracja wyłączona'));
			$this->ViewData('classes',' alert-danger text-danger');
			$this->SetView(SYS.V."register".S."no");

		}
		} else {

			$this->ViewData('alert',Intl::_('Już Zalogowano, lecz możesz się wylogować lub wrócić do systemu'));
			$this->ViewData('classes',' alert-warning text-success');
			$this->ViewData('success_link',$this->success_link);
			$this->ViewData('user_name',Helper::session('user_name'));
			$this->SetView(SYS.V ."login".S."welcome");

		}

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