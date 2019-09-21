# iex-cloud
A PHP library that interfaces with the IEX Cloud API.

# Installation
The preferred way to install this extension is through composer.

Either run
```
php composer.phar require --prefer-dist michaeldrennen/iex-cloud
```
or add
```
"michaeldrennen/iex-cloud": "*"
```
to the require section of your composer.json.

# Usage

```php
use MichaelDrennen\IEXCloud\IEXCloud;

$iex = new IEXCloud('pk_key', 'sk_key', $sandbox = true);
$stock = $iex->stockStats('AAPL');
var_dump($stock);
```