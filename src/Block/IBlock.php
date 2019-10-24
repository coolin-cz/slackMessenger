<?php
declare(strict_types=1);


namespace Coolin\SlackMessenger\Block;


interface IBlock{

	public function getType():string;

	public function setBlockId(?string $id):self;

	public function getBlockId():?string;

	public function toArray():array;
}