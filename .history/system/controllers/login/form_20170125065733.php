<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-18 22:16:35
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-18 22:17:02
 */
class Form extends PHPRender {
	//private $error;

	public function Init() {
		Config::$data['tmp_data']['login'] = TRUE;
		$this -> alert = '';
		$this -> alert_header = '';
		$this -> alert_string = '';
		//$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','editor','user','any','');
		$this->current_group = Helper::Session('user_role');
		$this->AccessMode(1);
		$this->global_access = Helper::Session('user_access');

		$this->RegisterView(SYS.V.'login'.S.'form');
		$this->SetModel(SYS.M.'accountsdata');

//		if(Helper::Get('login'.S.'form') == '')
//		$this->SetView(SYS.V . "login".S."form");

	}

	public function Run() {
		$this->items = array(
			array('id'=>'a','pos'=>1,'name'=>'a','type'=>'text','value'=>'','label'=>'Name','error'=>'text-success'),
			array('id'=>'b','pos'=>2,'name'=>'b','type'=>'password','value'=>'','label'=>'Pass','error'=>'text-danger'),
			array('id'=>'ec','pos'=>5,'name'=>'e','type'=>'submit','value'=>'Login','class'=>'btn btn-block btn-warning'),
		);

		//$this->formattr = array('id'=>'form','class'=>'form-horizontal text-info form','method'=>'post','action'=>'#');
		//$this->NewData($this->itemattr($this->formattr),$this->itemlist($this -> items));
		//$this->setparameter("","title","Login Form");
		$this->newlogin();
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

	public function newlogin(){
	# code...
		$update = false;
		$insert = false;
		$delete = FALSE;

		$gprx='login';
		$table = 'loginusers';

		$users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','role_id'=>1,'can_login'=>'y','active'=>'y');
		$users[1]=array('account_login'=>'user','account_name'=>'user','account_email'=>'user@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','role_id'=>5,'can_login'=>'y','active'=>'y');

    	$rout=$this->model->reverseNoId($users,$gprx);
    	//var_dump($rout);

		//if(Helper::Get('login'.S.'form') == '')
		//$this->SetView(SYS.V . "login".S."form");
		// user login

		$pass_check = false;
		$user_data = null;
		if(!Helper::session('id')){

			$this->ViewData('alert','Podaj Nazwę Użytkownika i Hasło');
			$this->ViewData('classes',' alert-info text-info');
		if(Helper::get('action')=='login'){
		$user = Helper::post('account_login');
		$pass = Helper::post('account_pass');
		if (!$user || !$pass) {
			$this->ViewData('alert','Pola nie mogą być puste');
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($user) && !filter_var($user, FILTER_VALIDATE_EMAIL)) {
			$this->ViewData('alert','Podaj Nazwę Użytkownika');
			$this->ViewData('classes',' alert-danger text-danger');
		}
		elseif (!ctype_alnum($pass)) {
			$this->ViewData('alert','Podaj Hasło');
			$this->ViewData('classes',' alert-danger text-danger');
		} else {


		$user_check = $this->model->get_key_value($table,'account_login',$user,$gprx);
		if($user_check){
			$active_check = $this->model->get_idx_key($table,'active',$user_check[0]['idx'],$gprx);
			$active_check = $active_check[0]['value'];
			$can_login_check = $this->model->get_idx_key($table,'can_login',$user_check[0]['idx'],$gprx);
			$can_login_check = $can_login_check[0]['value'];

			if($active_check=='y' && $can_login_check=='y'){
			$pass_check = $this->model->get_idx_key($table,'account_pass',$user_check[0]['idx'],$gprx);
			$pass_check = $pass_check[0]['value'];
			if($pass_check==sha1($pass)){
				$pass_check = TRUE;
			}
			}
		} else {
			$this->ViewData('alert','Brak Użytkownika');
			$this->ViewData('classes',' alert-danger text-danger');
		} // check user

		}

		}
		if($pass_check==TRUE){
			$enteries = $this->model->get_idx_enteries($table,$user_check[0]['idx'],$gprx);
			$user_data=$this->model->searchByNameValue($enteries,'account_login',$user,$gprx);
				Helper::session_set('id', key($user_data)+1);
				Helper::session_set('user_name', $user_data[key($user_data)]['account_name']);
				Helper::session_set('user_email', $user_data[key($user_data)]['account_email']);
				Helper::session_set('user_role', $user_data[key($user_data)]['account_role']);
				Helper::session_set('user_access', $user_data[key($user_data)]['role_id']);
			$this->SetView(SYS.V ."login".S."welcome");
			//var_dump($user_data);
		} else {
			$this->SetView(SYS.V . "login".S."form");
		}

		} else {

		if(Helper::get('action')=='logout'){
			$this->SetView(SYS.V . "login".S."logout");
		}
		if(Helper::get('action')=='bye'){
			if(Helper::Session_Stop(Helper::session('id'))){
				$this->SetView(SYS.V . "login".S."bye");
			} else {
				$this->SetView(SYS.V . "login".S."logout");
			}
		}

		}

		//$array = $this->model->get_entries($table,$gprx);
		//var_dump($array);
		// end user login
		if($insert){
    		//var_dump($this->model->createTable($table,$gprx));
		foreach ($rout as $items) {
			$this->model->add_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
		if($update){
		foreach ($rout as $items) {
			$this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
	}
	public function login() {

	if (Helper::post('from')=='login') {
		if (!Helper::post('name') || !Helper::post('password')) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter username and password <br>';
			$this->SetView(SYS.V . "admin".S."message");
		} elseif (!ctype_alnum(Helper::post('name')) && !filter_var(Helper::post('name'), FILTER_VALIDATE_EMAIL)) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid username or email <br>';
			$this->SetView(SYS.V . "admin".S."message");
		}
		/*** check the password has only alpha numeric characters ***/
		elseif (!ctype_alnum(Helper::post('password'))) {
			$this -> alert_mode = "alert-danger";
			$this -> alert_header = 'Error!!!';
			$this -> alert_string .= ' Please enter a valid password <br>';
			$this->SetView(SYS.V . "admin".S."message");
		} else {
			$login = $this -> model -> login();
			if ($login == 0) {
				$this -> alert_header = 'Success! '.Helper::session('user_name');
				$this -> alert_string = 'You are logged in'.Helper::session('user_access');
				$this->SetView(SYS.V . "admin".S."success");
			} elseif ($login == 101) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Incorrect username or password ';
				$this -> alert_mode = "alert-danger";
				$this->SetView(SYS.V . "admin".S."message");
			} elseif ($login == 102) {
				$this -> alert_header = 'Error!';
				$this -> alert_string = ' Udefinied error, please try later';
				$this -> alert_mode = "alert-danger";
				$this->SetView(SYS.V . "admin".S."message");
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