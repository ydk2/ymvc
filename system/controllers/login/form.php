<?php

class Form extends XSLRender {
	//private $error;

	public function onInit() {
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

		$this->RegisterView(SYS.V.'elements:form');
		$this->SetModel(SYS.M.'accountsdata');

		if(Helper::Get('admin:account') == '')
		$this->SetView(SYS.V . "elements:form");

	}

	public function OnRun() {
		$this->items = array(
			array('id'=>'a','pos'=>1,'name'=>'a','type'=>'text','value'=>''),
			array('id'=>'b','pos'=>2,'name'=>'b','type'=>'text','value'=>''),
			array('id'=>'c','pos'=>3,'name'=>'c','type'=>'text','value'=>''),
			array('id'=>'d','pos'=>4,'name'=>'d','type'=>'text','value'=>''),
			array('id'=>'e','pos'=>5,'name'=>'e','type'=>'submit','value'=>'GO!'),
		);
		$this->formattr = array('id'=>'form','class'=>'form','method'=>'post','action'=>'#');
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data'.$this->itemattr($this->formattr).'>'.$this->itemlist($this -> items).'</data>', null, false);

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
				$this -> alert_string = 'You are logged in'.Helper::session('user_access');
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