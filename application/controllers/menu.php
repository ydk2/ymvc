<?php
namespace Application\controller;
use \System\helpers\Intl as Intl;
class Menu extends \System\core\controller {
	//    public $model;
	//	public $view;

	public function __construct($model, $view) {

		parent::__construct($model, $view);
		Intl::$strings=$this->model->lang_strings;
	}

	function show_list($data, $parent=0) {
		$tree = '';
		
		foreach ($data as $item) {
			if ($item -> parent === $parent) {
				$tree .= '<li><a href="'.HOST_URL.'/?view=view&data=' . $item -> path . '">' . $item -> title . '</a>'.PHP_EOL;
				if($parent > 0){ }
				$tree .= "<ul class=\"nav\">".PHP_EOL;
				
				$tree .= $this->show_list($data, $item -> id);
				$tree .= "</ul>";
				$tree .= '</li>'.PHP_EOL;
			}
		}
		
		return $tree;
	}
	
	public function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
	}

function ordered_list($array,$parent = 0)
{
  $temp_array = array();
  foreach($array as $element)
  {
    if ($element['parent'] == $parent)
    {
      $element['subs'] = $this->ordered_list($array, $element['id']);
      $temp_array[] = $element;
    }
  }
  return $temp_array;
}
//$the_menu = ordered_list($menu_items);
//echo '<pre>'.PHP_EOL;
//print_r($a);
//print_r($menu_items);
//echo '</pre>'.PHP_EOL;
private function parents($array,$id = '', $parents = array(),$str_id='parent')
{
	    if($id=='')
        {
            foreach ($array as $element)
            {
                if (($element[$str_id] != '') && !in_array($element[$str_id],$parents))
                {
                    $parents[] = $element[$str_id];
                }
            }
        }
		return  $parents;
}

function html_menu($array,$parent = 0,$parents = array())
    {
		$parents = $this->parents($array,$parent,$parents);
        $menu_html = '';
        foreach($array as $element)
        {
            if($element['parent']==$parent)
            {
            	if (!filter_var($element['link'], FILTER_VALIDATE_URL)) {
						$url = HOST_URL.'/?view=view&data='.$element['link'];
				} else {
						$url = $element['link'];
				}
                $menu_html .= '<li><a href="'.$url.'">'.$element[ 'title'].'</a>'.PHP_EOL;
                if(in_array($element['title'],$parents))
                {
                    $menu_html .= '<ul class="nav">'.PHP_EOL;
                    $menu_html .= $this->html_menu($array, $element['title'], $parents);
                    $menu_html .= '</ul>'.PHP_EOL;
                }
                $menu_html .= '</li>'.PHP_EOL;
            }
        }
        $menu_html .= '';
        return $menu_html;
    }

//echo '<nav>'.PHP_EOL;
//echo '<ul id="nav" >'.PHP_EOL;
//echo $the_menu;
//echo '</ul>'.PHP_EOL;
//echo '<nav>'.PHP_EOL;
function bootstrap_menu($array,$parent = '',$parents = array())
    {
		$parents = $this->parents($array,$parent,$parents);
        $menu_html = '';
        foreach($array as $element)
        {
        	if($element['access'] >= $this -> accessed){
            if($element['parent']==$parent)
            {
                if(in_array($element['title'],$parents))
                {
                	if (!filter_var($element['link'], FILTER_VALIDATE_URL)) {
						$url = HOST_URL.'/?index=page&data='.$element['link'];
					} else {
						$url = $element['link'];
					}
                    $menu_html .= '<li class="dropdown">'.PHP_EOL;
                    $menu_html .= '<a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown" role="menu-item" aria-expanded="true">'.Intl::_($element['title']).' <span class="caret"></span></a>'.PHP_EOL;
                	$menu_html .= '<ul class="dropdown-menu sub-menu" role="menu-item">'.PHP_EOL;
					$menu_html .= '<li>'.PHP_EOL;
					$menu_html .= '<a href="'.$url.'">' . Intl::_($element['title']) . '</a>'.PHP_EOL;
					$menu_html .= '</li>'.PHP_EOL;
                    $menu_html .= $this->bootstrap_menu($array, $element['title'], $parents);
                    $menu_html .= '</ul>'.PHP_EOL;
				}
                else {
                	if (!filter_var($element['link'], FILTER_VALIDATE_URL)) {
						$url = HOST_URL.'/?index=page&data='.$element['link'];
					} else {
						$url = $element['link'];
					}
                    $menu_html .= '<li>'.PHP_EOL;
                    $menu_html .= '<a href="'.$url. '">' . Intl::_($element['title']) . '</a>'.PHP_EOL;
                }
                $menu_html .= '</li>'.PHP_EOL;
            }
            }
        }
        return $menu_html;
    }

}
?>