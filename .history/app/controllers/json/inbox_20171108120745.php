<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\controllers\JSON;

use \Library\Core\Helper as Helper;

class Inbox extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->db = $this->model->db;

        $this->auth = $this->model->auth;

        if (isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if (isset($this->model->uid)) $this->uid = $this->model->uid;
        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);

        //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error > 0 && $this->auth->error !== 200) $this->error = 501;
        if ($this->error && $this->auth->error !== 200) {
            $this->throwError($this->Error());
        }

        $this->Run();
    }

    public function Run()
    {
        $data = array(
            'msgid' => Helper::Post('msgid'),
            'code' => Helper::Post('code')
        );
        $error = 200;
        $scope = ['id', 'account_name', 'account_email', 'account_share', 'account_role'];
        //$this->auth->scope = $scope;

        $this->ViewData('scope', json_encode($this->auth->scope));
        $this->ViewData('request', '""');
        //$this->auth->response();

        $this->update();

        $this->ViewData('error', $error);
        //
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(__FILE__)) . ' GMT', true, $this->auth->error);
    }

    private function onChange()
    {
        // SELECT rows, modified FROM information_schema.innodb_table_stats WHERE table_schema='db' AND table_name='table'
        // SELECT rows_changed FROM information_schema.table_statistics WHERE table_schema = 'mydb' AND table_name='mytable';
        // SELECT table_schema,table_name,update_time FROM information_schema.tables WHERE update_time > (NOW() - INTERVAL 5 MINUTE);
        // SELECT `AUTO_INCREMENT` FROM `information_schema`.`tables` WHERE `table_schema` = DATABASE() AND `table_name` = 'YOUR_TABLE';

        $check = $this->model->db->TSelect('information_schema.tables', ['AUTO_INCREMENT', 'update_time', 'table_name', 'table_schema'], "WHERE update_time > (NOW() - INTERVAL 5 MINUTE) AND table_schema=DATABASE() AND table_name='accounts_msg'");
        $checknew = $this->model->db->TSelect('information_schema.tables', ['AUTO_INCREMENT']);
        $checknew = FALSE;

        if ($check || $checknew) {
            return TRUE;
        }
        else {
            return FALSE;
        }


    }

    private function update()
    {
        $appid = Helper::Post('appid');
        $msgid = $this->auth->request['id'] . ',' . time();
        $for_id = $this->auth->request['id'];
        $from_id = $this->auth->request['id'];

        $msg = $this->db->TSelect('accounts_msg', ['*'], " WHERE for_id<>? AND from_id<>? AND status=0 ORDER BY mtime DESC", [$for_id, $from_id]);
        $readed = $this->db->TSelect('accounts_msg', ['*'], " WHERE for_id=? AND from_id<>? ORDER BY mtime DESC", [$for_id, $from_id]);

        $unread = array();
        $all = array();
        //$i = 0;
        foreach ($msg as $k => $base) {
            if (!empty($readed)) {
                foreach ($readed as $current) {
                # code...
                    if ($base['msgid'] == $current['msgid']) {
                        $all[] = $current;
                    } else {
                        $unread[] = $base;
                    }
                }
            } else {
                $unread[] = $base;
            }
        }
        foreach ($all as $item) {
            $unread[] = $item;
        }
        $error = 0;
        if (empty($unread)) {
            $this->ViewData('response', 'false');
        }
        else {
            $this->ViewData('response', json_encode($unread));
        }



    }

    public function Error()
    {
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(__FILE__)) . ' GMT', true, $this->error);
        $this->model->appid = '';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->auth->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e.json');
        return $error;
    }
}
?>