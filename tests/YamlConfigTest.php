<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TinyApps\YamlConfig\Config;
use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

final class YamlConfigTest extends TestCase {

	/**
	 * @throws ConfigParsingException
	 * @throws ConfigNotFoundException
	 */
	public function testLoader(): void {
		$config = new Config(__DIR__ . '/example-configs/env.yml');

		$this->assertEquals(
			'lorem ipsum',
			$config->get('test'),
		);
		$this->assertEquals(
			'lorem ipsum',
			$config['test'],
		);
	}

	public function testConfigDir(): void {
		Config::setConfigDir(__DIR__ . '/example-configs');
		$config = new Config('env');

		$this->assertEquals(
			'lorem ipsum',
			$config->get('test'),
		);
		$this->assertEquals(
			'lorem ipsum',
			$config['test'],
		);
	}

	public function testNotFoundException(): void {
		$this->expectException(ConfigNotFoundException::class);
		new Config('not_existing.yml');
	}

	public function testParsingException(): void {
		$this->expectException(ConfigParsingException::class);
		new Config('invalid');
	}
}
