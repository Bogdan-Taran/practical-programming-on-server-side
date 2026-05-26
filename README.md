Run tests:
```bash
vendor/bin/phpunit tests/
```
```bash
//comment this
// return require($this->getPathToMain());
//and uncommend this
ob_start();
require($this->getPathToMain());
return ob_get_clean();
```
```bash
composer install
```
По необходимости измените настроки подключения MySQL в
config/db.php

Также если проект NOT_FOUND Routes при запуске, то нужно изменить path
config/path.php