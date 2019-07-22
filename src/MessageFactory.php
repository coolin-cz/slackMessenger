<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

use Tracy\ILogger;

final class MessageFactory implements IMessageFactory{
    /** @var array */
    private $defaults = [];

    /** @var array */
    private $specific = [];

    /**
     * MessageFactory constructor.
     * @param \stdClass $defaults
     */
    public function __construct(\stdClass $defaults){
        foreach(['color', 'title', 'name', 'icon', 'channel'] as $key){
            $this->defaults[$key] = $defaults->$key;
            $this->specific[IMessage::TYPE_LOG][$key] = $defaults->logger->$key;
            $this->specific[IMessage::TYPE_MESSAGE][$key] = $defaults->messenger->$key;
        }
    }

    public function createFromString(string $value, int $type = IMessage::TYPE_MESSAGE, string $priority = ILogger::INFO):IMessage{
	    $message = new Message();
	    $message->setText($value);
	    return $this->create($message, $type, $priority);
    }

    public function create(IMessage $value, int $type = IMessage::TYPE_MESSAGE, string $priority = ILogger::INFO):IMessage{
        $defaults = $this->getDefaults($type);
		/** @var Message $message */
        $message = $this->fillDefaults($value, $defaults);

        if($message->getColor() === null){
            switch($priority){
                case ILogger::DEBUG:
                    $message->setColor('#0AF');
                    break;
                case ILogger::WARNING:
                    $message->setColor('warning');
                    break;
                case ILogger::CRITICAL:
                case ILogger::ERROR:
                case ILogger::EXCEPTION:
                    $message->setColor('danger');
                    break;
                default:
                    $message->setColor($this->specific[$type]['color'] ?? $this->defaults['color']);
                    break;
            }
        }

        return $message;
    }

    /**
     * Add default configuration to already created Message
     * @param IMessage $message
     * @param array   $defaults
     * @return IMessage
     */
    private function fillDefaults(IMessage $message, array $defaults):IMessage{
        foreach(['color', 'title', 'name', 'icon', 'channel'] as $key){
            $setter = 'set'.ucfirst($key);
            $getter = 'get'.ucfirst($key);
            $message->$setter($message->$getter() ? $message->$getter() : $defaults[$key]);
        }

        return $message;
    }

    private function getDefaults(int $type):array{
    	return [
		    'color' => $this->specific[$type]['color'] ?? $this->defaults['color'],
		    'title' => $this->specific[$type]['title'] ?? $this->defaults['title'],
		    'name' => $this->specific[$type]['name'] ?? $this->defaults['name'],
		    'icon' => $this->specific[$type]['icon'] ?? $this->defaults['icon'],
		    'channel' => $this->specific[$type]['channel'] ?? $this->defaults['channel']
	    ];
    }
}