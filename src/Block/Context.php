<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

use Coolin\SlackMessenger\Block\BlockElement\IContext;
use Coolin\SlackMessenger\Exception\WrongNumberOfElements;

final class Context extends Block{

	public const MAX_ELEMENTS = 10;

	/** @var IContext[] */
	protected $elements = [];

	public function __construct(){
		$this->type = 'context';
	}

	public function addElement(IContext $element):Context{
		if(count($this->elements) >= self::MAX_ELEMENTS){
			throw new WrongNumberOfElements('Context can contain only maximum of ' . self::MAX_ELEMENTS . ' elements.');
		}

		$this->elements[] = $element;

		return $this;
	}

	/** @return IContext[] */
	public function getElements():array{
		return $this->elements;
	}

	public function toArray():array{
		if(count($this->elements) === 0){
			throw new WrongNumberOfElements('Context must contain at least 1 element.');
		}

		$block = ['type' => $this->getType()];
		foreach($this->elements as $element){
			$block['elements'][] = $element->toArray();
		}

		return $block;
	}
}