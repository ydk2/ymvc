<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-25 12:18:38
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-02-26 14:33:05
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
        $this->required = array(
            'account_adnotation'=>array('text',0,999),
            'account_name'=>array('text',3,99),
            'account_email'=>array('email',0,0),
            'account_born'=>array('date',0,0),
            'account_pass'=>array('alphanum',6,199),
            'account_login'=>array('alphanum',3,40),
            'account_role'=>array('alphanum',3,40),
        );
        
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
            //$this->unew();
            $this->ushownew();
            # code...
            break;
        case SYS.V.'accounts'.DS.'check':
            $this->link = '?accounts-user=accounts-new';
            $this->uchecknew();
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
    $finance = array(
    "finance varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $other = array(
    "other varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $fax = array(
    "fax varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $regon = array(
    "regon integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $nip = array(
    "nip integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $bank = array(
    "bank integer not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $www = array(
    "www varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $mail = array(
    "mail varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $tel = array(
    "tel varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $address = array(
    "city varchar(99) not null",
    "street varchar(99) not null",
    "apartament varchar(9) not null",
    "number varchar(9) not null",
    "postal_code varchar(9) not null",
    "postal_city varchar(99) not null",
    "country varchar(99) not null",
    "for_account integer not null",
    "in_pos integer not null",
    "ctime integer not null",
    "mtime integer not null"
    );
    $entries = array(
    "account_name varchar(99) not null",
    "account_login varchar(99) not null unique",
    "account_email varchar(99) not null unique",
    "account_pass varchar(199) not null",
    "account_role varchar(32) not null default 'user'",
    "account_born varchar(32) not null",
    "account_can_login varchar(4) default 'yes'",
    "account_active varchar(4) default 'yes'",
    "account_adnotation TEXT ",
    "account_role_id integer not null default 10",
    "account_ctime integer not null",
    "account_mtime integer not null"
    );
    $this->model->dropTable($table);
    $this->model->createTable($table,$entries);
    $this->model->createTable($mailtable,$mail);
    $this->model->createTable($teltable,$tel);
    $this->model->createTable($faxtable,$fax);
    $this->model->createTable($wwwtable,$www);
    $this->model->createTable($othertable,$other);
    $this->model->createTable($banktable,$bank);
    $this->model->createTable($financetable,$finance);
    $this->model->createTable($niptable,$nip);
    $this->model->createTable($regontable,$regon);
    $this->model->createTable($addresstable,$address);
    //var_dump($this->usersList);
    $this->ushownew();
}

public function ushownew(){
    $this->userdetails = array(
    'account_name'=>"",
    'account_login'=>"",
    'account_email'=>"",
    'account_pass'=>"",
    'account_role'=>"user",
    'account_born'=>date('d-m-Y',time()),
    'account_can_login'=>"yes",
    'account_active'=>"yes",
    'account_adnotation'=>"",
    'account_role_id'=>10,
    'account_ctime'=>time(),
    'account_mtime'=>time(),
    );

    if(helper::get('reset')=='yes'){
        helper::session_unset('account_new');
    }
    elseif(!empty(helper::session('account_new')) || helper::session('account_new')!=""){
        $this->userdetails = helper::session('account_new');
        $this->userdetails['account_born'] = date('d-m-Y',helper::session('account_new')['account_born']);
        //$this->userdetails['account_pass']='';
    }
    
    
}
public function uchecknew(){
    $this->msg = "";
    $this->subview = "";
    $table = 'accounts';
    $chk = true;
    $this->post=$_POST;
    if(isset($this->post) && !empty($this->post)){

        helper::session_unset('account_new');
        $this->post['account_ctime']=time();
        $this->post['account_mtime']=time();
        if(!isset($this->post['account_can_login'])) $this->post['account_can_login']='no';
        if(!isset($this->post['account_active'])) $this->post['account_active']='no';
        foreach ($this->post as $key => $value) {
            if($key=='address'){
                $string = serialize($value);
                $this->post[$key]=$string;
            } else if($key=='account_born'){
                $string = strtotime($value);
                $this->post[$key]=$string;
            } else if($key=='account_adnotation'){
                $string = $value.'';
                $this->post[$key]=$string;
            } else {
                $string = (is_array($value))?implode(';',$value):$value;
                $this->post[$key]=$string;
            }
        }
        $this->post['account_adnotation']=$this->post['account_adnotation'].' ';
        helper::session_set('account_new',$this->post);
    }

    if(helper::session('account_new')){
        $this->utest=$this->utest();
        if($this->utest == count($this->required)){
            $this->usavenew();
        }
    }
}


