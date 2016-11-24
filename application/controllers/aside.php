<?php
namespace Application\controller;
use \System\core\Router as router;
class aside extends \System\core\controller {
	//    public $model;
	//	public $view;

	public function __construct($model, $view) {
		$this -> access = parent::ACCESS_ANY;
		parent::__construct($model, $view);
		if(router::globals('eview')!=404) {
		$this -> id = (router::get('data')) ? $this -> model -> get_id(router::get('data')) : 0;
		$this -> pid = (router::get('data')) ? $this -> model -> get_pid(router::get('data')) : 0;
		} else {
		$this -> id = 0;
		$this -> pid = 0;
		}
		
	}

	function show_list($data, $parent) {
		$tree = '';

		foreach ($data as $item) {
			if ($item -> parent_id === $parent) {
				$tree .= '<li><a href="' . HOST_URL . '/?view=view&data=' . $item -> path . '">' . $item -> title . '</a>' . PHP_EOL;
				if ($parent > 0) {
				}
				$tree .= "<ul class=\"nav\">" . PHP_EOL;

				$tree .= $this -> show_list($data, $item -> id);
				$tree .= "</ul>";
				$tree .= '</li>' . PHP_EOL;
			}
		}

		return $tree;
	}

	public function build_sorter($key) {
		return function($a, $b) use ($key) {
			return strnatcmp($a -> $key, $b -> $key);
		};
	}

	private function parents($array, $id = 0, $parents = array(), $str_id = 'parent_id') {
		if ($id == 0) {
			foreach ($array as $element) {
				if (($element[$str_id] != 0) && !in_array($element[$str_id], $parents)) {
					$parents[] = $element[$str_id];
				}
			}
		}
		return $parents;
	}

	function media_list($array) {
		$menu_html = '';
		//$menu_html = '<ul class="media-list">'.PHP_EOL;
		if($array){
		foreach ($array as $element) {
			$element['img'] = "https://unsplash.imgix.net/photo-1420708392410-3c593b80d416?w=1024&amp;q=50&amp;fm=jpg&amp;s=db450320d7ee6de66c24c9b0bf2de3c6";
			$menu_html .= '<li class="media">' . PHP_EOL;
			$menu_html .= '<a class="pull-left" href="' . HOST_URL . '/?view=view&data=' . $element['link'] . '">' . PHP_EOL . '<img class="media-object" src="' . $element['img'] . '" height="64" width="64"></a>' . PHP_EOL;
			$menu_html .= '<div class="media-body">' . PHP_EOL;
			$menu_html .= '<h4 class="media-heading">' . $element['title'] . '</h4>' . PHP_EOL;
			$menu_html .= '<p>' . substr($element['content'], 0, MEDIA_LEN) . '</p>' . PHP_EOL;
			$menu_html .= '</li>' . PHP_EOL;
		}
		}
		//$menu_html .= '</ul>'.PHP_EOL;
		return $menu_html;
	}

}
?>