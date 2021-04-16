<?php
namespace STAR\post;

class response {
	public String $message = 'Post Successful';
	public $object;
	public Bool $error = false;
	public String $errorMessage = '';

	public function __construct(Object $object = null){
        $this->object = is_null($object) ? new \stdClass() : $object;
	}
	
	public function return(String $message = '', String $error = '', int $httpResponseCode = null) {
		if(!empty($error)) {
			$this->error = true;
			$this->errorMessage = $error;
		}
		if(!empty($message))$this->message = $message;
		echo(json_encode($this));
		if(!is_null($httpResponseCode))http_response_code($httpResponseCode);
		exit;
	}
}