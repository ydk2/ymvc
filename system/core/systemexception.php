<?php
class SystemException extends Exception {
	
	public function Code() {
		return $this->getCode();
	}
		
	public function Message() {
		return $this->getMessage();
	}

  public function ErrorMessage() {
    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .': <b>'.$this->getMessage().'</b> :'.$this->getCode();
    return $errorMsg;
  }
}
?>