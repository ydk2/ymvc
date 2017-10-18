<?php 
class Theme
{
//    public $model;
public function Init($data)
{
        $data->tag = 'div';
        if(isset($_GET['register'.S.'signin'])){

            $data->current_group='signin';
        }
        if(isset($_GET['login'.S.'form'])){
            $data->current_group='login';
        }

        if(isset($_GET['appid']) && isset($_GET['action']) && $_GET['action'] != ""){
            $data->current_group='appid';
            $data->tag = null;
        }
        if($data->current_group=='any' || $data->current_group=='user'){
            $data->tag = null;
        }

}

}
?>