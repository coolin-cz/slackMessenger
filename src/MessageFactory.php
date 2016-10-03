<?php
/**
 * Created by PhpStorm.
 * User: radim
 * Date: 03.10.2016
 * Time: 8:35
 */

namespace krekos\SlackMessenger;


use Tracy\ILogger;

class MessageFactory implements IMessageFactory
{
    /** @var string */
    private $color;

    /** @var string */
    private $title;

    /** @var string */
    private $name;

    /** @var string */
    private $icon;

    /** @var string */
    private $channel;

    /**
     * MessageFactory constructor.
     * @param array $defaults
     */
    public function __construct($defaults)
    {
        foreach (['color', 'title', 'name', 'icon', 'channel'] as $key){
            if(isset($defaults[$key])){
                $this->$key = $defaults[$key];
            }
        }
    }


    /**
     * @inheritDoc
     */
    function create($value, $priority = ILogger::INFO)
    {
        $defaults = ['color' => $this->color, 'title' => $this->title, 'name' => $this->name, 'icon' => $this->icon, 'channel' => $this->channel];
        $message = new Message($defaults);

        if($value instanceof \Exception || $value instanceof \Throwable){
            $message->setText($value->getMessage());
        }else{
            $message->setText((string) $value);
        }

        switch($priority){
            case ILogger::INFO:
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
                $message->setColor($this->color);
                break;
        }

        return $message;
    }
}