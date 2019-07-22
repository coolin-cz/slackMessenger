<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

use Nette;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Tracy\Debugger;

class SlackExtension extends CompilerExtension{

    public function getConfigSchema():Nette\Schema\Schema{
	    return Expect::structure([
	    	'hook' => Expect::string()->required(),
		    'channel' => Expect::string()->required(),
		    'timeout' => Expect::int(30),
		    'name' => Expect::string('SlackMessenger BOT'),
		    'title' => Expect::string()->nullable(),
		    'color' => Expect::string()->nullable(),
		    'icon' => Expect::string()->nullable(),
		    'logger' => Expect::structure([
		    	'enable' => Expect::bool(true),
			    'channel' => Expect::string()->nullable(),
			    'name' => Expect::string()->nullable(),
			    'title' => Expect::string()->nullable(),
			    'color' => Expect::string()->nullable(),
			    'icon' => Expect::string()->nullable(),
		    ]),
		    'messenger' => Expect::structure([
			    'enable' => Expect::bool(true),
			    'channel' => Expect::string()->nullable(),
			    'name' => Expect::string()->nullable(),
			    'title' => Expect::string()->nullable(),
			    'color' => Expect::string()->nullable(),
			    'icon' => Expect::string()->nullable(),
		    ]),
		    'messageFactory' => Expect::string(MessageFactory::class),
	    ]);
    }

	public function loadConfiguration():void{
        $conf = $this->getConfig();

        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('messageFactory'))->setFactory($conf->messageFactory, [$conf]);

        if($conf->messenger->enable){
            $builder->addDefinition($this->prefix('messenger'))->setClass(Messenger::class)->setArguments([$conf->hook, $this->prefix('@messageFactory'), $conf->timeout]);
        }
    }

    public function afterCompile(ClassType $class):void{
        $conf = $this->getConfig();
        $methods = $class->getMethods();

        if($conf->logger->enable){
            $init = $methods['initialize'];
            $init->addBody(Debugger::class.'::setLogger(new '.Logger::class.'(?, $this->getService(?), ?));', [$conf->hook, $this->prefix('messageFactory'), $conf->timeout]);
        }
    }
}