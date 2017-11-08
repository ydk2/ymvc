<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\controllers\JSON;


class Two extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->auth = $this->model->auth;

        if (isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if (isset($this->model->uid)) $this->uid = $this->model->uid;
        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);
        
                //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error > 0) $this->error = 501;
                //$this->ViewData('error', $this->error);
        if ($this->error) {
                    //$this->Error();
            $this->throwError($this->Error());
        }

        $this->Run();
    }

    public function Run()
    {
        $this->ViewData('test', HOST);
        if ($this->error) {
            $this->throwError($this->Error());
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