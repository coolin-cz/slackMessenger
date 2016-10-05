<?php
/**
 * @author Radim Křek
 */

namespace krekos\SlackMessenger;

use Tracy\Debugger;

class Logger extends \Tracy\Logger
{

	/** @var string */
	private $hook;

	/** @var IMessageFactory */
	private $messageFactory;

	/** @var int */
	private $timeout;


	public function __construct($hook, IMessageFactory $messageFactory, $timeout)
	{
		parent::__construct(Debugger::$logDirectory, Debugger::$email, Debugger::getBlueScreen());
		$this->hook = $hook;
		$this->messageFactory = $messageFactory;
		$this->timeout = $timeout;
	}

	/**
	 * @inheritdoc
	 */
	public function log($value, $priority = self::INFO)
	{
		$logFile = parent::log($value, $priority);
		$message = $this->messageFactory->create($value, IMessage::TYPE_LOG , $priority);
		$this->sendSlackMessage($message);
		
		return $logFile;
	}


	/**
	 * @param IMessage $message
	 */
	private function sendSlackMessage(IMessage $message)
	{
		@file_get_contents($this->hook, NULL, stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'timeout' => $this->timeout,
				'content' => http_build_query([
					'payload' => json_encode(array_filter([
						'channel' => $message->getChannel(),
						'username' => $message->getName(),
						'icon_emoji' => $message->getIcon(),
						'attachments' => [array_filter([
							'fallback' => $message->getText(),
							'text' => $message->getText(),
							'color' => $message->getColor(),
							'pretext' => $message->getTitle(),
						])],
					]))
				]),
			],
		]));
	}

}
