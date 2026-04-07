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