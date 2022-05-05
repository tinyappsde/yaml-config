<?php

namespace TinyApps\YamlConfig;

use Symfony\Component\Yaml\Yaml;
use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

class EnvLoader {
	/**
	 * Parse config file into environment
	 *
	 * @param string $filePath
	 *
	 * @throws ConfigNotFoundException
	 * @throws ConfigParsingException
	 *
	 * @return void
	 */
	public static function init(string $filePath): void {
		if (!file_exists($filePath)) {
			throw new ConfigNotFoundException("Config at $filePath not found.");
		}

		if (
			!str_contains(strtolower($filePath), '.yml')
			&& !str_contains(strtolower($filePath), '.yaml')
		) {
			$filePath .= '.yml';
		}

		if (
			(!$config = Yaml::parseFile($filePath))
			|| !is_array($config)
		) {
			throw new ConfigParsingException();
		}

		foreach ($config as $key => $value) {
			putenv("$key=$value");
		}
	}
}
