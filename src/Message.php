<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


class Message implements IMessage{
    /** @var string|null */
    private $text;

    /** @var string|null */
    private $color;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $icon;

    /** @var string|null */
    private $channel;

    /**
     * Message constructor.
     * @param null|array $defaults
     */
    public function __construct(?array $defaults = null){
        if(!empty($defaults)){
            foreach(['text', 'color', 'title', 'name', 'icon', 'channel'] as $key){
                if(isset($defaults[$key])){
                    $this->$key = $defaults[$key];
                }
            }
        }
    }

    /**
     * @return string
     */
    public function __toString():string{
        return $this->text ?? '';
    }

	/**
	 * @param string|null $text
	 * @return Message
	 */
    public function setText(?string $text):IMessage{
        $this->text = $text;

        return $this;
    }

	/**
	 * @param string|null $color
	 * @return Message
	 */
    public function setColor(?string $color):IMessage{
        $this->color = $color;

        return $this;
    }

	/**
	 * @param string|null $title
	 * @return Message
	 */
    public function setTitle(?string $title):IMessage{
        $this->title = $title;

        return $this;
    }

	/**
	 * @param string|null $name
	 * @return Message
	 */
    public function setName(?string $name):IMessage{
        $this->name = $name;

        return $this;
    }

	/**
	 * @param string|null $icon
	 * @return Message
	 */
    public function setIcon(?string $icon):IMessage{
        $this->icon = $icon;

        return $this;
    }

	/**
	 * @param string|null $channel
	 * @return Message
	 */
    public function setChannel(?string $channel):IMessage{
        $this->channel = $channel;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getText():?string{
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getColor():?string{
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function getTitle():?string{
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getName():?string{
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getIcon():?string{
        return $this->icon;
    }

    /**
     * @inheritDoc
     */
    public function getChannel():?string{
        return $this->channel;
    }
}