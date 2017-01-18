<?php
error_reporting(E_ALL);
class MngMenus extends PHPRender {

	public function onInit() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_EDITOR);
		//Helper::Session_Set('user_access',Helper::Get('access'));
		$this->access_groups = array('admin','editor');
		$this->current_group = Helper::Session('user_role');
		$this->AccessMode(2);
		$this->global_access = Helper::Session('user_access');
		$this->SetModel(SYS.M.'menudata');
		if(Helper::Get('admin'.S.'mngmenus') == '')
		$this->SetView(SYS.V . "menus:choose");
		$this->Inc(SYS.M.'model');
		$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		(Helper::get('lang'))?Helper::session_set('lang',Helper::get('lang')):NULL;
		//$this -> set_changes();
		//$db = new Model(TRUE);
		//$db->import = TRUE;
		//var_dump($db);
		$this->only_registered(FALSE);
	}
	public function onRun()
	{
		//$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		$this -> set_changes();
		//var_dump(get_called_class());
		//var_dump(debug_backtrace());
	}
	public function showin($view='')
	{
		
	}
	function menulist($data, $parent = '') {
		$tree = '<ul>';
		$i = 1;
		
		foreach ($data as $item) {
			if ($item['parent'] === $parent) {
				$tree .= '<li><a href="'.$item['link'].'">' . $item['title'].'</a>';

				$tree .= call_user_func_array(array($this, 'menulist'), array($data, strval($item['pos'])));
				//call_user_func('show_list',$data, $i);

				$tree .= '</li>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "</ul>";
		return $tree;
	}

	function menugroups() {
		$data = $this->model->get_menu_groups();
		$tree = '<ul class="list-group">';		
		foreach ($data as $item) {	
			$tree .= '<li class="list-group-item"><a href="?admin'.S.'mngmenus&data='.$item.'">' . $item.'</a>';
			$tree .= '</li>' . PHP_EOL;
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
				$tree .= '<td><a class="btn btn-danger" href="' . HOST_URL . '?admin'.S.'mngmenus&action=delete_item&item=' . $item['id'] . '&data='.$this->groups.'">Delete entry</a></td>';
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
				$tree .= ' selected="selected"';
			}
			$tree .= ">$i</option>";
			$i++;
		}
		$tree .= "</select>\n";
		return $tree;
	}

	function change_parent($data, $key, $title, $selected = null) {
		$tree = "<select class='form-control' name='update_menu[$key][parent]'>";
		$tree .= '<option value="">no parent</option>';
		foreach ($data as $item) {
			if ($item['title'] != $title) {
				$tree .= '<option value="' . $item['pos']. '"';
				if ($selected  == $item['pos']) {
					$tree .= ' selected="selected"';
				}
				$tree .= ">" . $item['title']. "</option>";
			}
		}
		$tree .= "</select>\n";
		return $tree;
	}

	function update_menu($data, $parent = '') {
		//$tree = array();
		$tree = 0;
		
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] == $parent) {
				$tree = $this -> model -> update_menu_items($i, $parent, $item['title'], $item['link'],$item['access'],$item['id'], $this->groups);
				call_user_func_array(array($this, 'update_menu'), array($data, $item['pos']));
			}
			$i++;
		}

		return $tree;
	}

	public function set_changes() {
		$this -> pages = $this -> model -> get_menu($this->groups);
		$this -> alert_header = "Menu management";
		$this -> alert_string = "Choose action";
		$this -> alert_link = "menus";
		switch (Helper::get('action')) {
			case 'adds' :
				$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
				$this->SetView(SYS.V . "menus/adds");
				$this -> adds();
				break;
			case 'edit' :
				if($this -> pages){
				$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
				$this->SetView(SYS.V . "menus/edit");
				$this->change();
				} else {
				$this -> alert_link = "admin'.S.'mngmenus&action=adds&data=".$this->groups;
				$this->SetView(SYS.V . "menus/adds");
				$this -> adds();	
				}
				break;
			case 'delete_item' :
				$item = Helper::get('item');
				//$del = $this -> model -> db -> prepare('DELETE FROM '.DBPREFIX.'menus WHERE id=? AND lang=?');
				//$del -> execute(array($item, $this->model->lang_menu));
				if($this->model->delete_menu_item($item)==0){
				$this -> alert_header = "Menu item has been deleted";
				$this -> alert_string = "Go to form";
				$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
				} else {
				$this -> alert_header = "Menu item will not deleted";
				$this -> alert_string = "Go to form";
				$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
				}
				$this->SetView(SYS.V . "menus/message");
				break;
		}

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
						$this -> alert_link = "admin'.S.'mngmenus&action=adds&data=".$this->groups;
						$this->SetView(SYS.V . "menus/message");
						break;
					case 1067 :
						$this -> alert_header = "General Error!!!";
						$this -> alert_string = "Go to form";
						$this -> alert_link = "admin'.S.'mngmenus&action=adds&data=".$this->groups;
						$this->SetView(SYS.V . "menus/message");
						break;
					case 1069 :
						$this -> alert_header = "Menu item was added";
						$this -> alert_string = "Reload to see changes";
						$this -> alert_link = "admin'.S.'mngmenus&action=adds&data=".$this->groups;
						$this->SetView(SYS.V . "menus/message");
						break;
					case 0 :
						$this -> alert_header = "Menu item was added";
						$this -> alert_string = "Reload to see changes";
						$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
						$this->SetView(SYS.V . "menus/message");
						break;
					default :
						break;
				}

			} else {
				$this -> alert_header = "ERROR!!!";
				$this -> alert_string = "Form cannot be empty";
				$this -> alert_link = "admin'.S.'mngmenus&action=adds&data=".$this->groups;
				$this->SetView(SYS.V . "menus/message");
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
		$this->sksort($input,'pos');
		//$del = $this->model->db -> base -> query("DELETE FROM menus WHERE id > 0");
		$this -> update_menu($input);

		$this -> alert_header = "Menu has been updated";
		$this -> alert_string = "Go to form to see changes";
		$this -> alert_link = "admin'.S.'mngmenus&action=edit&data=".$this->groups;
		$this->SetView(SYS.V . "menus/message");
		endif;
	}

	public function onException(){
		//echo "";
		if($this->error == 20503 && !isset(Config::$data['tmp_data']['login'])) return $this->show_login();
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','yes');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}
	public function show_login()
	{
		//return Loader::get_module_view(SYS.C.'admin'.S.'account',null);
		$login=$this->NewControllerA(SYS.C.'admin'.S.'account');
		return $login->View();
		//return "<div class='row'><h3>You need login</h3><a class='btn btn-info' href='?admin"."'>Login</a></div>";
	}

}
?>