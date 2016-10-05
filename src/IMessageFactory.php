<?php
/**
 * @author: Radim Křek
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