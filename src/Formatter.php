<?php
declare(strict_types=1);

namespace Coolin\SlackMessenger;

final class Formatter{

	public static function bold(string $text):string{
		return '*'.$text.'*';
	}

	public static function italic(string $text):string{
		return '_'.$text.'_';
	}

	public static function code(string $text):string{
		return '`'.$text.'`';
	}

	public static function strike(string $text):string{
		return '~'.$text.'~';
	}

	/**
	 * @param $userId string - Slack user ID not username
	 * @return string
	 */
	public static function user(string $userId):string{
		return '<@'.$userId.'>';
	}
}