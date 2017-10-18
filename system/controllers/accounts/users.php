<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-25 12:18:38
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-03-02 19:09:24
*/
class Users extends Render {
    //private $error;
    public $usersList= array();
    public $userdetails= array();
    public static function Config() {
        return array(
        'title'=>'Namage users',
        'access_groups'=>array('admin','moderator','editor','user')
        );
    }
    public function Init() {
        $config=Users::Config();
        Config::$data['tmp_data']['login'] = TRUE;
        $this -> alert = '';
        $this -> alert_header = '';
        $this -> alert_string = '';
        $this->SetAccess(self::ACCESS_EDITOR);
        //$this->access_groups = array('admin','editor');
        $this->access_groups = $config['access_groups'];
        $this->current_group = Helper::Session('user_role');
        $this->AccessMode(2);
        $this->global_access = Helper::Session('user_access');
        
        $this->RegisterView(SYS.V.'login'.S.'form');
        $this->SetModel(SYS.M.'accountsdata');
        
        $this->required = array(
        'account_adnotation'=>array('text',0,999),
        'account_name'=>array('text',3,99),
        'account_email'=>array('email',0,0),
        'account_born'=>array('date',3,0),
        'account_pass'=>array('alphanum',6,199),
        'account_login'=>array('alphanum',3,40),
        'account_role'=>array('alphanum',3,40),
        );
    }
    
    public function Run() {
        Config::$data['menu']['current']="users";
        $section = (Helper::post('save'))?"&section=".Helper::post('save'):"";
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
            $this->link = '?accounts-users=accounts-detail'.$section;
            $this->udetail();
            # code...
            break;
        case SYS.V.'accounts'.DS.'save':
            $this->link = '?accounts-users=accounts-detail&user='.helper::post('id').$section;
            $this->ucheck();
            # code...
            break;
        
}
}

public function ucheck(){
    $this->msg = "";
    $this->subview = "";
    $table = 'accounts';
    $chk = true;
    $this->post=$_POST;
    if(isset($this->post) && !empty($this->post)){
        
        helper::session_unset('account_edit');
        if($this->post['save']=="settings"){
            
            if(intval($this->post['id'])>intval(Helper::Session('id')) || intval(Helper::Session('id'))==1){
                $this->post['account_can_login']=(Helper::Post('account_can_login')=="yes")?"yes":"no";
                $this->post['account_active']=(Helper::Post('account_active')=="yes")?"yes":"no";
            }
        }
        if($this->post['save']=="login"){
            if(Helper::Post('account_pass')==""){
                unset($this->post['account_pass']);
            } else {
                $this->post['account_pass'] = sha1($this->post['account_pass']);
            }
        }
        $this->post['account_mtime']=time();
        foreach ($this->post as $key => $value) {
            if(strpos($key, "account_") !== false && $value != ''){
                if($key=='address'){
                    $string = serialize($value);
                    $this->post[$key]=$string;
                } else if($key=='account_born'){
                    $string = strtotime($value)."000";
                    $this->post[$key]=$string;
                } else if($key=='account_adnotation'){
                    $string = $value.'';
                    $this->post[$key]=$string;
                } else {
                    $string = (is_array($value))?implode(';',$value):$value;
                    $this->post[$key]=$string;
                }
            }
        }
        //$this->post['account_adnotation']=$this->post['account_adnotation'].' ';
        helper::session_set('account_edit',$this->post);
    }
    
    if(helper::session('account_edit')){
        $this->utest=$this->utest();
        // if($this->utest == count($this->required)){
        $this->usave();
        // }
    }
}

private function utest(){
    $retbool = 0;
    $savemaindata = array();
    foreach (helper::session('account_edit') as $key => $value) {
        if(strpos($key, "account_") !== false && $value != ''){
            
            if($key === 'account_born'){
                //$value = date('d-m-Y',intval($value)/1000);
            }
            if($key === 'account_adnotation'){
                //$value = $value." ";
            }
            if(array_key_exists($key,$this->required)){
                $retbool += helper::validate($value,$this->required[$key][0],$this->required[$key][1],$this->required[$key][2]);
            }
            //$savemaindata[$key] = $value;
        }
    }
    return $retbool;
}

private function usave(){
    $table = 'accounts';
    $savemaindata = array();
    $saveotherdata = array();
    //helper::session_set('account_edit',$_POST);
    foreach (helper::session('account_edit') as $key => $value) {
        if(strpos($key, "account_") !== false && $value != ''){
            if($key == "account_born"){
                //$value = $value."000";
            }
            $savemaindata[$key] = $value;
            //if(isset($savemaindata['account_pass']))
            //$savemaindata['account_pass'] = sha1($value);
            //if(isset($savemaindata['account_born']))
            //$savemaindata['account_born'] = strtotime($value);
        } else {
            // $saveotherdata[$key] = $value;
        }
    }
    //var_dump($savemaindata);
    $this->msg = "";
    $this->subview = "";
    if(!empty($savemaindata)){
        $chk=$this->model->TUpdate($table,$savemaindata,'where id=?',array(helper::post('id')));
        $section = (Helper::Get('section'))?"&section=".Helper::Get('section'):"";
        if($chk){
            $this->data->link=$this->link."".$section;
            $this->data->link_no=$this->link."&answer=no".$section;
            $this->data->header='Udane';
            $this->data->text='Operacja zakończona pomyślnie';
            $this->msg = $this->subView(SYS.V."elements-msg");
        } else {
            $this->data->link=$this->link."".$section;
            $this->data->link_no=$this->link."&answer=no".$section;
            $this->data->header= 'Nie Udane';
            $this->data->text='Operacja zakończona błędem';
            $this->msg = $this->subView(SYS.V."elements-msg");
        }
    }
    
}

