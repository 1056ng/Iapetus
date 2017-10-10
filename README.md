# Phalcon Json Schema Validator Plugin

A simple plugin to validate parameter from Request in PHP with [justinrainbow/json-schema](https://github.com/justinrainbow/json-schema).


## Installation
Use composer to manage your dependencies and download:

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/1056ng/Iapetus"
      }
    ],
    "require": {
      "1056ng/Iapetus": "~1.0"
    }
}
```

## Example
### setup
```php
$eventsManager = new \Phalcon\Events\Manager();
$eventsManager->attach(\Iapetus\EventKeys::prefix, new \Iapetus\Middleware());
$app->setEventsManager($eventsManager);
```

### check
```php
function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Di\Injectable $injectable) {
  $di = $this->getDi();
  $body = $di->getRequest()->getJsonRawBody();
  $schemaPath = '/var/www/xxx/xxxxx.json';
  $di->getEventsManager()->fire(\Iapetus\EventKeys::check, $injectable, ['data' => $body, 'schema' => $schemaPath]);
}
```
