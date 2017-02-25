<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-25 19:51:40
*/
class User extends PHPRender {
    public $link;
    public $usersList= array();
    public $userdetails= array();
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
        $this->SetAccess(self::ACCESS_EDITOR);
        $this->access_groups = array('admin','editor');
        $this->current_group = Helper::Session('user_role');
        $this->AccessMode(2);
        $this->global_access = Helper::Session('user_access');
        
        $this->RegisterView(SYS.V.'login'.S.'form');
        $this->SetModel(SYS.M.'accountdata');
        
    }
    
    public function Run() {
        Config::$data['menu']['current']="users";
        switch ($this->view) {
            case SYS.V.'accounts'.DS.'list':
                $this->link = '?accounts-users=accounts-list';
            if(helper::get('query')){
                    $this->ulist();
            } else {
                $this->ulist();
            }
            # code...
            break;
        case SYS.V.'accounts'.DS.'detail':
            $this->link = '?accounts-user=accounts-detail';
            $this->udetail();
            # code...
            break;
        case SYS.V.'accounts'.DS.'new':
            $this->link = '?accounts-user=accounts-new';
            $this->unew();
            # code...
            break;
        case SYS.V.'accounts'.DS.'check':
            $this->link = '?accounts-user=accounts-detail&user='.helper::post('id');
            $this->utest();
            # code...
            break;
        
        default:
            break;
}
}

public function usave(){
    
    $gprx='login';
    $table = 'loginusers';
    $this->post = $_POST;
	//var_dump($this->post);
    if(isset($this->post) && !empty($this->post)){
        if(!isset($this->post['can_login']) && @$this->post['can_login']!='yes') {
            $this->post['can_login']='no';
            $account_get = $this->model->get_name_idx($table,'account_login',$this->post['idx'],$gprx);
            $pass_get = $this->model->get_name_idx($table,'account_pass',$this->post['idx'],$gprx);
            $this->post['account_login']=$account_get[0]['value'];
            $this->post['account_pass']=$pass_get[0]['value'];
        } else {
            if($this->post['account_pass']==""){
                $pass_get = $this->model->get_name_idx($table,'account_pass',$this->post['idx'],$gprx);
                $this->post['account_pass']=$pass_get[0]['value'];
            } else {
    			$this->post['account_pass']=sha1($this->post['account_pass']);
            }
    	}
		$this->post['role_id']=5;
        if(!isset($this->post['active']) && @$this->post['active']!='yes') $this->post['active']='no';
        $data =array();
        $idx = $this->post['idx'];
        unset($this->post['idx']);

        foreach ($this->post as $key => $value) {
            if($key=='address'){
                $string = serialize($value);
                unset($this->post[$key]);
            } else {
                $string = (is_array($value))?implode(', ',$value):$value;
            }
            $data[$idx][$key] = $string;
        }
        $rout=$this->model->reverseNoId($data,$gprx);
        //var_dump($rout);
		$delete=false;
        if($delete){
            foreach ($rout as $items) {
                if($items['name']=='address')
                $this->model->delete_item($table,$items['name'],$items['idx'],$items['gprx']);
            }
        }
        $update=FALSE;
        $chk = 0;
        $this->subview = "";
       // var_dump($this->model->islock($table));
        if(!$this->model->islock($table)){
        $this->model->lock($table);
		$update=true;

        if($update){
            foreach ($rout as $items) {
                $chk = $this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
            }
        }
        $this->model->unlock($table);
        }
        if(!$chk){
            $this->data->link_yes=$this->link."&answer=yes";
            $this->data->link_no=$this->link."&answer=no";
            $this->data->header="Answer";
            $this->data->text="answer text";
            $this->subview = $this->subView(SYS.V."elements-answer");
        }
        if($chk){
            $this->data->link_yes=$this->link."&answer=yes";
            $this->data->link_no=$this->link."&answer=no";
            $this->data->header="Answer";
            $this->data->text="answer text";
            $this->subview = $this->subView(SYS.V."elements-answer");
        }
    }
}
public function ulist(){
    $table = 'accounts';

    //var_dump($this->usersList);
}
public function udetail(){
    $gprx='login';
    $table = 'loginusers';
    $this->List = $this->model->get_idx_list($table,$gprx);
    $i = 0;
    $user=$this->model->get_idx_enteries($table,helper::get('user'),$gprx);
    $this->userdetails = $this->model->searchByName($user,'account_name',$gprx)[helper::get('user')];
    $this->userdetails['idx'] = helper::get('user');
    //$this->usersList += $this->model->searchByName($users,'account_name',$gprx);
    //$this->usersdetail=$this->model->get_name_idx($table,'account_name',$value[0],$gprx)[0]['value'];
    
    //var_dump($this->usersList);
}
public function unew(){
    $table = 'accounts';
    $mailtable = 'accounts_mail';
    $addresstable = 'accounts_address';
    $wwwtable = 'accounts_www';
    $teltable = 'accounts_tel';
    $banktable = 'accounts_bank';
    $financetable = 'accounts_finance';
    $niptable = 'accounts_nip';
    $regontable = 'accounts_regon';
    $faxtable = 'accounts_fax';
    $othertable = 'accounts_other';
    $address = array(
        "account_name varchar(99) not null unique",
        "account_login varchar(99) not null unique",
        "account_email varchar(99) not null unique",
        "account_pass varchar(199) not null",
        "account_role varchar(32) not null default 'user'",
        "account_born integer not null",
        "can_login varchar(4) default 'yes'",
        "active varchar(4) default 'yes'",
        "adnotation TEXT ",
        "role_id integer not null default 10",
        "ctime integer not null",
        "mtime integer not null"
    );
    $entries = array(
        "account_name varchar(99) not null unique",
        "account_login varchar(99) not null unique",
        "account_email varchar(99) not null unique",
        "account_pass varchar(199) not null",
        "account_role varchar(32) not null default 'user'",
        "account_born integer not null",
        "can_login varchar(4) default 'yes'",
        "active varchar(4) default 'yes'",
        "adnotation TEXT ",
        "role_id integer not null default 10",
        "ctime integer not null",
        "mtime integer not null"
    );
    //$this->model->dropTable($table);
    //$this->model->createTable($table,$entries);
    //var_dump($this->usersList);
    $this->usavetest();
}

