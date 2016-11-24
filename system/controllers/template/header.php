<?php 
namespace System\controller\Template;
class Header extends \System\core\controller
{
//    public $model;
	public $template;

    public function __construct($model,$view){

        $this->template = $view;
		parent::__construct($model, "/templates/$this->template/header");
    }

	public function add_links($links) {
		if (isset($links) && !empty($links)) {
			foreach ($links as $key => $value) {
				
				$this->model->link_rel = $value[0];
				$this->model->link_uri = $value[1];
				$this->model->link_type = $value[2];
				
				$this->show(SVIEW."elements/link");
				
				unset($this->model->link_rel);
				unset($this->model->link_uri);
				unset($this->model->link_type);
			}			
		}	
		
	}
	public function add_scripts($scripts) {
		if (isset($scripts) && !empty($scripts)) {
			foreach ($scripts as $key => $value) {
				
				$this->model->script_type = $value[0];
				$this->model->script_uri = $value[1];
				$this->model->script_str = $value[2];
				
				$this->show(SVIEW."elements/script");
				
				unset($this->model->script_str);
				unset($this->model->script_uri);
				unset($this->model->script_type);
			}			
		}	
		
	}
	public function header_elem() {	
		echo $this->showin(SVIEW."elements/header");
	}
	public function head_elem() {	
		echo $this->showin(SVIEW."elements/head");
	}
	public function footer_elem() {	
		echo $this->showin(SVIEW."elements/footer");
	}

}
?>