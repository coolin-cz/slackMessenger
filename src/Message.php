<?php
/**
 * @author: Radim Křek
 */

namespace krekos\SlackMessenger;


class Message implements IMessage
{
    /** @var string */
    private $text = null;

    /** @var string */
    private $color = null;

    /** @var string */
    private $title = null;

    /** @var string */
    private $name = null;

    /** @var string */
    private $icon = null;

    /** @var string */
    private $channel = null;

    /**
     * Message constructor.
     * @param null|array $defaults
     */
    public function __construct($defaults = null)
    {
        if(!empty($defaults)){
            foreach (['text', 'color', 'title', 'name', 'icon', 'channel'] as $key){
                if(isset($defaults[$key])){
                    $this->$key = $defaults[$key];
                }
            }
        }
    }


    /**
     * @return string
     */
    function __toString()
    {
        return $this->text;
    }


    /**
     * @inheritDoc
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getIcon()
    {
        // TODO: Implement getIcon() method.
    }

    /**
     * @inheritDoc
     */
    public function getChannel()
    {
        return $this->channel;
    }
}