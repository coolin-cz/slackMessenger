<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block\BlockElement;

final class Image extends Element implements ISection, IContext{

	/** @var string */
	protected $url;

	/** @var string */
	protected $altText;

	public function __construct(string $url, string $altText){
		$this->type = 'image';
		$this->url = $url;
		$this->altText = $altText;
	}

	public function getUrl():string{
		return $this->url;
	}

	public function getAltText():string{
		return $this->altText;
	}

	public function toArray():array{
		return [
			'type' => $this->getType(),
			'image_url' => $this->getUrl(),
			'alt_text' => $this->getAltText(),
		];
	}
}