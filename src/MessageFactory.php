<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

use Coolin\SlackMessenger\Block\Section;

final class MessageFactory implements IMessageFactory{
    /** @var array */
    private $defaults = [];

    /**
     * MessageFactory constructor.
     * @param \stdClass $defaults
     */
    public function __construct(\stdClass $defaults){
        foreach(['name', 'icon', 'channel'] as $key){
            $this->defaults[$key] = $defaults->$key;
        }
    }

	/**
	 * @param string $value
	 * @return IMessage
	 * @throws Exception\TextEmpty
	 */
	public function createFromString(string $value):IMessage{
	    $message = new Message();
	    $message->addBlock(new Section($value));
	    return $this->create($message);
    }

    public function create(IMessage $value):IMessage{
		/** @var Message $message */
        $message = $this->fillDefaults($value);

        return $message;
    }

    /**
     * Add default configuration to already created Message
     * @param IMessage $message
     * @return IMessage
     */
    private function fillDefaults(IMessage $message):IMessage{
        foreach(['name', 'icon', 'channel'] as $key){
            $setter = 'set'.ucfirst($key);
            $getter = 'get'.ucfirst($key);
            $message->$setter($message->$getter() ?? $this->defaults[$key]);
        }

        return $message;
    }
}