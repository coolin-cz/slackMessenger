<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


/**
 * Interface IMessage
 */
interface IMessage{

    public function getName():?string;

    public function setName(string $name):self;

    public function getIcon():?string;

    public function setIcon(?string $icon):self;

    public function getChannel():?string;

    public function setChannel(string $channel):self;

    public function addBlock(Block\IBlock $block):self;

    public function toArray():array;
}