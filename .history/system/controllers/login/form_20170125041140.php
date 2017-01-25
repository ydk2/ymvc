<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-18 22:16:35
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-18 22:17:02
 */
class Form extends XSLRender {
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

		$this->RegisterView(SYS.V.'elements'.S.'form');
		$this->SetModel(SYS.M.'accountsdata');

		if(Helper::Get('admin'.S.'account') == '')
		$this->SetView(SYS.V . "elements".S."form");

	}

	public function Run() {
		$this->items = array(
			array('id'=>'a','pos'=>1,'name'=>'a','type'=>'text','value'=>'','label'=>'Name','error'=>'text-success'),
			array('id'=>'b','pos'=>2,'name'=>'b','type'=>'password','value'=>'','label'=>'Pass','error'=>'text-danger'),
			array('id'=>'ec','pos'=>5,'name'=>'e','type'=>'submit','value'=>'Login','class'=>'btn btn-block btn-warning'),
		);

		$this->formattr = array('id'=>'form','class'=>'form-horizontal text-info form','method'=>'post','action'=>'#');
		$this->NewData($this->itemattr($this->formattr),$this->itemlist($this -> items));
		$this->setparameter("","title","Login Form");
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