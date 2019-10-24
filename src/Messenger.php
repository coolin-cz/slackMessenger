<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

class Messenger{

	/** @var string */
	private $hook;

	/** @var MessageFactory */
	private $messageFactory;

	/** @var int */
	private $timeout;

	public function __construct(IMessageFactory $messageFactory, string $hook, int $timeout){
		$this->hook = $hook;
		$this->messageFactory = $messageFactory;
		$this->timeout = $timeout;
	}

	public function send(IMessage $value, $hook = null):void{
		$message = $this->messageFactory->create($value);
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
				'content' => http_build_query(['payload' => json_encode($message->toArray(), JSON_THROW_ON_ERROR, 512)]),
			]]));
	}
}