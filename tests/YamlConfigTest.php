<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TinyApps\YamlConfig\Config;
use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;

final class YamlConfigTest extends TestCase {

	public function testLoader(): void {
		$config = new Config(__DIR__ . '/env.yml');

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
		new Config(__DIR__ . '/not_existing.yml');
	}

	public function testParsingException(): void {
		$this->expectException(ConfigParsingException::class);
		new Config(__DIR__ . '/invalid.yml');
	}
}
