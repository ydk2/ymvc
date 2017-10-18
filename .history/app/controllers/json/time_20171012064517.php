<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\controllers\JSON;

use \Library\Core\Helper as Helper;

class Time extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);
        $this->groups = array("admin", "user", "editor", "mod");
        $this->access = 10;
        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);

        $this->Run();
    }

    public function Run()
    {

        $scope = ['id', 'account_login', 'account_email', 'account_born', 'account_role'];
        $this->ViewData('scope', json_encode($scope));

        $appid = 'bbj377hnm6sn49i998jrgbr33m';

        $conf = [
            'appid' => $appid,
            'scope' => $scope,
            'request' => NULL,
            'expires' => 3600 * 1,
            'token' => Helper::Request('access_token'),
            'autoupdate' => TRUE
        ];

        $auth = new \Library\Core\lAuth($conf);

        $auth->request();

        if ($auth->error == 200) {
            $now = date("Y-m-d H:i:s", time());
            $this->ViewData('event', 'message');
            $this->ViewData('data', $now);
            
        } else {
            $this->ViewData('event', 'message');
            $this->ViewData('data', 'not auth');
            
        }
    }

    public function Error()
    {
        $this->model->appid = NULL;
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }
}
?>