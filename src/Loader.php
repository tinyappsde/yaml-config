<?php

namespace TinyApps\YamlEnv;

use TinyApps\YamlEnv\Exceptions\ConfigNotFoundException;
use TinyApps\YamlEnv\Exceptions\ConfigParsingException;

class Loader {
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
