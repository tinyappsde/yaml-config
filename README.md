[![Unit Tests](https://github.com/tinyappsde/yaml-config/actions/workflows/unit-test.yml/badge.svg?branch=master)](https://github.com/tinyappsde/yaml-config/actions/workflows/unit-test.yml)

# YAML Config
Simple PHP library for conveniently using yaml config files and (optional) loading into environment variables.

## Requirements
PHP ^8.0 or ^8.1 ~~and php-yaml extension~~ (v1.2.0 is based on symfony/yaml instead)

You can use v1.0.2 or lower for PHP 7.4 compatibility (requires the php-yaml extension though).

## Installation
`composer require tinyapps/yaml-config`

## Usage

### Config
```php
$config = new \TinyApps\YamlConfig\Config(__DIR__ . '/config.yml');

var_dump($config->get('your_variable')); // or
var_dump($config['your_variable']); // or
var_dump($config->your_variable);

// You can also set the config directory once for easier access
\TinyApps\YamlConfig\Config::setConfigDir(__DIR__ . '/example-configs');

$config = new Config('example'); // will read example-configs/example.yml
$config = new Config('sub/test'); // will read example-configs/sub/test.yml
```

### Load into environment variables
```php
TinyApps\YamlConfig\EnvLoader::init(__DIR__ . '/env.yml');
var_dump(getenv('your_environment_variable'));
```

### Get a single value from a config (static context)
```php
TinyApps\YamlConfig\Config::getConfigValue('example', 'property'); // returns the "property" value from example config
```
