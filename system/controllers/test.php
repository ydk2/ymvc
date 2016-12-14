<?php

class test extends XSLRender {

	public function onInit() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);
		$this->SetModel(SYS.M.'model');
		//$this->Inc(SYS.M.'model');
		$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		//$this -> set_changes();
		//$db = new Model(TRUE);
		//$db->import = TRUE;
		//var_dump($db);
	}
	public function onRun()
	{
		$this->model->import = TRUE;
		if(isset($this->model->data)){
		foreach ($this->model->data as $key => $value) {
			# code...
		}}
		//$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		//$this -> set_changes();
		//var_dump(get_called_class());
		//var_dump(debug_backtrace());
	}
	public function showin($view='')
	{
		//$t = new Menus($view);
		//return $this->View();
	}
	function lista($data, $parent = '') {
		$tree = '<ul>';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] == $parent) {
				$tree .= '<li>' . $item['title'] . ':' . $parent . ' @:' . $item['link'];

				$tree .= call_user_func_array(array($this, 'lista'), array($data, $item['title']));
				//call_user_func('show_list',$data, $i);

				$tree .= '</li>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "</ul>";
		return $tree;
	}

	function edit_menu($data, $parent = '') {
		$tree = '';
		$i = 1;
		if($data){
		foreach ($data as $item) {
				$tree .= '<tr>';
				$tree .= "<td>" . $this -> change_pos($data, $i, $i) . "</td>";
				//$tree .= '<label for="title">Change Title</label>';
				$tree .= '<td><input class="form-control" type="text" id="title" name="update_menu[' . $i . '][title]" value="' . $item['title'] . '"' . "></td>";
				$tree .= '<input class="form-control" type="hidden" id="ids" name="update_menu[' . $i . '][id]" value="' . $item['id'] . '"' . ">";
				$tree .= '<td><input class="form-control" type="text" id="link" name="update_menu[' . $i . '][link]" value="' . $item['link'] . '"' . "></td>";
				$tree .= "<td>" . $this -> change_parent($data, $i, $item['title'], $item['parent']) . "</td>";
				$tree .= '<td><input class="form-control" type="text" id="access" name="update_menu[' . $i . '][access]" value="' . $item['access'] . '"' . "></td>";
				$tree .= '<td><a class="btn btn-danger" href="' . HOST_URL . '/?menus=menus/edit&action=delete_item&item=' . $item['id'] . '&data='.$this->groups.'">Delete entry</a></td>';
				//$tree .= call_user_func_array(array($this, 'edit_menu'), array($data, $i));
				$tree .= "</tr>\n";
			$i++;
		}
		} 
		return $tree;
	}

	function change_pos($data, $key, $selected = null) {
		$tree = "<select class='form-control' name='update_menu[$key][pos]'>";
		$i = 1;
		foreach ($data as $item) {
			$tree .= '<option value="' . $i . '"';
			if ($selected == $i) {
				$tree .= 'selected="selected"';
			}
			$tree .= ">$i</option>";
			$i++;
		}
		$tree .= "</select>\n";
		return $tree;
	}

	function change_parent($data,  $key,$title, $selected = null) {
		$tree = "<select class='form-control' name='update_menu[$key][parent]'>";
		$tree .= '<option value="">no parent</option>';
		foreach ($data as $item) {
			if ($item['title'] != $title) {
				$tree .= '<option value="' . $item['title'] . '"';
				if ($selected == $item['title']) {
					$tree .= 'selected="selected"';
				}
				$tree .= ">" . $item['title'] . "</option>";
			}
		}
		$tree .= "</select>\n";
		return $tree;
	}

	function update_menu($data, $parent = '') {
		//$tree = array();
		$tree = '';
		
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] == $parent) {
				$this -> model -> update_menu_items($i, $parent, $item['title'], $item['link'],$item['access'],$item['id'], $this->groups);
				call_user_func_array(array($this, 'update_menu'), array($data, $item['title']));
			}
			$i++;
		}

		return $tree;
	}

	public function set_changes() {
		$this -> pages = $this -> model -> get_menu($this->groups);
		$this -> alert_header = "Menu management";
		$this -> alert_string = "Choose action";
		$this -> alert_link = "menus=menus/edit";
		$this -> actions = $this -> showin(SYS.V . "menus/help");
		switch (Helper::get('action')) {
			case 'adds' :
				$this -> alert_link = "menus=menus/edit&action=adds";
				$this -> actions = $this -> showin(SYS.V . "menus/edit");
				$this -> adds();
				break;
			case 'edit' :
				$this -> alert_link = "menus=menus/edit&action=edit";
				$this->change();
				$this -> actions = $this -> showin(SYS.V . "menus/edit");
				break;
			case 'delete_item' :
				$item = Helper::get('item');
				$del = $this -> model -> db -> base -> prepare('DELETE FROM '.DBPREFIX.'menus WHERE id = ? AND lang=?');
				
				$del -> execute(array($item, Helper::session('locale')));
				$this -> alert_header = "Menu item has been deleted";
				$this -> alert_string = "Go to form";
				$this -> alert_link = "menus=menus/edit&action=edit";
				$this -> actions = "";//$this -> showin(SYS.V . "menus/message");
				break;
		}

		$this -> action = $this -> showin(SYS.V . "menus/choose");
	}

	public function adds() {
		if (Helper::post('add_menu')) :

			$item_title = Helper::post('item_title');
			$item_link = Helper::post('item_link');
			if ($item_link != '' && $item_title != '') {
				switch ($this -> model -> add_menu_item($item_title, $item_link, $this->groups)) {

					case 1068 :
						$this -> alert_header = "Menu item cannot be added";
						$this -> alert_string = "Go to form";
						$this -> alert_link = "menus=menus/edit&action=adds";
						//$this -> actions = $this -> showin(SYS.V . "menus/message");
						break;
					case 1067 :
						$this -> alert_header = "General Error!!!";
						$this -> alert_string = "Go to form";
						$this -> alert_link = "menus=menus/edit&action=adds";
						//$this -> actions = $this -> showin(SYS.V . "menus/message");
						break;
					case 1069 :
						$this -> alert_header = "Menu item was added";
						$this -> alert_string = "Reload to see changes";
						$this -> alert_link = "menus=menus/edit&action=adds";
						//$this -> actions = $this -> showin(SYS.V . "menus/message");
						break;
					case 0 :
						$this -> alert_header = "Menu item was added";
						$this -> alert_string = "Reload to see changes";
						$this -> alert_link = "menus=menus/edit&action=adds";
						//$this -> actions = $this -> showin(SYS.V . "menus/message");
						break;
					default :
						break;
				}

			} else {
				$this -> alert_header = "ERROR!!!";
				$this -> alert_string = "Form cannot be empty";
				$this -> alert_link = "menus=menus/edit&action=adds";
				//$this -> actions = $this -> showin(SYS.V . "menus/message");
			}

		endif;
	}

	public function change() {
		if (Helper::post('update_menu')) :
		$input = array();
		foreach (Helper::post('update_menu') as $key => $value) {
			$input[$key]['id'] = intval($value['id']);
			$input[$key]['pos'] = intval($value['pos']);
			$input[$key]['title'] = $value['title'];
			$input[$key]['parent'] = $value['parent'];
			$input[$key]['link'] = $value['link'];
			$input[$key]['access'] = $value['access'];
		}
		//usort($input, $this->model->build_sorter('pos'));
		sksort($input,'pos');
		//$del = $this->model->db -> base -> query("DELETE FROM menus WHERE id > 0");
		$this -> update_menu($input);
		endif;
	}

	public function onException(){
		//echo "";
		if($this->error == 20503) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Try get more privilages').' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

}
?>