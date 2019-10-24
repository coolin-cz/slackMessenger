<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


interface IMessageFactory{

	/**
	 * Create Message
	 * @param IMessage $value
	 * @return IMessage
	 */
	public function create(IMessage $value):IMessage;

	/**
	 * Create Message
	 * @param string $value
	 * @return IMessage
	 */
	public function createFromString(string $value):IMessage;
}