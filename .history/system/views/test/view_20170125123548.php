<?php

       // $aout=$this->searchByNameValue($this->array,'_name','three','l');
        //var_dump($this->model);
        //$aout[4][count($data)+1]['_view'] = 'four';
        // $this->setValue($aout,3,'_view','cccc');
       //  $this->setValue($aout,3,'_name','cccc');
       // unset($aout[3][$this->GetId($aout,3,'_type')]);
       // $aout[4][$this->GetFreeId($this->array,$aout,'l')+1]['_name'] = 'four';
       // $rout=$this->reverseItems($aout,'l');
        //var_dump($rout);
		// $users=array('name'=>'admin','email'=>'admin@localhost.to', 'password'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'role'=>'admin','role_id'=>1);
		$update = false;
		$insert = false;
		$delete = FALSE;
		if(Helper::get('insert')){
			$insert = true;
		}
		if(Helper::get('update')){
			$update = true;
		}
		if(Helper::get('delete')){
			$delete = true;
		}
		$table='layouts';
		$gprx = 'layout';
		$this->array = $this->model->get_entries($table,$gprx,2);
        $aout=$this->model->searchByName($this->array,'name',$gprx);
		//$this->model->SetValue($this->array,3,'_view','NewValue','l');
?>
<a href="?test-test&deleteidx=2">delete idx 2</a>
<a href="?test-test&insert=true">insert</a>
<a href="?test-test&delete=2">delete idx 2</a>
<?php
		//$this->model->SetName($this->array,1,'_name','_add','l');
		//$this->SetName($this->array,1,'_name','_add','l');
		//echo $this->model->GetIdx($this->array,'_name','two','l');
		echo "<br>";
		//echo $this->model->GetId($this->array,3,'_name','l');
    	var_dump($aout);
		if($delete){
		foreach ($this->array as $items) {
			$this->model->delete_idx($table,Helper::get('delete'),$items['gprx']);
		}
		}
        //var_dump($this->array);
        $content=Config::$data['layout_data'];
		$item = json_decode(file_get_contents(ROOT.SYS.STORE.$content),true);
        //$aout=$this->model->searchByName($this->array,'name',$gprx);
		//$aout[$this->model->GetIdx($this->array,'_view','two','l')]['_view']='cccc';
		//var_dump($aout);
		//$users[0]=unserialize('a:5:{s:12:"account_type";s:13:"Administrator";s:13:"account_login";s:5:"admin";s:12:"account_pass";s:5:"d033e22ae348aeb5660fc2140aec35850c4da997";s:12:"account_name";s:5:"admin";s:4:"mail";s:9:"aa@ccc.jj";a:1:{i:0;s:0:"";}}');
/**
		$users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','role_id'=>1);
		$users[1]=array('account_login'=>'user','account_name'=>'user','account_email'=>'user@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','role_id'=>5);

    	$rout=$this->model->reverseNoId($users,$gprx);
    	//var_dump($rout);

		// user login
		$gprx='login';
		$table = 'loginusers';
		$user = 'admin';
		$pass = 'admin';
		$pass_check = false;
		$user_data = null;
		$user_check = $this->model->get_key_value($table,'account_login',$user,$gprx);
		if($user_check){
			$pass_check = $this->model->get_idx_key($table,'account_pass',$user_check[0]['idx'],$gprx);
			$pass_check = $pass_check[0]['value'];
			if($pass_check==sha1($pass)){
				$pass_check = TRUE;
			}
		}
		if($pass_check==TRUE){
			$enteries = $this->model->get_idx_enteries($table,$user_check[0]['idx'],$gprx);
			$user_data=$this->model->searchByNameValue($enteries,'account_login',$user,$gprx);
		}
		var_dump($user_data);
		// end user login
**/
		if($insert){
    		var_dump($this->model->createTable($table,$gprx));
		foreach ($rout as $items) {
			$this->model->add_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
		if($update){
		foreach ($rout as $items) {
			$this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
?>