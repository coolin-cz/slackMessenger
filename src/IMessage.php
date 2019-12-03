<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


/**
 * Interface IMessage
 */
interface IMessage{

	public function getText():?string;

	public function setText(?string $text):self;

	public function getChannel():?string;

	public function setChannel(string $channel):self;

	public function addBlock(Block\IBlock $block):self;

	public function toArray():array;
}