<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

use Tracy\Debugger;
use Tracy\ILogger;

class Logger extends \Tracy\Logger{

	/** @var string */
	private $hook;

	/** @var IMessageFactory */
	private $messageFactory;

	/** @var int */
	private $timeout;


	public function __construct(string $hook, IMessageFactory $messageFactory, int $timeout){
		parent::__construct(Debugger::$logDirectory, Debugger::$email, Debugger::getBlueScreen());
		$this->hook = $hook;
		$this->messageFactory = $messageFactory;
		$this->timeout = $timeout;
	}

	/**
	 * @inheritdoc
	 */
	public function log($value, $priority = self::INFO):?string{
		$logFile = parent::log($value, $priority);
		if($logFile){
			if($value instanceof \Throwable){
				/** @var \Throwable $value */
				$message = $value->getMessage();
				$file = Formatter::bold('File') . PHP_EOL . $value->getFile() . ':' . $value->getLine() . PHP_EOL;
			}else{
				$message = (string)$value;
				$file = '';
			}
			$text = Formatter::bold('Message') . PHP_EOL . $message . PHP_EOL . $file . Formatter::bold('Level') . PHP_EOL . strtoupper($priority);
			$message = $this->messageFactory->createFromString($text, IMessage::TYPE_LOG, $priority);
			try{
				$this->sendSlackMessage($message);
			}catch(\Throwable $e){
				parent::log($e->getMessage(), ILogger::ERROR);
			}
		}

		return $logFile;
	}


	/**
	 * @param IMessage $message
	 * @throws \Exception
	 */
	private function sendSlackMessage(IMessage $message):void{
		@file_get_contents($this->hook, false, stream_context_create(
			['http' => ['method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'timeout' => $this->timeout,
				'content' => http_build_query(
					['payload' => json_encode(array_filter(['channel' => $message->getChannel(),
						'username' => $message->getName(),
						'icon_emoji' => $message->getIcon(),
						'attachments' =>
							[array_filter(['mrkdwn_in' => ['text', 'pretext'],
								'fallback' => $message->getText(),
								'text' => $message->getText(),
								'color' => $message->getColor(),
								'pretext' => $message->getTitle(),
								'ts' => (new \DateTime())->getTimestamp(),
							])],
					])),
					]),
			]]));
	}

}
