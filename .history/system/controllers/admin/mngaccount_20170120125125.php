<?php

class MngAccount extends PHPRender {
	//private $error;

	public function Init() {
		Config::$data['tmp_data']['login'] = TRUE;
		$this -> alert = '';
		$this -> alert_header = '';
		$this -> alert_string = '';
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','editor','user','any','');
		$this->current_group = Helper::Session('user_role');
		$this->AccessMode(1);
		$this->global_access = Helper::Session('user_access');

		$this->RegisterView(SYS.V.'admin:account');
		$this->RegisterView(SYS.V.'admin:login');
		$this->RegisterView(SYS.V.'admin:register');
		$this->RegisterView(SYS.V.'admin:message');
		$this->RegisterView(SYS.V.'admin:success');
		$this->RegisterView(SYS.V.'admin:check');
		$this->SetModel(SYS.M.'accountsdata');

		if(Helper::Get('admin:mngaccount') == '')
		$this->SetView(SYS.V . "admin:login");

	}

	public function Run() {
		$this -> name = Helper::post('name');
		$this -> email = Helper::post('email');
		$this -> pass = Helper::post('password');
		$this -> pass2 = Helper::post('password2');


		if (Helper::session('id') > 0) {
			$this -> alert_header = 'Hi! '.Helper::session('user_name');
			$this -> alert_string = 'You are logged in';

		/*
			if(Helper::session('error')==200){
				$this -> alert_header = 'Success! '.Helper::session('user_name');
				$this -> alert_string = 'You are logged in';
				$this -> alert_mode = "alert-success";
				$this -> section = '';
				$this->SetView(SYS.V . "admin:success");
				Helper::session_set('error',0);
			} else {
				$this -> alert_header = 'Hello! '.Helper::session('user_name');
				$this -> alert_string = 'You are already logged in';
				$this -> alert_mode = "alert-success";
				$this -> alert = '';
				//$this->SetView(SYS.V . "admin:message");
			}
			*/

			$this->SetView(SYS.V . "admin:account");
			if (Helper::get('action') == 'logout') {
				if (Helper::session_stop(Helper::session('id'))) {
					$this -> alert_header = 'Bye bye! '.Helper::session('user_name');
					$this -> alert_string = 'You are logged out';	
					$this -> alert_mode = "alert-success";
					$this->SetView(SYS.V.'admin:message'); 
				} else {
					$this->SetView(SYS.V . "admin:message");
				}
			} elseif (Helper::get('action') == 'login') {
					$this -> alert_header = 'Hi! '.Helper::session('user_name');
					$this -> alert_string = 'You are login';	
					$this -> alert_mode = "alert-success";
			}
		} else {
			switch (Helper::get('action')) {
				case 'login' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-info";
					$this->SetView(SYS.V . "admin:login");
						$this -> login();
					break;
				case 'register' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'Join to us';
					$this -> alert_mode = "alert-info";
					$this->SetView(SYS.V . "admin:register");
					if (Helper::post('from')=='register') {
						$this -> register();
					}
					break;
				case 'edit' :
					$this -> alert_header = 'Hello! '.Helper::session('user_name');
					$this -> alert_string = 'Edit your account';
					$this -> alert_mode = "alert-info";

					break;
				case 'check' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-warning";
					break;

				case 'logout' :
					$this -> alert_header = 'Ups!';
					$this -> alert_string = 'You are not login';
					$this -> alert_mode = "alert-warning";
					break;

				default :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-info";
					$this->SetView(SYS.V . "admin:login");
					$this -> login();
					break;
			}

		}

	}

	public function login() {

	if (Helper::post('from')=='login') {
		if (!Helper::post('name') || !Helper::post('password')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter username and password <br>';
			$this->SetView(SYS.V . "admin:message");
		} elseif (!ctype_alnum(Helper::post('name')) && !filter_var(Helper::post('name'), FILTER_VALIDATE_EMAIL)) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid username or email <br>';
			$this->SetView(SYS.V . "admin:message");
		}
		/*** check the password has only alpha numeric characters ***/
		elseif (!ctype_alnum(Helper::post('password'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid password <br>';
			$this->SetView(SYS.V . "admin:message");
		} else {
			$login = $this -> model -> login();
			if ($login == 0) {
				$this -> alert_header = 'Success! '.Helper::session('user_name');
				$this -> alert_string = 'You are logged in as '.Helper::session('user_role');
				$this->SetView(SYS.V . "admin:success");
			} elseif ($login == 101) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Incorrect username or password ';
				$this -> alert_mode = "alert-danger";
				$this->SetView(SYS.V . "admin:message");
			} elseif ($login == 102) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Udefinied error, please try later';
				$this -> alert_mode = "alert-danger";
				$this->SetView(SYS.V . "admin:message");
			}
		}
	}
	}

	public function register() {
		if (!Helper::post('name') || !Helper::post('email') || !Helper::post('password') || !Helper::post('password2')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please fill all fields <br>';
		} elseif (!ctype_alnum(Helper::post('name'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid username <br>';
		} elseif (filter_var(Helper::post('name'), FILTER_VALIDATE_EMAIL)) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid email <br>';
		} elseif (!ctype_alnum(Helper::post('password')) && !ctype_alnum(Helper::post('password2'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} elseif (Helper::post('password') !== Helper::post('password2')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Passwords is not equals <br>';
		} else {
			$register = $this -> model -> register();
			//var_dump($login);
			if ($register == 0) {
				$this -> alert_header = 'Welcome!';
				$this -> alert_string = ' You are registered';
				$this -> alert_mode = "alert-success";
				$this -> section = '';
				//Helper::session_set('error',210);
			} elseif ($register == 110) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Can\' register new User ';
				$this -> alert_mode = "alert-danger";
			} elseif ($register == 111) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Username or email alredy exists ';
				$this -> alert_mode = "alert-danger";
			} elseif ($register == 112) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Udefinied error, please try later ';
				$this -> alert_mode = "alert-danger";
			}
		}

	}

	public function edit() {

	}

	public function onException(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}
}
?>