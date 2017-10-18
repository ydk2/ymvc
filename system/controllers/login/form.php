<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-23 00:18:41
 */
class Form extends Render {
	//private $error;

    public static function Config() {
        return array(
        'title'=>'Login Module',
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

		$this->RegisterView(SYS.V.'login'.S.'form');
		$this->SetModel(SYS.M.'accountsdata');

	}

	public function Run() {
		$this->success_link = Config::$data['modules']['default'];
		$this->login();
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

	public function login(){
	# code...
		$update = false;
		$insert =false;
		$delete = FALSE;

		$table = 'accounts';

		if($insert){

		$users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','role_id'=>1,'can_login'=>'y','active'=>'y');
		$users[1]=array('account_login'=>'user','account_name'=>'user','account_email'=>'user@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','role_id'=>5,'can_login'=>'y','active'=>'y');


		}

		// user login

		$pass_check = false;
		$user_data = null;
		if(!Helper::session('id')){
			$this->ViewData('alert',Intl::_('Podaj Nazwę Użytkownika i Hasło'));
			$this->ViewData('classes',' alert-info text-info');
		if(Helper::get('action')=='login'){
		$user = Helper::post('account_login');
		$pass = Helper::post('account_pass');
		if (!$user && !$pass) {
			$this->ViewData('alert',Intl::_('Pola nie mogą być puste'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($user) && !filter_var($user, FILTER_VALIDATE_EMAIL)) {
			$this->ViewData('alert',Intl::_('Podaj Nazwę Użytkownika'));
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($pass)) {
			$this->ViewData('alert',Intl::_('Podaj Hasło'));
			$this->ViewData('classes',' alert-danger text-danger');
		} else {

		$user_check=$this->model->Select($table,array('id','account_login','account_email','account_pass','account_can_login','account_active'),'where account_login=? or account_email=?',array($user,$user));
		//$user_check=$this->model->Select($table,array('*'),'where account_login=?',array($user));

		if($user_check){
			$active_check = $user_check[0]['account_active'];
			$can_login_check = $user_check[0]['account_can_login'];

			if($active_check=='yes' && $can_login_check=='yes'){
				$pass_get = $user_check[0]['account_pass'];
			if($pass_get==sha1($pass)){
				$pass_check = TRUE;
			} else {
				$this->ViewData('alert',Intl::_('Hasło niepasuje'));
				$this->ViewData('classes',' alert-danger text-danger');
			}
			} else {
				$this->ViewData('alert',Intl::_('Konto nieaktywne'));
				$this->ViewData('classes',' alert-danger text-danger');
			}
		} else {
			$this->ViewData('alert',Intl::_('Brak Użytkownika'));
			$this->ViewData('classes',' alert-danger text-danger');
		} // check user

		}

		}

		if($pass_check==TRUE){
			$user_data=$this->model->Select($table,array('*'),'where id=?',array($user_check[0]['id']));
			switch ($user_data[0]['account_role']) {
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
				$user = (!isset($user_data[0]['account_name']) && $user_data[0]['account_name']=='')?$user_data[0]['account_email']:$user_data[0]['account_name'];
				Helper::session_set('id', $user_data[0]['id']);
				Helper::session_set('user_name', $user);
				Helper::session_set('user_email', $user_data[0]['account_email']);
				Helper::session_set('user_created', $user_data[0]['account_ctime']);
				Helper::session_set('user_born', $user_data[0]['account_born']);
				Helper::session_set('user_role', $user_data[0]['account_role']);
				Helper::session_set('user_access', $roleid);
				Helper::session_set('token', base64_encode(microtime()));
			$this->ViewData('alert','Zalogowano');
			$this->ViewData('classes',' alert-success text-success');
			$this->ViewData('success_link',$this->success_link);
			$this->ViewData('user_name',$user_data[0]['account_name']);
			$this->SetView(SYS.V ."login".S."welcome");
		} else {
			$this->SetView(SYS.V . "login".S."form");
		}

		} else {

			$this->ViewData('alert',Intl::_('Już Zalogowano, lecz możesz się wylogować lub wrócić do systemu'));
			$this->ViewData('classes',' alert-warning text-success');
			$this->ViewData('success_link',$this->success_link);
			$this->ViewData('user_name',Helper::session('user_name'));
			$this->SetView(SYS.V ."login".S."welcome");

		if(Helper::get('action')=='logout'){
			$this->SetView(SYS.V . "login".S."logout");
			$this->ViewData('alert',Intl::_('Wylogować?'));
			$this->ViewData('success_link',$this->success_link);
			$this->ViewData('classes',' alert-warning text-warning');
			$this->ViewData('user_name',Helper::session('user_name'));
			$this->ViewData('token',Helper::session('token'));
		}
		if(Helper::get('action')=='bye' && Helper::get('token')==Helper::session('token')){
			if(Helper::Session_Stop(Helper::session('id'))){
				$this->SetView(SYS.V . "login".S."bye");
				$this->ViewData('alert',Intl::_('Wylogowano'));
				$this->ViewData('classes',' alert-success text-success');
				Helper::session_unset('token');
			} else {
				$this->SetView(SYS.V . "login".S."logout");
				$this->ViewData('alert','Nie można wylogować');
				$this->ViewData('success_link',$this->success_link);
				$this->ViewData('classes',' alert-warning text-warning');
				$this->ViewData('user_name',Helper::session('user_name'));
			}
		}

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