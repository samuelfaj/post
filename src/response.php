<?php
namespace STAR\post;

use STAR\post\message;

function SamUtf8ize($data) {
	if (is_array($data)) {
		foreach ($data as $key => $value) {
			$data[$key] = utf8ize($value);
		}
	} elseif (is_object($data)) {
		foreach ($data as $key => $value) {
			$data->$key = utf8ize($value);
		}
	} elseif (is_string($data)) {
		return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
	}
	return $data;
}

class response {
	public string $message = 'Post Successful';
	public $object;
	public array $array;
	public bool $error = false;
	public string $errorMessage = '';
	public array $messages = [];
	public ?int $time = null;

	public function __construct(Object $object = null){
        $this->object = is_null($object) ? new \stdClass() : $object;
	}

	public function addMessage(
		$text = '',
		$error = false,
		$type = 'toast'
	) : void {
		$msg = new message();
		$msg->text = $text;
		$msg->error = $error;
		$msg->type = $type;
		$this->messages[] = $msg;
	}
	
	public function return(String $message = '', String $error = '', int $httpResponseCode = null) {
		if(!empty($error)) {
			$this->error = true;
			$this->errorMessage = $error;
		}
		if(!empty($message))$this->message = $message;

		echo(json_encode(SamUtf8ize($this)));
		if(!is_null($httpResponseCode))http_response_code($httpResponseCode);
		exit;
	}
}
