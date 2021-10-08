<?php

namespace TinyApps\YamlConfig;

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
	public static function init(string $filePath) {
		if (!file_exists($filePath)) {
			throw new ConfigNotFoundException();
		}

		if (
			(!$config = yaml_parse_file($filePath))
			|| !is_array($config)
		) {
			throw new ConfigParsingException();
		}

		foreach ($config as $key => $value) {
			putenv("$key=$value");
		}
	}
}
