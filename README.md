# Arrounded/Assets

## Install

Via Composer

``` bash
$ composer require arrounded/assets
```

## Usage

### Assets pipeline

To use the assets pipeline create a `config/assets.php` file. In it you can define various collection of assets:

```php
<?php return [
    'global' => [
        'css' => [
            'foo.css',
        ],
    ],
    'admin'  => [
        'css' => ['admin.css'],
        'js'  => ['admin.js'],
    ],
];
```

Then add the facade to `config/app.php`:

```php
'Assets' => Arrounded\Assets\Facades\Assets::class,
```

Now in your views you can call this class to output a collection of assets:

```twig
{{ Assets.styles('global') }}
{{ Assets.scripts('admin') }}
```

### AssetsReplacer

When going to production, you don't want to leave the `Assets.styles` and `Assets.scripts` calls as is as they will return the assets individually.
The `AssetsReplacer` class will replace these calls with their actual values so `usemin` can read them and consume them.

```php
$replacer = new AssetsReplacer($assetsHandler);
$replacer->replaceInFolder('resources/views');
```

### JavascriptBridge

This is a class to pass data to the front-end. You can pass it as globals or namespaced. It's a static class so you can call it anywhere:

```php
JavascriptBridge::add(['foo' => 'bar']);
JavascriptBridge::render(); // var foo = "bar";

JavascriptBridge::setNamespace('Arrounded');
JavascriptBridge::add(['foo' => 'bar']);
JavascriptBridge::render(); // var Arrounded = {}; Arrounded.foo = "bar";
```

It can also render classes implementing the `Jsonable` interface.

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
