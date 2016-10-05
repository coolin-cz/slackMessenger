<?php
/**
 * @author: Radim Křek
 */

namespace krekos\SlackMessenger;


use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Validators;
use Tracy\Debugger;

class SlackExtension extends CompilerExtension{
	
	private $defaults = [
		'hook'=>null,
		'timeout' => 30,
		'messageFactory' => MessageFactory::class,
		'name' => 'SlackMessenger BOT',
		'title' => NULL,
		'color' => NULL,
		'channel' => NULL,
		'icon' => NULL,
		'logger'=>[
			'enabled' => true,
			'name' => NULL,
			'title' => NULL,
			'color' => NULL,
			'channel' => NULL,
			'icon' => NULL,
		],
		'messenger' => [
			'enabled' => true,
			'name' => NULL,
			'title' => NULL,
			'color' => NULL,
			'channel' => NULL,
			'icon' => NULL,
		]
	];
	
	public function loadConfiguration(){
		$conf = $this->getConfig($this->defaults);
		
		Validators::assertField($conf, 'hook', 'string');
		Validators::assertField($conf, 'channel', 'string');
		Validators::assertField($conf, 'timeout', 'int');
		Validators::assertField($conf['logger'], 'enabled', 'bool');
		Validators::assertField($conf['messenger'], 'enabled', 'bool');
		
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('messageFactory'))->setClass($conf['messageFactory'], [$conf]);
		
		if($conf['messenger']['enabled']){
			$builder->addDefinition($this->prefix('messenger'))->setClass(Messenger::class)->setArguments([$conf['hook'], $this->prefix('@messageFactory'), $conf['timeout']]);
		}
	}
	
	public function afterCompile(ClassType $class){
		$conf = $this->getConfig($this->defaults);
		$methods = $class->getMethods();
		
		if($conf['logger']['enabled']){
			$init = $methods['initialize'];
			$init->addBody(Debugger::class . '::setLogger(new ' . Logger::class . '(?, $this->getService(?), ?));', [$conf['hook'], $this->prefix('messageFactory'), $conf['timeout']]);
		}
	}
}