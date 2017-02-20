<?php

class header extends render {
	//    public $model;

	public function construct($model, $view) {
		parent::__construct($model, $view);
		$this -> alert = '';
		$this -> alert_header = '';
		$this -> alert_string = '';
		//$this -> init();
	}

	public function init() {
		$this -> name = router::post('name');
		$this -> email = router::post('email');
		$this -> pass = router::post('password');
		$this -> pass2 = router::post('password2');
		if (Router::session('id') > 0) {
			if (router::post('from') == 'admin/login') {
				$_GET['admin,form'] = 'admin,success';
				$this -> alert_header = 'Success!';
				$this -> alert_string = 'You are logged in';
				$this -> alert_mode = "alert-success";
			} else {
				if(router::get('admin,form')=='admin,edit'){
					$this -> alert_header = 'Welcome!';
					$this -> alert_string = 'Manage your account';
					$this -> alert_mode = "alert-success";
				} else {
				$_GET['admin,form'] = 'admin,alert';
				$this -> alert_header = 'Info!';
				$this -> alert_string = 'Users is already logged in';
				$this -> alert_mode = "alert-info";
				}
			}
		if(router::get('action')=='logout' && router::get('admin,form')=='admin,edit'){
			router::sessionstop(router::session('id'));
			$_GET['admin,form'] = 'admin,login';
		}
		} else {
			switch (router::get('admin,form')) {
				case 'admin,login' :
					$this -> name = router::post('name');
					$this -> email = router::post('email');
					$this -> pass = router::post('password');
		if(router::get('action')=='logout'){
			$this -> alert_header = 'Bye bye!';
			$this -> alert_string = 'You are logged out';
			$this -> alert_mode = "alert-success";
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
		}
					
					//$this -> view = 'admin/login';
					break;
				case 'admin,register' :
					//$this -> view = 'admin/register';
					break;
				case 'admin,edit' :
					$_GET['admin,form'] = 'admin,login';
					$this -> alert_header = 'Hello!';
					$this -> alert_string = 'You need login';
					$this -> alert_mode = "alert-warning";
					$this -> alert = $this -> showin(SVIEW . 'admin/alert');
					
					break;
				case 'admin,check' :
					$this -> name = router::post('name');
					$this -> email = router::post('email');
					$this -> pass = router::post('password');
					$this -> pass2 = router::post('password2');
					//if(router::post('from')=='login'):
					//$this -> check = ($this -> pass === $this -> pass2) ? "Passwords equaled" : "Passwords fail";
					$this -> check_alert = ($this -> pass === $this -> pass2) ? "alert-success" : "alert-danger";

					/*** check if the users is already logged in ***/

					/*** check that both the username, password have been submitted ***/
					$this -> login();
					//$this -> view = 'admin/check';
					break;

				default :
					//$this -> view = 'admin/check';
					break;
			}

		}
	}

	public function login() {
		if (!Router::post('name') || !Router::post('password')) {
			$this -> alert_mode = "alert-warning";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= 'Please enter username and password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
		} elseif (!ctype_alnum(Router::post('name'))) {
			$this -> alert_mode = "alert-warning";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= 'Please enter a valid username <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
		}
		/*** check the password has only alpha numeric characters ***/
		elseif (!ctype_alnum(Router::post('password'))) {
			$this -> alert_mode = "alert-warning";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= 'Please enter a valid password <br>';
			$this -> alert = $this -> showin(SVIEW . 'admin/alert');
		} else {
			$login = $this -> model -> login();
			//var_dump($login);
			if ($login==0) {
				$_GET['admin,form'] = 'admin,success';
				$this -> alert_header = 'Success!';
				$this -> alert_string = 'You are logged in';
				$this -> alert_mode = "alert-success";
			} elseif ($login == 101) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = 'Users or password incorrect';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			} elseif ($login == 102) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = 'Udefinied error';
				$this -> alert_mode = "alert-danger";
				$this -> alert = $this -> showin(SVIEW . 'admin/alert');
			}
		}

	}

	public function register() {

	}

	public function edit() {

	}

}
?>