private function utest(){
    $retbool = 0;
    $savemaindata = array();
    foreach (helper::session('account_new') as $key => $value) {
        if(strpos($key, "account_") !== false && $value != ''){

            if($key === 'account_born'){
                $value = date('d-m-Y',$value);
            }
            if($key === 'account_adnotation'){
                $value = $value." ";
            }
            if(array_key_exists($key,$this->required)){
                $retbool += helper::validate($value,$this->required[$key][0],$this->required[$key][1],$this->required[$key][2]);
            }
            //$savemaindata[$key] = $value;
        }
    }
    return $retbool;
}
private function usavenew(){
    $table = 'accounts';
    $savemaindata = array();
    $saveotherdata = array();
    foreach (helper::session('account_new') as $key => $value) {
        if(strpos($key, "account_") !== false && $value != ''){
            $savemaindata[$key] = $value;
            $savemaindata['account_pass'] = sha1($value);
        } else {
            $saveotherdata[$key] = $value;
        }
    }
    $this->msg = "";
    $this->subview = "";
    if(helper::get('answer')=='yes' && !empty($savemaindata)){
    $this->model->Begin(Helper::Session('token'));
    $chk=$this->model->insert($table,$savemaindata);
    $this->model->Commit(Helper::Session('token'));
    if($chk){
        $accountdata = helper::session('account_new');
        $this->model->Release(Helper::Session('token'));

        $this->data->link=$this->link."";
        $this->data->link_no=$this->link."&answer=no";
        $this->data->header='Udane';
        $this->data->text='Operacja zakończona pomyślnie';
        $this->msg = $this->subView(SYS.V."elements-msg");
        $this->title = intl::_('Lista Dodanych');

        $this->user=$this->model->Select($table,array('id','account_login'),'where account_login=?',array($accountdata['account_login']));
        if(isset($accountdata['address'])){
            $this->usavenewaddress($table,$accountdata,unserialize($accountdata['address']));
            $this->user=$this->model->Select($table.'_address',array('id','for_account'),'where for_account=?',array($this->user[0]['id']));
        }

        $this->subview=$this->subView(SYS.V.'accounts-addon');
        helper::Session_Unset('account_new');
    } else {
        $this->model->Rollback(Helper::Session('token'));

        $this->data->link=$this->link."";
        $this->data->link_no=$this->link."&answer=no";
        $this->data->header= 'Nie Udane';
        $this->data->text='Operacja zakończona błędem';
        $this->msg = $this->subView(SYS.V."elements-msg");
        $this->title = intl::_('Lista Dodanych');
        //$this->usersList=$this->model->Select($table,array('id','account_name','account_login','account_role','account_email'));
        //$this->subview=$this->subView(SYS.V.'accounts-list');
        //var_dump($saveotherdata);
        $accountdata = helper::session('account_new');
        $user=$this->model->Select($table,array('id','account_login'),'where account_login=?',array($accountdata['account_login']));
        if(isset($saveotherdata['address'])){
            $this->usavenewaddress($table,$accountdata,unserialize($saveotherdata['address']));
        }
        $this->user=$this->model->Select($table.'_address',array('id','for_account'),'where for_account=?',array($user[0]['id']));
    }
    }
}
public function usavenewaddress($table,$user,$data){

    $chk = 0;
    $user=$this->model->Select($table,array('id','account_login'),'where account_login=?',array($user['account_login']));
    $this->subview=$this->subView(SYS.V.'accounts-addon');

    if(helper::get('answer')=='yes' && !empty($data)){

    $this->model->Begin(Helper::Session('token'));
    foreach ($data as $key => $value) {
        $value['for_account']=$user[0]['id'];
        $value['in_pos']=$key;
        $value['ctime']=time();
        $value['mtime']=time();
        $chk=$this->model->insert($table.'_address',$value);
    }

    $this->model->Commit(Helper::Session('token'));
    if($chk){
        $this->model->Release(Helper::Session('token'));
    } else {
        $this->model->Rollback(Helper::Session('token'));
    }

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
public function dump($value){
    ob_start();
    var_dump($value);
    $out = ob_get_clean();
    return $out;
}
}
?>