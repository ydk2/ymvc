<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\Controllers;

use \Library\Core\Helper;
use \Library\Core\Render;
use \Library\Core\Cookie;
use \Library\Core\Session;
use \Library\Helpers\Files;

class Main extends Render
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->auth = $this->model->auth;

        if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if(isset($this->model->uid)) $this->uid = $this->model->uid;
        //$g = $this->GetAccess(2,TRUE);
        $e = $this->isEnabled(TRUE);


        //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error>0) $this->error = 501;
        $this->ViewData('error', $this->error);
        if ($this->error) {
            $this->throwError($this->Error());
        } else {
            $this->Run();
        }

        
    }

    public function Run()
    {
        $db = $this->model->db;
        $this->ViewData('header','Test controller');
        $this->ViewData('host',HOST);

        $this->ViewData('left_column','Menu');
        $this->ViewData('main_column','Main content');
        $this->ViewData('error',"1");
    }

    public function Error()
    {
        //header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->error);
        $this->model->appid = '';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }
}

?>