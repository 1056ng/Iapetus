<?php

namespace Iapetus;

class Middleware extends \Phalcon\Mvc\User\Plugin {

  public function check(\Phalcon\Events\Event $event, \Phalcon\Di\Injectable $injectable, array $data): void {
    $schemaPath = $data['schema'] ?? '';
    if (!file_exists($schemaPath)) {
      throw new Exception("not found json schema at {$schemaPath}", ExceptionCodes::notFoundJsonSchema);
    }

    $data = $data['data'] ?? (object)[];
    $validator = new \JsonSchema\Validator();
    $validator->validate($data, (object)['$ref' => "file://{$schemaPath}"]);
    if (!$validator->isValid()) {
      $error = new Exception('invalid validate', ExceptionCodes::invalidValidate);
      $error->setErrors($validator->getErrors());
      throw $error;
    }
  }
}
