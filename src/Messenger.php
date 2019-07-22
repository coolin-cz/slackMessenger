<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


use Tracy\ILogger;

class Messenger{

	/** @var string */
	private $hook;

	/** @var MessageFactory */
	private $messageFactory;

	/** @var int */
	private $timeout;

	public function __construct($hook, IMessageFactory $messageFactory, $timeout){
		$this->hook = $hook;
		$this->messageFactory = $messageFactory;
		$this->timeout = $timeout;
	}

	public function send(string $value, $priority = ILogger::INFO, $hook = null):void{
		$message = $this->messageFactory->createFromString($value, IMessage::TYPE_MESSAGE, $priority);
		$this->sendSlackMessage($message, $hook);
	}

	public function sendMessage(IMessage $value, $priority = ILogger::INFO, $hook = null):void{
		$message = $this->messageFactory->create($value, IMessage::TYPE_MESSAGE, $priority);
		$this->sendSlackMessage($message, $hook);
	}

	/**
	 * @param IMessage    $message
	 * @param string|null $hook
	 */
	private function sendSlackMessage(IMessage $message, ?string $hook = null):void{
		$slackHook = $hook ?? $this->hook;
		@file_get_contents($slackHook, false, stream_context_create(
			['http' => [
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'timeout' => $this->timeout,
				'content' => http_build_query(
					['payload' => json_encode(array_filter(
						['channel' => $message->getChannel(),
							'username' => $message->getName(),
							'icon_emoji' => $message->getIcon(),
							'attachments' =>
								[array_filter(['fallback' => $message->getText(),
									'text' => $message->getText(),
									'color' => $message->getColor(),
									'pretext' => $message->getTitle(),
								])],
						])),
					]),
			]]));
	}
}