<?php

namespace TinyApps\YamlConfig;

use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

class Config implements \ArrayAccess {
	protected array $values;

	/**
	 * Parse config file
	 *
	 * @param string $filePath
	 *
	 * @throws ConfigNotFoundException
	 * @throws ConfigParsingException
	 *
	 * @return void
	 */
	public function __construct(string $filePath) {
		if (!file_exists($filePath)) {
			throw new ConfigNotFoundException();
		}

		if (
			(!$config = yaml_parse_file($filePath))
			|| !is_array($config)
		) {
			throw new ConfigParsingException();
		}

		$this->values = $config;
	}

	public function offsetExists($key) {
		return isset($this->values[$key]);
	}

	public function offsetGet($key) {
		return $this->values[$key] ?? null;
	}

	public function get($key) {
		return $this->values[$key] ?? null;
	}

	public function offsetSet($key, $values) {
		throw new \BadMethodCallException('Cannot write to config files.');
	}

	public function offsetUnset($key) {
		throw new \BadMethodCallException('Cannot write to config files.');
	}
}
