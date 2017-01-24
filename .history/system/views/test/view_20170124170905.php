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
        $aout=$this->searchByName($this->array,'_name','l');
		$this->SetValue($this->array,3,'_view','NewValue','l');

		$this->SetName($this->array,1,'_name','_add','l');
		//$this->SetName($this->array,1,'_name','_add','l');
		echo $this->GetIndex($this->array,'_name','two','l');
		echo "<br>";
		echo $this->GetId($this->array,3,'_name','l');
        var_dump($aout);

        var_dump($this->array);

        $aout=$this->searchByName($this->array,'_name','l');
		$aout[$this->GetIndex($this->array,'_view','two','l')]['_view']='cccc';
		var_dump($aout);
    	$rout=$this->reverseItems($aout,$this->array,'l');
    	var_dump($rout);

?>