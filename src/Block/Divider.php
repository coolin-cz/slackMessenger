<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger\Block;

final class Divider extends Block{

	public function __construct(){
		$this->type = 'divider';
	}

	public function toArray():array{
		$block =  ['type' => $this->getType()];

		if($this->getBlockId() !== null){
			$block['block_id'] = $this->getBlockId();
		}

		return $block;
	}

}