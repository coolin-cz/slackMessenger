<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

use Nette;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;

class SlackExtension extends CompilerExtension{

    public function getConfigSchema():Nette\Schema\Schema{
	    return Expect::structure([
	    	'hook' => Expect::string()->required(),
		    'channel' => Expect::string()->required(),
		    'timeout' => Expect::int(30),
		    'name' => Expect::string('SlackMessenger BOT'),
		    'icon' => Expect::string()->nullable(),
		    'messageFactory' => Expect::string(MessageFactory::class),
	    ]);
    }

	public function loadConfiguration():void{
        $conf = $this->getConfig();

        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('messageFactory'))->setFactory($conf->messageFactory, [$conf]);

        $builder->addDefinition($this->prefix('messenger'))->setClass(Messenger::class)->setArguments([$this->prefix('@messageFactory'), $conf->hook, $conf->timeout]);
    }
}