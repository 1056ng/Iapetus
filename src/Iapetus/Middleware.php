<?php

namespace Iapetus;

class Middleware extends \Phalcon\Mvc\User\Plugin {

  public function getSchemaPath(): string {
    $di = $this->getDI();
    $config = $di->getConfig();
    $router = $di->getRouter();
    $request = $di->getRequest();

    $uriTemplate = new \Rize\UriTemplate();
    return $uriTemplate->expand('{+schemasDir}{+uri}/{+method}.json', [
      'schemasDir' => $config->application->schemasDir,
      'uri' => $router->getRewriteUri(),
      'method' => strtolower($request->getMethod()),
    ]);
  }

  public function check(\Phalcon\Events\Event $event, \Phalcon\Di\Injectable $injectable, $body): void {
    $schemaPath = $this->getSchemaPath();
    if (!file_exists($schemaPath)) {
      throw new Exception("not found json schema at {$schemaPath}", ExceptionCodes::notFoundJsonSchema);
    }

    $validator = new \JsonSchema\Validator();
    $validator->validate($body, (object)['$ref' => "file://{$schemaPath}"]);
    if (!$validator->isValid()) {
      $error = new Exception('invalid validate', ExceptionCodes::invalidValidate);
      $error->setErrors($validator->getErrors());
      throw $error;
    }
  }
}
