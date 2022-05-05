<?php

namespace TinyApps\YamlConfig;

use ArrayAccess;
use BadMethodCallException;
use Symfony\Component\Yaml\Yaml;
use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

class Config implements ArrayAccess {
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
	public static function setConfigDir(string $configDir): void {
		self::$configDir = $configDir;
	}

	/**
	 * Returns a single value from a config file in static context
	 *
	 * @param string $filePathOrName
	 * @param mixed $property
	 *
	 * @throws ConfigNotFoundException
	 * @throws ConfigParsingException
	 * @return mixed
	 */
	public static function singleValue(string $filePathOrName, mixed $property): mixed {
		$config = new self($filePathOrName);
		return $config[$property] ?? null;
	}

	/**
	 * Returns true if a config file with the given name or path exists
	 *
	 * @param string $filePathOrName
	 *
	 * @return bool
	 */
	public static function exists(string $filePathOrName): bool {
		$filePath = self::computedPath($filePathOrName);
		return file_exists($filePath);
	}

	/**
	 * Parse config file
	 *
	 * @param string $filePathOrName if config dir is set this will be prepended, if no extension is included it will be appended as .yml
	 *
	 * @throws ConfigNotFoundException
	 * @throws ConfigParsingException
	 *
	 * @return void
	 */
	public function __construct(string $filePathOrName) {
		$filePath = self::computedPath($filePathOrName);

		if (!file_exists($filePath)) {
			throw new ConfigNotFoundException("Config at $filePath not found.");
		}

		if (
			(!$config = Yaml::parseFile($filePath))
			|| !is_array($config)
		) {
			throw new ConfigParsingException();
		}

		$this->values = $config;
	}

	/**
	 * @param string $filePathOrName
	 *
	 * @return string
	 */
	protected static function computedPath(string $filePathOrName): string {
		if (!empty(self::$configDir)) {
			$filePathOrName = realpath(self::$configDir) . "/$filePathOrName";
		}

		if (
			!str_contains(strtolower($filePathOrName), '.yml')
			&& !str_contains(strtolower($filePathOrName), '.yaml')
		) {
			$filePathOrName .= '.yml';
		}

		return $filePathOrName;
	}

	public function offsetExists(mixed $offset): bool {
		return isset($this->values[$offset]);
	}

	public function offsetGet(mixed $offset): mixed {
		return $this->values[$offset] ?? null;
	}

	public function get(mixed $key): mixed {
		return $this->values[$key] ?? null;
	}

	public function offsetSet(mixed $offset, mixed $value): void {
		throw new BadMethodCallException('Cannot write to config files.');
	}

	public function offsetUnset(mixed $offset): void {
		throw new BadMethodCallException('Cannot write to config files.');
	}
}
