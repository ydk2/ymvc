<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-21 05:46:24
*/
class Users extends PHPRender {
    //private $error;
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
        $this->SetModel(SYS.M.'accountsdata');
        
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
            $this->link = '?accounts-users=accounts-detail';
            $this->udetail();
            # code...
            break;
        case SYS.V.'accounts'.DS.'save':
            $this->link = '?accounts-users=accounts-detail&user='.helper::post('idx');
            $this->usave();
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
    if(isset($this->post) && !empty($this->post)){
        if(helper::post('can_login')!="y") {
            $this->post['can_login']='n';
            unset($this->post['account_login']);
            unset($this->post['account_pass']);
        }
        if(helper::post('active')!='y') $this->post['active']='n';
        $data =array();
        $idx = $this->post['idx'];
        unset($this->post['idx']);

        foreach ($this->post as $key => $value) {
            $string = (is_array($value))?implode(', ',$value):$value;
            $data[$idx][$key] = $string;
        }
        $rout=$this->model->reverseNoId($data,$gprx);
        //var_dump($rout);
		$update=TRUE;
        if($update){
            foreach ($rout as $items) {
                $this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
            }
        }
    }
}
public function ulist(){
    $gprx='login';
    $table = 'loginusers';
    if(helper::get('query')!=""){
        //var_dump(helper::get('query'));
        $this->title = "Wyniki wyszukiwania";
        $this->List=$this->model->query_value($table,helper::get('filter'),helper::get('query'),$gprx);
        
        //var_dump($this->List);
        if(!empty($this->List)) {
            $i = 0;
            foreach ($this->List as $key => $value) {
                //$users=$this->model->get_idx_enteries($table,$value,$gprx);
                //$this->usersList += $this->model->searchByName($users,'account_name',$gprx);
                $this->usersList[$i]['account_name']=$this->model->get_name_idx($table,'account_name',$key,$gprx)[0]['value'];
                $this->usersList[$i]['account_login']=$this->model->get_name_idx($table,'account_login',$key,$gprx)[0]['value'];
                $this->usersList[$i]['account_role']=$this->model->get_name_idx($table,'account_role',$key,$gprx)[0]['value'];
                $this->usersList[$i]['id']=$this->model->get_name_idx($table,'account_role',$key,$gprx)[0]['idx'];
                $i++;
            }
        }
    } else {
        $this->List = $this->model->get_idx_list($table,$gprx);
        $this->title = "użytkownicy";
        if(!empty($this->List)) {
            $i = 0;
            foreach ($this->List as $key => $value) {
                //$users=$this->model->get_idx_enteries($table,$value,$gprx);
                //$this->usersList += $this->model->searchByName($users,'account_name',$gprx);
                $this->usersList[$i]['account_name']=$this->model->get_name_idx($table,'account_name',$value[0],$gprx)[0]['value'];
                $this->usersList[$i]['account_login']=$this->model->get_name_idx($table,'account_login',$value[0],$gprx)[0]['value'];
                $this->usersList[$i]['account_role']=$this->model->get_name_idx($table,'account_role',$value[0],$gprx)[0]['value'];
                $this->usersList[$i]['id']=$this->model->get_name_idx($table,'account_role',$value[0],$gprx)[0]['idx'];
                $i++;
            }
        }
    }
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