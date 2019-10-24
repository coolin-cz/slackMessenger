<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

abstract class Block implements IBlock{

	protected const BLOCK_ID_MAX_LENGTH = 255;

	/** @var string */
	protected $type;

	/** @var string|null */
	protected $blockId;

	final public function getType():string{
		return $this->type;
	}

	public function getBlockId():?string{
		return $this->blockId;
	}

	public function setBlockId(?string $id):IBlock{
		$this->blockId = $id !== null ? substr($id, 0, self::BLOCK_ID_MAX_LENGTH) : $id;

		return $this;
	}
}