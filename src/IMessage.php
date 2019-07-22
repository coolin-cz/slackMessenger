<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


/**
 * Interface IMessage
 */
interface IMessage{
    public const TYPE_LOG = 0;
    public const TYPE_MESSAGE = 1;

    /**
     * @param string|null $text
     * @return $this
     */
    public function setText(?string $text):self;

    /**
     * @param string|null $color
     * @return $this
     */
    public function setColor(?string $color):self;

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title):self;

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name):self;

    /**
     * @param string|null $icon
     * @return $this
     */
    public function setIcon(?string $icon):self;

    /**
     * @param string|null $channel
     * @return $this
     */
    public function setChannel(?string $channel):self;

    /**
     * @return string|null
     */
    public function getText():?string;

    /**
     * @return string|null
     */
    public function getColor():?string;

    /**
     * @return string|null
     */
    public function getTitle():?string;

    /**
     * @return string|null
     */
    public function getName():?string;

    /**
     * @return string|null
     */
    public function getIcon():?string;

    /**
     * @return string|null
     */
    public function getChannel():?string;
}