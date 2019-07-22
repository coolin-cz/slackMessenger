# Slack Messenger

[![Latest Version](https://img.shields.io/packagist/v/coolin/slack-messenger.svg)](https://packagist.org/packages/coolin/slack-messenger)
[![Issues](https://img.shields.io/github/issues/coolin-cz/slackMessenger.svg)](https://github.com/coolin/slackMessenger/issues)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/coolin/slackMessenger/blob/master/LICENSE)

This Nette extension package allows you to log your errors and send messages to Slack.

## Instalation
- **Download**

`composer require coolin/slack-messenger`

- **Registration**
```yaml
extensions:
	slackMessenger: Coolin\SlackMessenger\SlackExtension
```

- **Minimal configuration**
```yaml
slackMessenger:
	hook: 'YOUR_SLACK_WEBHOOK'
	channel: '#general'
```

## Configuration
Package contains two services. Messenger and Logger. Both of them can be configured by global settings or, they can have specific configuration. If you use global and specific settings at once, specific setings will be always used.

```yaml
slackMessenger:
    hook: 'YOUR_SLACK_WEBHOOK'
    channel: '#globalChannel'
    timeout: 30
    name: 'Slack Bot'
    title: 'globalTitle'
    color: 'globalColor'
    icon: 'globalIcon'
    messenger:
        enabled: true
        channel: '#messengerChannel'
        name: 'Slack Bot'
        title: 'messengerTitle'
        color: 'messengerColor'
        icon: 'messengerIcon'
    logger:
        enabled: false
        channel: '#loggerChannel'
        name: 'Slack Bot'
        title: 'loggerTitle'
        color: 'loggerColor'
        icon: 'loggerIcon'
```

## Messenger
for sending messages from aplication you have to inject Messenger first. You can do in only if you have enabled Messenger in `config.neon`

```php
  /** @var \Coolin\SlackMessenger\Messenger @inject*/
  public $slack;
  
  public function send(){
    //variant 1    
    $this->slack->send('Your Message');
    
    //variant 2
    $message = new \Coolin\SlackMessenger\Message();
    $message->setChannel('#general');
    $message->setName('Awesome Bot');
    $message->setText('I\'m alive!');
    
    $this->slack->sendMessage($message);
    $this->slack->sendMessage($message, null, self::ALT_SLACK_HOOK); // ignore Slack hook from config and use specific one
  }
```

In both variants, if you omit some setting, default setting from `config.neon` will be used instead.


## Formatting
Class `Coolin\SlackMessenger\Formater` contains basic functions for text formatting.

```php
$message->setText('Normal text ' . Formatter::bold('bold text'));
```