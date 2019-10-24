<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block\BlockElement;

abstract class Element implements IElement{

	/** @var string */
	protected $type;

	final public function getType():string{
		return $this->type;
	}
}