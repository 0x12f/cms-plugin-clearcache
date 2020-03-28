ClearCache для WebSpace Engine
====
######(Плагин)

Плагин для очистки кеш данных.

#### Установка
Поместить в папку `plugin` и подключить в `index.php` добавив строку:
```php
// clearcache plugin
$plugins->register(new \Plugin\ClearCache\ClearCachePlugin($container));
```

#### License
Licensed under the MIT license. See [License File](LICENSE.md) for more information.
