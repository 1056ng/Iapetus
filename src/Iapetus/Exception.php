<?php

namespace Iapetus;

class Exception extends \Phalcon\Exception {
  protected $errors = [];

  public function getErrors(): array {
    return $this->errors;
  }

  public function setErrors(array $values): void {
    $this->errors = $values;
  }

}
