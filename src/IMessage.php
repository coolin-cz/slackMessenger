<?php
/**
 * @author: Radim Křek
 */

namespace krekos\SlackMessenger;


/**
 * Interface IMessage
 * @package krekos\SlackMessenger
 */
interface IMessage{
	const TYPE_LOG = 0;
	const TYPE_MESSAGE = 1;

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text);

    /**
     * @param string $color
     * @return $this
     */
    public function setColor($color);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon);

    /**
     * @param string $channel
     * @return $this
     */
    public function setChannel($channel);

    /**
     * @return string
     */
    public function getText();

    /**
     * @return string
     */
    public function getColor();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return string
     */
    public function getChannel();
}