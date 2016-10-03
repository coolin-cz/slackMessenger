<?php
/**
 * Created by PhpStorm.
 * User: Práce
 * Date: 29.09.2016
 * Time: 15:42
 */

namespace krekos\SlackMessenger;


interface IMessageFactory{
	
	/**
	 * @param \Exception|\Throwable|string $value
	 * @param string $priority
	 * @return IMessage
	 */
	function create($value, $priority);
}