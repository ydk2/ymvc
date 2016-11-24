<?php
namespace Application\controller;
use \System\core\Router as router;
use \System\helpers\Intl as Intl;
class Pages extends \System\core\controller {
	//    public $model;
	//	public $view;

	public function __construct($model, $view) {

		parent::__construct($model, $view);
		$this->model->page_title="Error 404!!!";
		$this->c='rrr';
		if(router::get('page')):
		if(!$this->model->get_page(router::get('page'))) {
			router::globalsset('eview',404);
			
			$this->error = "Page not exist!"; //$this->showin(SVIEW."404");
			$this->otherview = SVIEW.'404';
		} else {
			$this->page=$this->model->get_page(router::get('page'));
		}
		else:
		$this->page=$this->model->get_first();	
		endif;
	}


	
	public function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a->$key, $b->$key);
    };
	}



private function parents($array,$id = 0, $parents = array(),$str_id='parent_id')
{
	        if($id==0)
        {
            foreach ($array as $element)
            {
                if (($element[$str_id] != 0) && !in_array($element[$str_id],$parents))
                {
                    $parents[] = $element[$str_id];
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
                $menu_html .= '<li><a href="'.HOST_URL.'/?index=view&page='.$element['link'].'">'.$element[ 'title'].'</a>'.PHP_EOL;
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