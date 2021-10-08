<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TinyApps\YamlEnv\Exceptions\ConfigNotFoundException;
use TinyApps\YamlEnv\Exceptions\ConfigParsingException;
use TinyApps\YamlEnv\Loader;

final class EnvLoaderTest extends TestCase {

	public function testLoader(): void {
		Loader::init(__DIR__ . '/env.yml');

		$this->assertEquals(
			'lorem ipsum',
			getenv('test'),
		);
	}

	public function testNotFoundException(): void {
		$this->expectException(ConfigNotFoundException::class);
		Loader::init(__DIR__ . '/not_existing.yml');
	}

	public function testParsingException(): void {
		$this->expectException(ConfigParsingException::class);
		Loader::init(__DIR__ . '/invalid.yml');
	}
}
