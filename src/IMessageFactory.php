<?php

namespace Coolin\SlackMessenger;


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