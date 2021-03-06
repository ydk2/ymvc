<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\controllers\JSON;

use \Library\Core\Helper as Helper;

class NewMessage extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->db = $this->model->db;

        $this->auth = $this->model->auth;

        if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $g = $this->GetAccess(2,TRUE);
        $e = $this->isEnabled(TRUE);

        //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error>0 && $this->auth->error !== 200) $this->error = 501;
        if ($this->error && $this->auth->error !== 200) {
            $this->throwError($this->Error());
        }

        $this->Run();
    }

    public function Run()
    {
        $data = array(
            'msgid'=>Helper::Post('msgid'),
            'code'=>Helper::Post('code')
        );

        $scope = ['id', 'account_name', 'account_email', 'account_share', 'account_role'];
        $this->auth->scope = $scope;
        $this->auth->response();
        $this->update();
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->auth->error);
    }

    private function update(){
        $appid = Helper::Post('appid');
        $msgid = $this->auth->request['id'].','.time();
        $for_id = $this->auth->request['id'];
        $from_id = $this->auth->request['id'];
        
        $data = array(
            'appid'=>$appid,
            'from_id'=>$from_id,
            'for_id'=>$for_id,
            'msgid'=>$msgid,
            'code'=>Helper::Post('code'),
            'ctime'=>date('Y-m-d H:i:s', time()),
            'mtime'=>date('Y-m-d H:i:s', time()),
            'lat'=>0,
            'lon'=>0,
            'user'=>"",
            'car'=>"",
            'status'=>0
        );

        $new = $this->db->TinsertUpdate('accounts_msg',$data," WHERE msgid<>? AND from_id<>?",[$msgid,$from_id]);

        $error = 0;
        if(!$new){
            $error = 101;
        }

        $this->ViewData('appid', $appid);
        $this->ViewData('scope', json_encode($this->auth->scope));
        $this->ViewData('error', $error);
        $this->ViewData('response', json_encode($data));
        $this->ViewData('request', json_encode($this->auth->request));

    }

    public function Error()
    {
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->error);
        $this->model->appid = '';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error =  $this->auth->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e.json');
        return $error;
    }
}
?>