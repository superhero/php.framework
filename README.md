#   Joppli  v.0.1

### PHP Framework

License: [MIT](https://opensource.org/licenses/MIT).

---

This documentation is very basic, the framework is developed by me to used by my self. If an interest is shown by others I will extend the documentation. Show interest by dropping me a line on twitter [@ErikLandvall](https://twitter.com/ErikLandvall) or simply star/follow/fork the project.

Specific characteristics of the framework: the possibility to use a series of dispatchers on each request.


## Skeleton

```
root
├─ config
│  └─ config.yml
├─ public
│  └─ index.php
├─ src
|  └─ HelloWorld
|     └─ HelloWorldDispatcher.php
└─ composer.json
```

### config/config.yml

```yaml
---
route:
- deliverer: Joppli\Deliverer\JsonDeliverer
- dispatchers:
  - HelloWorld\HelloWorldDispatcher
  policy:
  - validator: PathCompareValidator
    options:
      path: /
  - validator: MethodValidator
      options:
        method: get
...
```

The config file can be of what ever flavor you desire as long as you convert it to a php array in the end. I prefer [YAML](http://yaml.org/).

The config files branches are case insensitive, the leafs are not.

### public/index.php

```php
<?php

// Changes root directory
$root = dirname(__DIR__);
chdir($root);

// Auto loader
require 'vendor/autoload.php';

$parsers = ['yml' => new Joppli\Parser\YamlParser];
$paths   = ['config'];
$config  = (new Joppli\Config\ConfigFactory)->create($parsers, $paths);
$request = (new Joppli\Request\RequestFactory)->create();

// Run application
(new Joppli\Application\ApplicationBuilder)->build($config, $request)->run();
```

### src/HelloWorld/HelloWorldDispatcher.php

```php
<?php

namespace HelloWorld;

use Joppli\Dispatcher\Dispatcher;
use Joppli\Request\Aware\RequestAware;
use Joppli\Request\Aware\RequestAwareTrait;
use Joppli\Response\Aware\ResponseAware;
use Joppli\Response\Aware\ResponseAwareTrait;

class HelloWorldDispatcher implements Dispatcher, RequestAware, ResponseAware
{
  use
  RouteAwareTrait,
  UserAwareTrait;

  public function dispatch()
  {
    $host = $this->request->getHost();

    $this->response->message  = 'Hello world!';
    $this->response->host     = $host;
  }
}
```

The dispatcher only needs to implement the `Dispatcher` interface. However, this example also shows how to access the `Request` and `Response` instances by declaring awareness.

### composer.json

```json
{
  "autoload":
  {
    "psr-4":
    {
      "HelloWorld\\": "src/HelloWorld"
    }
  },

  "require":
  {
    "joppli/php-framework": "*"
  }
}
```
