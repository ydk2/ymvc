<?php

/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-09-26 07:32:35
 */
namespace App\Controllers\JSON;

use \Library\Core\Helper as Helper;


class Langs extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");

        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 3;

        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);


        if (!$this->error) $this->error = 0;
        $this->ViewData('error', $this->error);
        if ($this->error) {
            //$this->Error();
            $this->throwError($this->Error());
        }

        $this->Run();
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
    public function Run()
    {

        if(Helper::Get('getlang')!=''){
            $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT."langs/".Helper::Get('getlang')));
            $content = file_get_contents($filename);
            $this->ViewData('content',$content);
        } else {
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, 404);
        }
        if (!$this->error) $this->error = 0;
        //$this->ViewData('error', $this->error);
        if ($this->error) {
            //$this->Error();
            $this->throwError($this->Error());
        }
    }

    function test($test, $obj)
    {
        //var_dump($obj);
        return $test;
    }

}
function timestamp($date, $slash_time = true, $timezone = 'Europe/London', $expression = "#^\d{2}([^\d]*)\d{2}([^\d]*)\d{4}$#is")
{
    $return = false;
    $_timezone = date_default_timezone_get();
    date_default_timezone_set($timezone);
    if (preg_match($expression, $date, $matches))
        $return = date("Y-m-d " . ($slash_time ? '00:00:00' : "h:i:s"), strtotime(str_replace(array($matches[1], $matches[2]), '-', $date) . ' ' . date("h:i:s")));
    date_default_timezone_set($_timezone);
    return $return;
}
?>