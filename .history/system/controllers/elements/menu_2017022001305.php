<?php

class Menu extends PHPRender {

    public static function Config() {
        return array(
        'title'=>'menus show',
        'access_groups'=>array(),
        'view'=>"",
        'access_mode'=>0,
        'model'=>NULL
        );
    }
	public function Init() {
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array();
		$this->current_group = '';
		$this->AccessMode(1);
		$this->SetModel(SYS.M.'systemdata');
		$this->only_registered(FALSE);
	}
	public function Run(){
		//$this->groups=$this->model->groups;
		$this->groups=Config::$data['layouts']['current'];
        $this->datalist=$this->model->getData(Config::$data['menu_data']);
        $this->items = $this->model->itemsData($this->datalist,$this->groups,'group');
	}
	

    public function navmenu($data, $parent = '') {

        $tree = '<ul class="'.$this->ul.'">';

        foreach ($data as $item) {
            if ($item['parent'] === $parent) {
                $tree .= '<li class="'.$this->li.'">'. PHP_EOL;
                $tree .= '<a href="'.htmlspecialchars($item['link']).'">' .$item['title']. PHP_EOL;

                $tree .= call_user_func_array(array($this, __FUNCTION__), array($data,strval($item['id'])));

                $tree .= '</a>' . PHP_EOL;
                $tree .= '</li>' . PHP_EOL;
            }
        }
        $tree .= "</ul>";
        return $tree;
    }

    private function parents($array, $parents = array()){
        foreach ($array as $element){
            if (($element['parent'] != '') && !in_array('parent',$parents)){
                $parents[] = $element['parent'];
            }
        }
		return  $parents;
    }

    function navtabs($array,$parent = '',$parents = array()){
		$parents = $this->parents($array,$parents);
        $menu_html = '';
        foreach($array as $element)
        {
            if($element['parent']==$parent)
            {
                if(in_array($element['id'],$parents))
                {
                	if (!filter_var($element['link'], FILTER_VALIDATE_URL)) {
						$url = HOST_URL.$element['link'];
					} else {
						$url = $element['link'];
					}
                    $menu_html .= '<li class="dropdown">'.PHP_EOL;
                    $menu_html .= '<a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown" role="menu-item" aria-expanded="true">'.Intl::_($element['title']).' <span class="caret"></span></a>'.PHP_EOL;
                	$menu_html .= '<ul class="dropdown-menu sub-menu" role="menu-item">'.PHP_EOL;
					$menu_html .= '<li>'.PHP_EOL;
					$menu_html .= '<a href="'.$url.'">' . Intl::_($element['title']) . '</a>'.PHP_EOL;
					$menu_html .= '</li>'.PHP_EOL;
                    $menu_html .= call_user_func_array(array($this, __FUNCTION__), array($array, strval($element['id']), $parents));
                    $menu_html .= '</ul>'.PHP_EOL;
				}
                else {
                	if (!filter_var($element['link'], FILTER_VALIDATE_URL)) {
						$url = HOST_URL.$element['link'];
					} else {
						$url = $element['link'];
					}
                    $menu_html .= '<li>'.PHP_EOL;
                    $menu_html .= '<a href="'.$url. '">' . Intl::_($element['title']) . '</a>'.PHP_EOL;
                }
                $menu_html .= '</li>'.PHP_EOL;
            }

        }
        return $menu_html;
    }


	public function Exception(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

}
?>