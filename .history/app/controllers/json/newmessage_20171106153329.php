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
        //$this->ViewData('error', $this->error);
        if ($this->error) {
            //$this->Error();
            //$this->throwError($this->Error());
        }

        $this->Run();
    }

    public function Run()
    {

        $scope = ['id', 'account_login', 'account_email', 'account_born', 'account_role'];
        $this->ViewData('scope', json_encode($scope));

        if ($this->auth->error == 200) {

            $now = date("Y-m-d H:i:s", time());
            $expires = strtotime($this->auth->is_expires);

            $d = round(($expires - time()) / 60,0);

            $this->ViewData('event', 'message');
            //$this->ViewData('expires', $d);
            if($this->auth->access_token){
                //$this->auth->regenerate();
                $arr = array(
                    "error"=>$this->auth->error,
                    "access_token"=>$this->auth->access_token
                );
                $this->ViewData('data', json_encode($arr));
            } else {
                $error = $this->auth->error==200 ? 0 : $this->auth->error; 
                $request = json_encode($this->auth->request);
                $this->ViewData('data', '{"error":'.$this->auth->error.',"time":"'.$now.'","expires":"'.$d.'","group":"'.$this->guid.'","request":'.$request.'}');
            }
            
        } else {
            $this->ViewData('event', 'message');
            $this->ViewData('data', '{"error":'.$this->auth->error.'}');
            
        }

        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->auth->error);
    }

    public function Error()
    {
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->error);
        $this->model->appid = '""';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error =  $this->auth->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e.json');
        return $error;
    }
}
?>