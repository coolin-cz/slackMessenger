<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;


use Coolin\SlackMessenger\Block\IBlock;

class Message implements IMessage{

	/** @var string|null */
	protected $name;

	/** @var string|null */
	protected $icon;

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
			foreach(['name', 'icon', 'channel'] as $key){
				if(isset($defaults[$key])){
					$this->$key = $defaults[$key];
				}
			}
		}
	}

	public function getName():?string{
		return $this->name;
	}

	public function setName(string $name):IMessage{
		$this->name = $name;

		return $this;
	}

	public function getIcon():?string{
		return $this->icon;
	}

	public function setIcon(?string $icon):IMessage{
		$this->icon = $icon;

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
		if($this->icon !== null){
			$payload['icon'] = $this->icon;
		}
		if($this->name !== null){
			$payload['name'] = $this->name;
		}

		$payload['blocks'] = [];
		foreach($this->blocks as $block){
			$payload['blocks'][] = $block->toArray();
		}

		return $payload;
	}
}