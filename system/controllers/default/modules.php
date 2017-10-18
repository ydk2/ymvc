<?php
class Modules extends Render {

	public function Init(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(SYS.LANGS.$this->name);
		$langs = Intl::available_locales(Intl::PO);
		Intl::po_locale_plural(Helper::Session('locale'),$this->name);
		
		//if(!empty($this->items))
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data>'.$this->menulist($this -> items).'</data>', null, false);
		$this->ViewData('list', "" );
		$list = $this->data->list->addChild('items',Intl::_p('Load XSL',$this->name));
		$list->addAttribute('href', HOST_URL."?load=xsl");
		return TRUE;
	}

	public function End(){
		// call after render view
		return TRUE;
	}

	public function Destruct(){
		// call in __destructor
		return TRUE;
	}


	public function Exception(){
			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', $this->emessage);
			$this->exception->ViewData('alert',"<b>Please check loader options</b> Catch error:  ");
			$this->exception->ViewData('error', $this->error);
		//return TRUE;
	}
	
	public function Run(){

	}

	function menulist($data, $parent = '') {
		// <item id="0" name="1">
		$tree = '';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] === $parent) {
				$tree .= '<item id="'.$item['pos'].'" url="'.htmlspecialchars($item['link']).'" name="'.$item['title'].'">' . PHP_EOL;

				$tree .= call_user_func_array(array($this, 'menulist'), array($data, strval($item['pos'])));
				//call_user_func('show_list',$data, $i);

				$tree .= '</item>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "";
		return $tree;
	}
	public function module($array,$mode=SYS){
		$this->ViewData('sections', '');
		foreach ($array as $key => $value) {
				$col = $this->data->layout->addChild('views', htmlspecialchars( Loader::get_restricted_view($mode.C.$key,$mode.V.$value[0])));
				$col->addAttribute('style', $value[3]);
				$col->addAttribute('class', $value[2]);
				$col->addAttribute('id', $value[1]);	
		}
	}
}
?>