public function insert_addon($table,$user,$key,$data){
    
    $chk = 0;
    $this->subview=$this->subView(SYS.V.'accounts-addon');
    
    if(helper::get('answer')=='yes' && !empty($data)){
        
        $this->model->Begin(Helper::Session('token'));
        foreach ($data as $pos => $entry) {
            $value[$key]=$entry;
            $value['for_account']=$user;
            $value['in_pos']=$pos;
            $value['ctime']=time();
            $value['mtime']=time();
            $chk=$this->model->insert($table,$value);
        }
        $this->model->Commit(Helper::Session('token'));
        if($chk){
            $this->model->Release(Helper::Session('token'));
        } else {
            $this->model->Rollback(Helper::Session('token'));
        }
        
    }
    return $chk;
}
public function insert_address($table,$user,$data){
    
    $chk = 0;
    $this->subview=$this->subView(SYS.V.'accounts-addon');
    
    if(helper::get('answer')=='yes' && !empty($data)){
        
        $this->model->Begin(Helper::Session('token'));
        foreach ($data as $key => $value) {
            $value['for_account']=$user;
            $value['in_pos']=$key;
            $value['ctime']=time();
            $value['mtime']=time();
            $chk=$this->model->insert($table,$value);
        }
        $this->model->Commit(Helper::Session('token'));
        if($chk){
            $this->model->Release(Helper::Session('token'));
        } else {
            $this->model->Rollback(Helper::Session('token'));
        }
        
    }
    return $chk;
}
public function ulist(){
    
    $table = 'accounts';
    $keys = array('id','account_name','account_login','account_role','account_email');
    $this->pagination=$this->Loader(SYS.C.'elements-pagination');
    
    if(helper::get('query')!=""){
        $this->title = "Wyniki wyszukiwania";
        $this->pagination->limit = 5;
        $this->lenght=$this->model->Count($table,'where '.helper::get('filter').' LIKE "%'.helper::get('query').'%" ;',array());
        $this->pagination->paginate_lenght_sum($this->lenght);
        $this->offset = $this->pagination->paginate_offset_sum();
        $this->List=$this->model->Select($table,$keys,'where '.helper::get('filter').' LIKE "%'.helper::get('query').'%" LIMIT '.$this->pagination->limit.' OFFSET '.$this->offset.';',array());
        
        if(!empty($this->List)) {
            $i = 0;
            foreach ($this->List as $key => $value) {
                switch ($this->List[$i]['account_role']) {
                    case 'admin':
                        $roleid = 1;
                        break;
                    case 'system':
                        $roleid = 2;
                        break;
                    case 'moderator':
                        $roleid = 3;
                        break;
                    case 'editor':
                        $roleid = 4;
                        break;
                    case 'user':
                        $roleid = 5;
                        break;
                    default:
                        $roleid = 10;
                        break;
                }
                if(Helper::Session('id') === $this->List[$i]['id']){
                    $this->usersList[$i]=$value;    
                }
                if(intval(Helper::Session('user_access'))<intval($roleid)){
                    $this->usersList[$i]=$value;    
                }
                $i++;
            }
        }
    } else {
        $this->pagination->limit = 5;
        $this->lenght=$this->model->Count($table);
        $this->pagination->paginate_lenght_sum($this->lenght);
        $this->offset = $this->pagination->paginate_offset_sum();
        $this->List=$this->model->Select($table,$keys,' LIMIT '.$this->pagination->limit.' OFFSET '.$this->offset.';',array());
    
        $this->title = "użytkownicy";
        if(!empty($this->List)) {
            $i = 0;
            foreach ($this->List as $key => $value) {
                switch ($this->List[$i]['account_role']) {
                    case 'admin':
                        $roleid = 1;
                        break;
                    case 'system':
                        $roleid = 2;
                        break;
                    case 'moderator':
                        $roleid = 3;
                        break;
                    case 'editor':
                        $roleid = 4;
                        break;
                    case 'user':
                        $roleid = 5;
                        break;
                    default:
                        $roleid = 10;
                        break;
                }
                if(Helper::Session('id') === $this->List[$i]['id']){
                    $this->usersList[$i]=$value;    
                }
                if(intval(Helper::Session('user_access'))<intval($roleid)){
                    $this->usersList[$i]=$value;
                    
                }
                $i++;
            }
        }
    }
//var_dump($this->usersList);
}
public function udetail(){
    $table = 'accounts';
    $current = helper::get('user');
    $user=$this->model->Select($table,array('*'),'where id=?',array($current));
    $this->userdetails=$user[0];
    /**
    $list = array('mail','tel','fax','www','bank','other','finanse','regon','nip');
    foreach ($list as $value) {
    $other=$this->model->Select($table.'_'.$value,array('*'),'where for_account=?',array($current));
    $out = array();
    if($other){
    foreach ($other as $key => $ent) {
    $out[$key]=$other[$key][$value];
    }
    $this->userdetails[$value]=implode(';',$out);
    //var_dump($out);
    }
    }
    $address=$this->model->Select($table.'_address',array('*'),'where for_account=?',array($current));
    if($address){
    //var_dump($address);
    $this->userdetails['address']=serialize($address);
    }
    **/
    //$other=$this->model->Select($table,array('*'),'where id=?',array($current));
    //$this->usersList += $this->model->searchByName($users,'account_name',$gprx);
    //$this->usersdetail=$this->model->get_name_idx($table,'account_name',$value[0],$gprx)[0]['value'];
    
    //var_dump($this->usersList);
}

public function uroles(){
    
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