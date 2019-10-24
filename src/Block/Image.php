<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

final class Image extends Block{

	/** @var string */
	protected $url;

	/** @var string */
	protected $altText;

	/** @var string|null */
	protected $title;

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

	public function setTitle(?string $title):Image{
		$this->title = $title;

		return $this;
	}

	public function getTitle():?string{
		return $this->title;
	}

	public function toArray():array{
		$block = [
			'type' => $this->getType(),
			'image_url' => $this->getUrl(),
			'alt_text' => $this->getAltText(),
		];

		if($this->getTitle() !== null){
			$block['title'] = [
				'type' => 'plain_text',
				'text' => $this->getTitle(),
			];
		}

		if($this->getBlockId() !== null){
			$block['block_id'] = $this->getBlockId();
		}

		return $block;
	}
}