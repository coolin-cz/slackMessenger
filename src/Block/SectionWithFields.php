<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

use Coolin\SlackMessenger\Block\BlockElement\ISection;
use Coolin\SlackMessenger\Exception\WrongNumberOfElements;
use Coolin\SlackMessenger\Exception\TextEmpty;

final class SectionWithFields extends Block{

	public const TYPE_MARKDOWN = 'mrkdwn';
	public const TYPE_PLAIN_TEXT = 'plain_text';

	protected const TEXT_MAX_LENGTH = 3000;
	protected const MAX_FIELDS = 10;

	/** @var string|null */
	protected $text;

	/** @var string */
	protected $textType = self::TYPE_MARKDOWN;

	/** @var Field[] */
	protected $fields = [];

	/** @var ISection|null */
	protected $accesory;

	public function __construct(){
		$this->type = 'section';
	}

	/**
	 * @param string $text
	 * @return SectionWithFields
	 * @throws TextEmpty
	 */
	public function setText(?string $text):SectionWithFields{
		if($text !== null){
			if($text === ''){
				throw new TextEmpty('Text can not be empty string');
			}
			$this->text = substr($text, 0, self::TEXT_MAX_LENGTH);
		}else{
			$this->text = $text;
		}

		return $this;
	}

	public function getText():?string{
		return $this->text;
	}

	public function markdown(bool $allow = true):SectionWithFields{
		$this->textType = $allow ? self::TYPE_MARKDOWN : self::TYPE_PLAIN_TEXT;

		return $this;
	}

	public function addField(string $text, bool $markdown = true):SectionWithFields{
		if($text === ''){
			throw new TextEmpty('Text can not be empty string');
		}

		if(count($this->fields) >= self::MAX_FIELDS){
			throw new WrongNumberOfElements('Section can contain maximum of '. self::MAX_FIELDS . ' fields.');
		}

		$this->fields[] = new Field($text, $markdown ? self::TYPE_MARKDOWN : self::TYPE_PLAIN_TEXT);

		return $this;
	}

	/** @return Field[] */
	public function getFields():array{
		return $this->fields;
	}

	public function addAccessory(ISection $element):SectionWithFields{
		$this->accesory = $element;

		return $this;
	}

	public function removeAccessorry():SectionWithFields{
		$this->accesory = null;

		return $this;
	}

	public function toArray():array{
		if(count($this->fields) === 0){
			throw new WrongNumberOfElements('Section must contain at least 1 field.');
		}

		$block = [
			'type' => $this->getType(),
		];

		if($this->getText() !== null){
			$block['text'] = [
				'type' => $this->textType,
				'text' => $this->getText(),
				'verbatim' => true,
			];
		}

		$fields = [];

		foreach($this->fields as $field){
			$fields[] = [
				'type' => $field->getType(),
				'text' => $field->getText(),
				'verbatim' => true,
			];
		}

		$block['fields'] = $fields;

		if($this->accesory !== null){
			$block['accessory'] = $this->accesory->toArray();
		}

		if($this->getBlockId() !== null){
			$block['block_id'] = $this->getBlockId();
		}

		return $block;
	}
}

final class Field{

	protected const TEXT_MAX_LENGTH = 2000;

	/** @var string */
	private $text;

	/** @var string */
	private $type;


	public function __construct(string $text, string $type = SectionWithFields::TYPE_MARKDOWN){
		$this->text = substr($text, 0, self::TEXT_MAX_LENGTH);
		$this->type = $type;
	}

	public function getText():string{
		return $this->text;
	}

	public function getType():string{
		return $this->type;
	}
}