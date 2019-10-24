<?php
declare(strict_types=1);


namespace Coolin\SlackMessenger\Block\BlockElement;


interface IElement{

	public function getType():string;

	public function toArray():array;
}