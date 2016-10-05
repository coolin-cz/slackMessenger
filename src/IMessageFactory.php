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
	 * Create Message
	 * @param \Exception|\Throwable|IMessage|string $value
	 * @param int                                   $type
	 * @param string                                $priority
	 * @return IMessage
	 */
	function create($value, $type, $priority);
}