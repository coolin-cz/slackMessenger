<?php
/**
 * @author: Radim Křek
 */

namespace krekos\SlackMessenger;


use Tracy\ILogger;

class MessageFactory implements IMessageFactory
{
    /** @var array */
    private $defaults = [];
	
	/** @var array */
	private $specific = [];

    /**
     * MessageFactory constructor.
     * @param array $defaults
     */
    public function __construct($defaults)
    {
        foreach (['color', 'title', 'name', 'icon', 'channel'] as $key){
        	$this->defaults[$key] = $defaults[$key];
	        $this->specific[IMessage::TYPE_LOG][$key] = $defaults['logger'][$key];
	        $this->specific[IMessage::TYPE_MESSAGE][$key] = $defaults['messenger'][$key];
        }
    }


    /**
     * @inheritDoc
     */
    function create($value, $type = IMessage::TYPE_MESSAGE, $priority = ILogger::INFO)
    {
        $defaults = [
        		'color' => $this->specific[$type]['color'] ? $this->specific[$type]['color'] : $this->defaults['color'],
		        'title' => $this->specific[$type]['title'] ? $this->specific[$type]['title'] : $this->defaults['title'],
		        'name' => $this->specific[$type]['name'] ? $this->specific[$type]['name'] : $this->defaults['name'],
		        'icon' => $this->specific[$type]['icon'] ? $this->specific[$type]['icon'] : $this->defaults['icon'],
		        'channel' => $this->specific[$type]['channel'] ? $this->specific[$type]['channel'] : $this->defaults['channel']
        ];

        if($value instanceof \Exception || $value instanceof \Throwable){
	        $message = new Message($defaults);
            $message->setText($value->getMessage());
        }elseif($value instanceof IMessage){
        	$message = $this->fillDefaults($value, $defaults);
        }else{
	        $message = new Message($defaults);
            $message->setText((string) $value);
        }
        
		if($message->getColor() == null){
			switch($priority){
				case ILogger::DEBUG:
					$message->setColor('#0AF');
					break;
				case ILogger::WARNING:
					$message->seColor('warning');
					break;
				case ILogger::CRITICAL:
				case ILogger::ERROR:
					$message->setColor('#F00');
					break;
				default:
					$message->setColor($this->specific[$type]['color'] ? $this->specific[$type]['color'] : $this->defaults['color']);
					break;
			}
		}

        return $message;
    }
	
	/**
	 * Add default configuration to already created Message
	 * @param Message $message
	 * @param array   $defaults
	 * @return Message
	 */
	private function fillDefaults(Message $message, array $defaults){
	    foreach (['color', 'title', 'name', 'icon', 'channel'] as $key){
		    $setter = 'set'.ucfirst($key);
		    $getter = 'get'.ucfirst($key);
		    $message->$setter($message->$getter ? $message->$getter : $defaults[$key]);
	    }
	    
	    return $message;
    }
}