<?php

namespace Joppli\Dispatcher\Exception;

class BadRequestException extends \Exception implements HttpException
{
  public function __construct($message = 'Bad Request')
  {
    parent::__construct($message, 400);
  }
}