public function usavetest(){
    $this->userdetails = array(
        'account_name'=>"",
        'account_login'=>"",
        'account_email'=>"",
        'account_pass'=>"",
        'account_role'=>"user",
        'account_born'=>date('d-m-Y',time()),
        'can_login'=>"yes",
        'active'=>"yes",
        'adnotation'=>"",
        'role_id'=>10,
        'ctime'=>time(),
        'mtime'=>time(),
    );
    if(helper::session('account_new')!=''){
        $this->userdetails = helper::session('account_new');
        $this->userdetails['account_born'] = date('d-m-Y',helper::session('account_new')['account_born']);
    }

}
public function utest(){
$chk = true;
$this->post=$_POST;
        if(!$chk){
            $this->data->link_yes=$this->link."&answer=yes";
            $this->data->link_no=$this->link."&answer=no";
            $this->data->header="Answer";
            $this->data->text="answer text";
            $this->subview = $this->subView(SYS.V."elements-answer");
        }
        if($chk){
            $this->data->link_yes=$this->link."&answer=yes";
            $this->data->link_no=$this->link."&answer=no";
            $this->data->header="Answer";
            $this->data->text="answer text";
            $this->subview = $this->subView(SYS.V."elements-answer");
        }
}

public function uroles(){

}



public function oldRun() {
    $this->success_link = '?admin-mngaccount';
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
    $insert =false;
    $delete = FALSE;
    
    $gprx='login';
    $table = 'loginusers';
    
    //$array = $this->model->get_entries($table,$gprx);
    //var_dump($rout);
    // end user login
    if($insert){
        
        $users[0]=array('account_login'=>'admin','account_name'=>'admin','account_email'=>'admin@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'admin','role_id'=>1,'can_login'=>'y','active'=>'y');
        $users[1]=array('account_login'=>'user','account_name'=>'user','account_email'=>'user@localhost.to', 'account_pass'=>'d033e22ae348aeb5660fc2140aec35850c4da997', 'account_role'=>'user','role_id'=>5,'can_login'=>'y','active'=>'y');
        
        $rout=$this->model->reverseNoId($items,$data,$gprx);
        
        if($update){
            foreach ($rout as $items) {
                $this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
            }
        }
        
        var_dump($this->model->createTableRotate($table,$gprx));
        //		$rout=$this->model->reverseItems($items,$data,$gprx='')
        foreach ($rout as $items) {
            $this->model->add_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
        }
    }
    if($update){
        foreach ($rout as $items) {
            $this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
        }
    }
    
    // user login
    
    $pass_check = false;
    $user_data = null;
    if(!Helper::session('id')){
        $this->ViewData('alert','Podaj Nazwę Użytkownika i Hasło');
        $this->ViewData('classes',' alert-info text-info');
        if(Helper::get('action')=='login'){
            $user = Helper::post('account_login');
            $pass = Helper::post('account_pass');
            if (!$user && !$pass) {
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
                
                
                $user_check = $this->model->get_name_value($table,'account_login',$user,$gprx);
                if($user_check){
                    $active_check = $this->model->get_name_idx($table,'active',$user_check[0]['idx'],$gprx);
                    $active_check = $active_check[0]['value'];
                    $can_login_check = $this->model->get_name_idx($table,'can_login',$user_check[0]['idx'],$gprx);
                    $can_login_check = $can_login_check[0]['value'];
                    
                    if($active_check=='y' && $can_login_check=='y'){
                        $pass_get = $this->model->get_name_idx($table,'account_pass',$user_check[0]['idx'],$gprx);
                        $pass_get = $pass_get[0]['value'];
                        if($pass_get==sha1($pass)){
                            $pass_check = TRUE;
                        } else {
                            $this->ViewData('alert','Hasło niepasuje');
                            $this->ViewData('classes',' alert-danger text-danger');
                        }
                    } else {
                        $this->ViewData('alert','Konto nieaktywne');
                        $this->ViewData('classes',' alert-danger text-danger');
                    }
                } else {
                    $this->ViewData('alert','Brak Użytkownika');
                    $this->ViewData('classes',' alert-danger text-danger');
                } // check user
                
            }
            
        }
        if($pass_check==TRUE){
            //$enteries = $this->model->get_idx_enteries($table,$user_check[0]['idx'],$gprx);
            $user_data=$this->model->search_idx_enteries($table,$user_check[0]['idx'],$gprx); //$this->model->searchByNameValue($enteries,'account_login',$user,$gprx);
            Helper::session_set('id', key($user_data)+1);
            Helper::session_set('user_name', $user_data[key($user_data)]['account_name']);
            Helper::session_set('user_email', $user_data[key($user_data)]['account_email']);
            Helper::session_set('user_role', $user_data[key($user_data)]['account_role']);
            Helper::session_set('user_access', $user_data[key($user_data)]['role_id']);
            Helper::session_set('token', base64_encode(microtime()));
            $this->ViewData('alert','Zalogowano');
            $this->ViewData('classes',' alert-success text-success');
            $this->ViewData('success_link',$this->success_link);
            $this->ViewData('user_name',$user_data[key($user_data)]['account_name']);
            $this->SetView(SYS.V ."login".S."welcome");
        } else {
            $this->SetView(SYS.V . "login".S."form");
        }
        
    } else {
        
        $this->ViewData('alert','Już Zalogowano, lecz możesz się wylogować lub wrócić do systemu');
        $this->ViewData('classes',' alert-warning text-success');
        $this->ViewData('success_link',$this->success_link);
        $this->ViewData('user_name',Helper::session('user_name'));
        $this->SetView(SYS.V ."login".S."welcome");
        
        if(Helper::get('action')=='logout'){
            $this->SetView(SYS.V . "login".S."logout");
            $this->ViewData('alert','Wylogować?');
            $this->ViewData('success_link',$this->success_link);
            $this->ViewData('classes',' alert-warning text-warning');
            $this->ViewData('user_name',Helper::session('user_name'));
            $this->ViewData('token',Helper::session('token'));
        }
        if(Helper::get('action')=='bye' && Helper::get('token')==Helper::session('token')){
            if(Helper::Session_Stop(Helper::session('id'))){
                $this->SetView(SYS.V . "login".S."bye");
                $this->ViewData('alert','Wylogowano');
                $this->ViewData('classes',' alert-success text-success');
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
    $error=$this->NewViewExt(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
    $error->setParameter('','inside','yes');
    $error->setParameter('','show_link','no');
    $error->model->title= Intl::_p('Warning!!!');
    $error->model->header = Intl::_p('Warning!!!').' '.$this->error;
    $error->model->alert = Intl::_p($this->emessage).'';
    $error->model->error = $this->error;
    return $error->View();
}
}
?>