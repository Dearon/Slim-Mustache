# Slim Mustache

This repository contains a custom View class for Mustache.php. 
You can use the custom View class by either requiring the appropriate class in your 
Slim Framework bootstrap file and initialize your Slim application using an instance of 
the selected View class or using Composer (the recommended way).


## How to Install

#### using [Composer](http://getcomposer.org/)

Create a composer.json file in your project root:
    
```json
{
    "require": {
        "dearon/slim-mustache": "0.1.*"
    }
}
```

Then run the following composer command:

```bash
$ php composer.phar install
```

## How to use
    
```php
<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    'view' => new \Slim\Mustache\Mustache()
));
```

To use Mustache options do the following:
    
```php
$view = $app->view();
$view->parserOptions = array(
    'charset' => 'ISO-8859-1'
);
```

## Authors

[Remco Meeuwissen](https://github.com/dearon)

## License

MIT Public License
