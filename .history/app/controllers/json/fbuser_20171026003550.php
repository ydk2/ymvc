<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\controllers\JSON;

use \Library\Core\Helper as Helper;

class FBUser extends \library\Core\Controller
{
  private $fbuser;

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
    $this->getUser();
        //$this->ViewData('test', HOST);
    if ($this->error == 200) {
      $this->isUser();
    }
    if ($this->error == 530) {
      $this->doRegister();
    }

    header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->error);
    
    if ($this->error && $this->error !== 200 && $this->error !== 530) {
      $this->throwError($this->Error());
    }
  }
  private function doRegister()
  {
    if (Helper::Get('doregister') == 'true') {
      $db = $this->model->db;
    }

  }
  protected function isUser()
  {
    $db = $this->model->db;
    $email = $this->fbuser['email'];
    $ud = array('*');
    $chk = $db->TSelect('accounts', $ud, " WHERE account_email=?", "info@ydk2.tk");
    $this->ViewData('scope', json_encode($chk));
    if ($chk) {
      $this->error = 200;
      $this->ViewData('error', $this->error);
      $this->ViewData('request', json_encode($chk[0]));
    }
    else {
      $this->error = 530;
      $this->ViewData('error', $this->error);
      $this->ViewData('request', json_encode($this->fbuser));


    }
    $this->ViewData('response', json_encode($chk));
  }

  protected function getUser()
  {
        
        //header('X-Frame-Options: GOFORIT');
        //session_start();
        //session_destroy();
    $accessToken = NULL;
    $tokenMetadata = NULL;
    $user = NULL;
        
        //ROOT . 'Library/Facebook/autoload.php'; // change path as needed



    $fb = new \Facebook\Facebook([
      'app_id' => '685193021676229', // Replace {app-id} with your app id
      'app_secret' => 'ab6af93f48b90349149e7d7931fa04d3',
      'default_graph_version' => 'v2.10',
    ]);
        //var_dump($fb);
        //$helper = $fb->getRedirectLoginHelper();
        // Get User ID
    try {
          // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name,email,birthday,location', Helper::Get('token'));
      $user = $response->getGraphUser();
        
        //var_dump($user->asArray());
      $fbuser = $user->asArray();
      if ($fbuser == NULL) {
        $this->error = 400;
        $this->ViewData('error', $this->error);
        $this->ViewData('request', "null");
        $this->ViewData('response', "null");
        $this->ViewData('scope', "null");
      }
      else {
        $this->error = 200;
        $this->fbuser = $fbuser;
        $this->ViewData('error', $this->error);
        $this->ViewData('request', json_encode($fbuser));
        $this->ViewData('response', "null");
        $this->ViewData('scope', "null");
      }
        
        //exit();


    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        //echo 'Graph returned an error: ' . $e->getMessage();
      $this->error = 403;
      $this->ViewData('error', $this->error);
      $this->ViewData('request', "null");
      $this->ViewData('response', "null");
      $this->ViewData('scope', "null");

    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        //echo 'Facebook SDK returned an error: ' . $e->getMessage();
      $this->error = 410;
      $this->ViewData('error', $this->error);
      $this->ViewData('request', "null");
      $this->ViewData('response', "null");
      $this->ViewData('scope', "null");
    } //catch()


  }

  public function Error()
  {
    $this->model->appid = NULL;
    $this->model->scope = 'Error';
    $this->model->request = NULL;
    $this->model->response = 'Something wrong';
    $this->model->error = $this->error;
    $error = $this->View('/app/views/' . $this->model->theme . '/shared/e.json');
    return $error;
  }
}
?>