<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


interface IMessageFactory{

	/**
	 * Create Message
	 * @param IMessage $value
	 * @param int      $type
	 * @param string   $priority
	 * @return IMessage
	 */
	public function create(IMessage $value, int $type, string $priority):IMessage;

	/**
	 * Create Message
	 * @param string $value
	 * @param int    $type
	 * @param string $priority
	 * @return IMessage
	 */
	public function createFromString(string $value, int $type, string $priority):IMessage;
}