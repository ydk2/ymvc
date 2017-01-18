<?php
class GetTime extends XSLRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(ROOT.SYS.LANGS.'time');
		$langs = Intl::available_locales(Intl::PHP);
		$this->langs = $langs;
			if(!Helper::Session('locale'))
				Helper::Session_Set('locale',Intl::get_browser_lang($langs));
				Intl::load_locale_simple(Helper::Session('locale'),'time');

		
		$this->model = new StdClass;
		$this->time[1]=get_time();
		$this->model->cpu = round(cpu_get_usage(),2);
		$this->model->mem = convert(memory_get_usage());
		$this->model->time = get_time_exec(Config::$data['time'],$this->time[1]);
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}
//Intl::_(,'time')
	public function onRun($model = NULL){
		$this->SetView(SYS.V.'time');
		$this->ViewData('time', $this->model->time.Intl::_(' us','time'));
		$this->ViewData('message', Intl::_(" Exec script time: ",'time') );
		$this->ViewData('cpu', Intl::_(" Used CPU: ",'time') .$this->model->cpu);
		$this->ViewData('memory', Intl::_(" Used memory: ",'time') .$this->model->mem);
//	if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'errors');
	}	
}
?>