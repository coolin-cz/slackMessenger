<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

use Coolin\SlackMessenger\Block\BlockElement\ISection;
use Coolin\SlackMessenger\Exception\TextEmpty;

final class Section extends Block{

	public const TYPE_MARKDOWN = 'mrkdwn';
	public const TYPE_PLAIN_TEXT = 'plain_text';

	protected const TEXT_MAX_LENGTH = 3000;

	/** @var string */
	protected $text;

	/** @var string */
	protected $textType = self::TYPE_MARKDOWN;

	/** @var ISection|null */
	protected $accesory;

	/**
	 * @param string $text
	 * @throws TextEmpty
	 */
	public function __construct(string $text){
		$this->type = 'section';
		if($text === ''){
			throw new TextEmpty('Text can not be empty string');
		}
		$this->text = substr($text, 0, self::TEXT_MAX_LENGTH);
	}

	/**
	 * @param string $text
	 * @return Section
	 * @throws TextEmpty
	 */
	public function setText(string $text):Section{
		if($text === ''){
			throw new TextEmpty('Text can not be empty string');
		}
		$this->text = substr($text, 0, self::TEXT_MAX_LENGTH);

		return $this;
	}

	public function getText():string{
		return $this->text;
	}

	public function markdown(bool $allow = true):Section{
		$this->textType = $allow ? self::TYPE_MARKDOWN : self::TYPE_PLAIN_TEXT;

		return $this;
	}

	public function addAccessory(ISection $element):Section{
		$this->accesory = $element;

		return $this;
	}

	public function removeAccessorry():Section{
		$this->accesory = null;

		return $this;
	}

	public function toArray():array{
		$block = [
			'type' => $this->getType(),
			'text' => [
				'type' => $this->textType,
				'text' => $this->getText(),
				'verbatim' => true,
			],
		];

		if($this->accesory !== null){
			$block['accessory'] = $this->accesory->toArray();
		}

		if($this->getBlockId() !== null){
			$block['block_id'] = $this->getBlockId();
		}

		return $block;
	}
}