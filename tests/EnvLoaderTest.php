<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TinyApps\YamlConfig\Exceptions\ConfigNotFoundException;
use TinyApps\YamlConfig\Exceptions\ConfigParsingException;
use TinyApps\YamlConfig\EnvLoader;

final class EnvLoaderTest extends TestCase {

	public function testLoader(): void {
		EnvLoader::init(__DIR__ . '/example-configs/env.yml');

		$this->assertEquals(
			'lorem ipsum',
			getenv('test'),
		);
	}

	public function testNotFoundException(): void {
		$this->expectException(ConfigNotFoundException::class);
		EnvLoader::init(__DIR__ . '/example-configs/not_existing.yml');
	}

	public function testParsingException(): void {
		$this->expectException(ConfigParsingException::class);
		EnvLoader::init(__DIR__ . '/example-configs/invalid.yml');
	}
}
