<?php

namespace TinyApps\YamlConfig;

use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

class Config implements \ArrayAccess {
	protected array $values;
	protected static ?string $configDir = null;

	/**
	 * Set the config directory that will be used for all following config files
	 * Configs can be parsed with only the filename if the config dir is set
	 *
	 * @param string $configDir
	 *
	 * @return void
	 */
	public static function setConfigDir(string $configDir) {
		self::$configDir = $configDir;
	}

	/**
	 * Returns a single value from a config file in static context
	 *
	 * @param string $filePath
	 * @param mixed $property
	 *
	 * @return mixed
	 */
	public static function singleValue(string $filePath, mixed $property): mixed {
		$config = new self($filePath);
		return $config[$property] ?? null;
	}

	/**
	 * Parse config file
	 *
	 * @param string $filePath if config dir is set this will be prepended, if no extension is included it will be appended as .yml
	 *
	 * @throws ConfigNotFoundException
	 * @throws ConfigParsingException
	 *
	 * @return void
	 */
	public function __construct(string $filePath) {
		if (!empty(self::$configDir)) {
			$filePath = realpath(self::$configDir) . "/$filePath";
		}

		if (
			strpos(strtolower($filePath), '.yml') === false
			&& strpos(strtolower($filePath), '.yaml') === false
		) {
			$filePath .= '.yml';
		}

		if (!file_exists($filePath)) {
			throw new ConfigNotFoundException("Config at $filePath not found.");
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
