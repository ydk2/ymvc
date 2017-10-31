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
        $auth = $this->model->auth;

        $auth->request(40*60);

        if ($auth->error == 200) {

            $now = date("Y-m-d H:i:s", time());
            $expires = strtotime($auth->is_expires);

            $d = round(($expires - time()) / 60,0);

            $this->ViewData('event', 'message');
            //$this->ViewData('expires', $d);
            if($auth->access_token){
                //$auth->regenerate();
                $arr = array(
                    "error"=>$auth->error,
                    "access_token"=>$auth->access_token
                );
                $this->ViewData('data', json_encode($arr));
            } else {
                $error = $auth->error==200 ? 0 : $auth->error; 
                $this->ViewData('data', '{"error":'.$auth->error.',"time":"'.$now.'","expires":"'.$d.'"}');
            }
            
        } else {
            $this->ViewData('event', 'message');
            $this->ViewData('data', '{"error":'.$auth->error.'}');
            
        }

        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $auth->error);
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