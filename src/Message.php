<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


use Coolin\SlackMessenger\Block\IBlock;

class Message implements IMessage{

	/**
	 * Text that appears in notification
	 *
	 * @var string|null
	 */
	protected $text;

	/** @var string|null */
	protected $channel;

	/** @var IBlock[] */
	protected $blocks = [];

	/**
	 * Message constructor.
	 * @param null|array $defaults
	 */
	public function __construct(?array $defaults = null){
		if(!empty($defaults)){
			foreach(['text', 'channel'] as $key){
				if(isset($defaults[$key])){
					$this->$key = $defaults[$key];
				}
			}
		}
	}

	public function getText():?string{
		return $this->text;
	}

	public function setText(?string $text):IMessage{
		$this->text = $text;

		return $this;
	}

	public function getChannel():?string{
		return $this->channel;
	}

	public function setChannel(string $channel):IMessage{
		$this->channel = $channel;

		return $this;
	}

	public function addBlock(IBlock $block):IMessage{
		$this->blocks[] = $block;

		return $this;
	}

	public function toArray():array{
		$payload = [];

		if($this->channel !== null){
			$payload['channel'] = $this->channel;
		}

		if($this->text !== null){
			$payload['text'] = $this->text;
		}

		$payload['blocks'] = [];
		foreach($this->blocks as $block){
			$payload['blocks'][] = $block->toArray();
		}

		return $payload;
	}
}