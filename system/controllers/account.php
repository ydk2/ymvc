<?php
namespace System\controller;
use \System\core\Router as router;
use \System\helpers\Intl as Intl;

class Account extends \System\core\controller {
	private $error;

	public function __construct($model, $view) {
		parent::__construct($model, $view);
		$this -> alert = '';
		$this -> alert_header = '';
		$this -> alert_string = '';
		$this -> init();
	}

	public function init() {
		$this -> name = router::post('name');
		$this -> email = router::post('email');
		$this -> pass = router::post('password');
		$this -> pass2 = router::post('password2');
		if (Router::session('id') > 0) {
			if(router::session('error')==200){
				$this -> alert_header = 'Success! '.router::session('user_name');
				$this -> alert_string = 'You are logged in';
				$this -> alert_mode = "alert-success";
				$this -> alert = $this -> showin(SVIEW . 'admin/success');
				$this -> section = '';
				router::sessionset('error',0);
			} else {
				$this -> alert_header = 'Hello! '.router::session('user_name');
				$this -> alert_string = 'You are already logged in';
				$this -> alert_mode = "alert-success";
				$this -> alert = '';
				$this -> section = $this -> showin(SVIEW . 'admin/account');
			}
			if (router::get('action') == 'logout') {
				if (router::sessionstop(router::session('id'))) {
					router::sessionset('error',100);
				} else {
					router::sessionset('error',101);
				}

			}
		} else {
			switch (router::get('action')) {
				case 'login' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-info";
					$this -> alert = $this -> showin(SVIEW . 'admin/alert');
					$this -> section = $this -> showin(SVIEW . 'admin/login');
					if (router::post('from')=='login') {
						$this -> login();
					}
					break;
				case 'register' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'Join to us';
					$this -> alert_mode = "alert-info";
					$this -> alert = $this -> showin(SVIEW . 'admin/join');
					$this -> section = $this -> showin(SVIEW . 'admin/register');
					if (router::post('from')=='register') {
						$this -> register();
					}
					break;
				case 'edit' :
					$this -> alert_header = 'Hello! '.router::session('user_name');
					$this -> alert_string = 'Edit your account';
					$this -> alert_mode = "alert-info";
					$this -> alert = $this -> showin(SVIEW . 'admin/success');
					$this -> section = $this -> showin(SVIEW . 'admin/edit');

					break;
				case 'check' :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-warning";
					$this -> alert = $this -> showin(SVIEW . 'admin/alert');
					$this -> section = $this -> showin(SVIEW . 'admin/check');
					break;

				case 'logout' :
					$this -> alert_header = 'Ups!';
					$this -> alert_string = 'You are not login';
					$this -> alert_mode = "alert-warning";
					$this -> alert = $this -> showin(SVIEW . 'admin/alert');
					$this -> section = $this -> showin(SVIEW . 'admin/login');
					if (router::session('error')==100) {
						$this -> alert_header = 'Bye bye! '.router::session('user_name');
						$this -> alert_string = 'You are logged out';
						$this -> alert_mode = "alert-success";
						$this -> alert = $this -> showin(SVIEW . 'admin/alert');
						$this -> section = $this -> showin(SVIEW . 'admin/login');
					} else {
						$this -> alert_header = 'Ups!';
						$this -> alert_string = 'Something wrong, cannot logout';
						$this -> alert_mode = "alert-danger";
						$this -> alert = '';
						$this -> section = $this -> showin(SVIEW . 'admin/message');
					}

					break;

				default :
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-warning";
					$this -> alert = $this -> showin(SVIEW . 'admin/alert');
					$this -> section = $this -> showin(SVIEW . 'admin/login');
					break;
			}

		}

	}

	public function login() {
		if (!Router::post('name') || !Router::post('password')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter username and password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/login');
		} elseif (!ctype_alnum(Router::post('name')) && !filter_var(Router::post('name'), FILTER_VALIDATE_EMAIL)) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid username or email <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/login');
		}
		/*** check the password has only alpha numeric characters ***/
		elseif (!ctype_alnum(Router::post('password'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/login');
			//$this->otherview = SVIEW . 'admin/login';
		} else {
			$login = $this -> model -> login();
			//var_dump($login);
			if ($login == 0) {
				router::sessionset('error',200);
			} elseif ($login == 101) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Incorrect username or password ';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
				$this -> section = $this -> showin(SVIEW . 'admin/login');
			} elseif ($login == 102) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Udefinied error, please try later';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
				$this -> section = $this -> showin(SVIEW . 'admin/login');
			}
		}

	}

	public function register() {
		if (!Router::post('name') || !Router::post('email') || !Router::post('password') || !Router::post('password2')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please fill all fields <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} elseif (!ctype_alnum(Router::post('name'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid username <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} elseif (filter_var(Router::post('name'), FILTER_VALIDATE_EMAIL)) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid email <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} elseif (!ctype_alnum(Router::post('password')) && !ctype_alnum(Router::post('password2'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} elseif (Router::post('password') !== Router::post('password2')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Passwords is not equals <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			$this -> section = $this -> showin(SVIEW . 'admin/register');
		} else {
			$register = $this -> model -> register();
			//var_dump($login);
			if ($register == 0) {
				$this -> alert_header = 'Welcome!';
				$this -> alert_string = ' You are registered';
				$this -> alert_mode = "alert-success";
				$this -> alert = $this -> showin(SVIEW . 'admin/join');
				$this -> section = '';
				//router::sessionset('error',210);
			} elseif ($register == 110) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Can\' register new User ';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
				$this -> section = $this -> showin(SVIEW . 'admin/register');
			} elseif ($register == 111) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Username or email alredy exists ';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
				$this -> section = $this -> showin(SVIEW . 'admin/register');
			} elseif ($register == 112) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Udefinied error, please try later ';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
				$this -> section = $this -> showin(SVIEW . 'admin/register');
			}
		}

	}

	public function edit() {

	}

}
?>