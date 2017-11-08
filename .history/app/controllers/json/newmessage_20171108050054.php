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
        $data = array(
            'msgid'=>$msgid,
            'code'=>Helper::Post('code'),
            'ctime'=>date('Y-m-d H:i:s', time())
        );

        $this->ViewData('appid', $appid);
        $this->ViewData('scope', json_encode($this->auth->scope));
        $this->ViewData('error', $this->auth->error);
        $this->ViewData('request', json_encode($data));
        $this->ViewData('response', json_encode($this->auth->request));

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