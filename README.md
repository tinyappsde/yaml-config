# YAML Env
Super simple PHP library for using yaml config files and (optional) loading into environment variables.

## Requirements
PHP ^7.4 or ^8.0 and php-yaml extension

## Installation
`composer require tinyapps/yaml-config`

## Usage

### Config
```php
$config = new \TinyApps\YamlConfig\Config(__DIR__ . '/config.yml');
var_dump($config->get('your_variable')); // or
var_dump($config['your_variable']);
```

### Load into environment variables
```php
TinyApps\YamlConfig\EnvLoader::init(__DIR__ . '/env.yml');
var_dump(getenv('your_environment_variable'));
```
