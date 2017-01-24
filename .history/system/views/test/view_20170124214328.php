<?php

       // $aout=$this->searchByNameValue($this->array,'_name','three','l');
        //var_dump($this->model);
        //$aout[4][count($data)+1]['_view'] = 'four';
        // $this->setValue($aout,3,'_view','cccc');
       //  $this->setValue($aout,3,'_name','cccc');
       // unset($aout[3][$this->GetId($aout,3,'_type')]);
       // $aout[4][$this->GetFreeId($this->array,$aout,'l')+1]['_name'] = 'four';
       // $rout=$this->reverseItems($aout,'l');
        //var_dump($rout);
		$insert = false;
		$table='layouts';
		$gprx = 'l';
		if($insert){
		foreach ($this->array as $items) {
			$this->model->add_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
		$this->array = $this->model->get_entries($table,$gprx);
        $aout=$this->model->searchByName($this->array,'_name','l');
		$this->model->SetValue($this->array,3,'_view','NewValue','l');

		$this->model->SetName($this->array,1,'_name','_add','l');
		//$this->SetName($this->array,1,'_name','_add','l');
		echo $this->model->GetIdx($this->array,'_name','two','l');
		echo "<br>";
		echo $this->model->GetId($this->array,3,'_name','l');
        //var_dump($aout);

        //var_dump($this->array);

        $aout=$this->model->searchByName($this->array,'_name','l');
		$aout[$this->model->GetIdx($this->array,'_view','two','l')]['_view']='cccc';
		var_dump($aout);
    	$rout=$this->model->reverseItems($aout,$this->array,'l');
    	var_dump($rout);
    	//var_dump($this->model->createTable('layouts','main'));
		$update = true;
		if($update){
		foreach ($rout as $items) {
			$this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$items['gprx']);
		}
		}
?>