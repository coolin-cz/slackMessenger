<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block\BlockElement;

final class Text extends Element implements IContext{

	public const TYPE_MARKDOWN = 'mrkdwn';
	public const TYPE_PLAIN_TEXT = 'plain_text';

	/** @var string */
	protected $text;

	public function __construct(string $text){
		$this->type = self::TYPE_MARKDOWN;
		$this->text = $text;
	}

	public function getText():string{
		return $this->text;
	}

	public function markdown(bool $allow):Text{
		$this->type = $allow ? self::TYPE_MARKDOWN : self::TYPE_PLAIN_TEXT;

		return $this;
	}

	public function toArray():array{
		return [
			'type' => $this->type,
			'text' => $this->getText()
		];
	}
}