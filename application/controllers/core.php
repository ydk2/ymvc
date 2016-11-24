<?php
namespace application\controller;
use \System\core\Controller as controller;
class core extends controller
{
//    public $model;
//	public $view;

    public function __construct($model,$view){
    	/*
    	$this->name_model = $model;
        $this->model = new $model();
        $this->view = $view;
		 * 
		 */
		parent::__construct($model, $view);
		
	$this->c='azertuiop';
    }
	public function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a->$key, $b->$key);
    };
	}
private function parents($array,$id = 0, $parents = array(),$str_id='parent')
{
	        if($id==0)
        {
            foreach ($array as $element)
            {
                if (($element[$str_id.'_id'] != 0) && !in_array($element[$str_id.'_id'],$parents))
                {
                    $parents[] = $element[$str_id.'_id'];
                }
            }
        }
		return  $parents;
}

	function html_menu($array,$parent_id = 0,$parents = array())
    {
		$parents = $this->parents($array,$parent_id,$parents);
        $menu_html = '';
        foreach($array as $element)
        {
            if($element['parent_id']==$parent_id)
            {
                $menu_html .= '<li><a href="'.HOST_URL.'/?view=view&data='.$element['url'].'">'.$element[ 'title'].'</a>'.PHP_EOL;
                if(in_array($element['id'],$parents))
                {
                    $menu_html .= '<ul class="nav">'.PHP_EOL;
                    $menu_html .= $this->html_menu($array, $element['id'], $parents);
                    $menu_html .= '</ul>'.PHP_EOL;
                }
                $menu_html .= '</li>'.PHP_EOL;
            }
        }
        $menu_html .= '';
        return $menu_html;
    }
}
?>