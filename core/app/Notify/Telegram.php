<?php

namespace App\Notify;

use App\Lib\CurlRequest;
use App\Notify\NotifyProcess;

class Telegram extends NotifyProcess{

    /**
    * Username of receiver
    *
    * @var string
    */
	public $telegramUsername;


    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'telegram_status';
		$this->body = 'telegram_body';
		$this->globalTemplate = 'telegram_body';
		$this->notifyConfig = 'telegram_config';
	}


    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){

		//get message from parent
		$message = $this->getMessage();
		if ($this->setting->tn && $message && $this->telegramUsername) {
			try{
				$telegramUserUrl = "https://api.telegram.org/bot". $this->setting->telegram_config->bot_token ."/getUpdates";
	            $results = CurlRequest::curlContent($telegramUserUrl);
	            $jsonUser = json_decode($results);
	            $teleUsers = array();
	            foreach($jsonUser->result as $rs){
	                $username =  @$rs->message->from->username;
	                $chat_id =  @$rs->message->from->id;
	                $teleUsers[$username] = $chat_id;
	            }
	            if (!array_key_exists($this->telegramUsername, $teleUsers)) {
	            	throw new \Exception("$this->telegramUsername not found in telegram subscribers list");
	            }

	            $chatId = $teleUsers[$this->telegramUsername];
				$sendUrl = "https://api.telegram.org/bot". $this->setting->telegram_config->bot_token ."/sendMessage?chat_id=". $chatId .'&text='. urlencode(strip_tags($message));
				CurlRequest::curlContent($sendUrl);
				$this->createLog('telegram');
			}catch(\Exception $e){
				$this->createErrorLog($e->getMessage());
				session()->flash('telegram_error',$e->getMessage());
			}
		}
	}


    /**
    * Configure some properties
    *
    * @return void
    */
	protected function prevConfiguration(){
		//Check If User
		if ($this->user) {
			$this->telegramUsername = $this->user->telegram_username;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->telegramUsername;
	}
}
