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
		echo $this->GetId($this->array,3,'_type');
        var_dump($aout);

?>